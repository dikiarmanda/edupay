<?php

namespace App\Http\Controllers;

use App\Models\MutationHistory;
use App\Services\PaymentApiService;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class TopupController extends Controller
{
    protected $paymentApiService;

    public function __construct(PaymentApiService $paymentApiService)
    {
        $this->paymentApiService = $paymentApiService;
    }

    /**
     * Menampilkan halaman top-up
     */
    public function index(Request $request)
    {
        $user = (object) session('auth');
        $tglAwal = $request->filled('tanggal_awal') ? $request->tanggal_awal : date('Y-m-01');
        $tglAkhir = $request->filled('tanggal_akhir') ? $request->tanggal_akhir : date('Y-m-d');

        // Ambil riwayat transaksi untuk tab riwayat dengan filter
        $transactionsQuery = TransactionHistory::where('merchant_kode', $user->merchant_kode)
            ->orderBy('created_at', 'desc');


        // Filter berdasarkan tanggal awal jika ada
        if ($request->filled('tanggal_awal')) {
            $transactionsQuery->whereDate('created_at', '>=', $tglAwal);
        }

        // Filter berdasarkan tanggal akhir jika ada
        if ($request->filled('tanggal_akhir')) {
            $transactionsQuery->whereDate('created_at', '<=', $tglAkhir);
        }

        $transactions = $transactionsQuery->get();

        // Cek status untuk transaksi pending
        $pending = $transactions->where('status', 'pending');
        foreach ($pending as $transaction) {
            try {
                $this->checkTransactionStatus($transaction);
            } catch (Exception $e) {
                Log::error('Error checking transaction status: ' . $e->getMessage(), [
                    'trx_id' => $transaction->trx_id,
                    'trace' => $e->getTrace()
                ]);
            }
        }

        // Refresh transactions setelah update status
        $transactions = $transactionsQuery->get();

        return view('topup.index', compact('transactions'));
    }

    /**
     * Membuat invoice untuk top-up
     */
    public function createInvoice(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:100000000', // Min 1k, Max 10jt
        ]);

        try {
            $user = (object) session('auth');
            $amount = $request->amount;

            // Generate unique transaction ID
            $trxId = $user->merchant_kode . '-' . Str::random(8);

            // Siapkan data untuk API
            $invoiceData = [
                'trx_id' => $trxId,
                'customer' => $user->nama,
                'product' => 'Top Up Saldo',
                'items' => json_encode([
                    [
                        'name' => 'Top Up Saldo',
                        'quantity' => 1,
                        'price' => $amount
                    ]
                ])
            ];

            // Panggil API untuk membuat invoice
            $invoiceResponse = $this->paymentApiService->createInvoice($invoiceData);

            // Simpan ke TransactionHistory sebagai pending
            $transaction = TransactionHistory::create([
                'trx_id' => $trxId,
                'nisn_siswa' => $user->nisn ?? null,
                'merchant_kode' => $user->merchant_kode,
                'customer_name' => $user->nama,
                'product' => 'Top Up Saldo',
                'amount' => $amount,
                'total_amount' => $amount,
                'status' => 'pending',
                'status_message' => 'Menunggu pembayaran',
                'gateway_response' => $invoiceResponse,
                'gateway_url' => str_replace('\\', '', $invoiceResponse['data']['paymentUrl']) ?? null,
                'gateway_reference' => $invoiceResponse['data']['reference'] ?? null,
                'expired_at' => isset($invoiceResponse['data']['expires_at']) ?
                    Carbon::parse($invoiceResponse['data']['expires_at']) :
                    now()->addHours(2)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dibuat',
                'data' => [
                    'trx_id' => $trxId,
                    'amount' => $amount,
                    'payment_url' => str_replace('\\', '', $invoiceResponse['data']['paymentUrl']) ?? null,
                    'expires_at' => isset($invoiceResponse['data']['expires_at']) ?
                        Carbon::parse($invoiceResponse['data']['expires_at']) :
                        now()->addHours(2),
                    'transaction_id' => $transaction->id,
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Create invoice error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengecek status transaksi dari objek TransactionHistory
     * Method private untuk digunakan internal
     */
    private function checkTransactionStatus($transaction)
    {
        try {
            // Jika sudah tidak pending, tidak perlu dicek
            if ($transaction->status !== 'pending') {
                return;
            }

            // Jika belum ada gateway_reference, tidak bisa dicek ke API
            if (!$transaction->gateway_reference) {
                Log::warning('Transaction tidak memiliki gateway_reference', [
                    'trx_id' => $transaction->trx_id
                ]);
                return;
            }

            // Cek status ke API
            $apiStatus = $this->paymentApiService->checkInvoiceStatus($transaction->gateway_reference);

            // Update status berdasarkan response API
            if (isset($apiStatus['status'])) {
                // Konversi status dari API (biasanya '1' untuk success, '0' atau lainnya untuk failed)
                $status = ($apiStatus['status'] == '1' || $apiStatus['status'] === 'success') ? 'success' : 'failed';

                $statusMessage = match ($status) {
                    'success' => 'Pembayaran berhasil',
                    'failed' => 'Pembayaran gagal',
                    default => 'Status tidak diketahui'
                };

                $transaction->updateStatus(
                    $status,
                    $statusMessage,
                    $apiStatus
                );

                // Jika berhasil, buat mutation history
                if ($status === 'success') {
                    $user = (object) session('auth');

                    // Cek apakah mutation history sudah ada untuk transaksi ini
                    $existingMutation = MutationHistory::where('code_callback', $transaction->trx_id)->first();

                    if (!$existingMutation) {
                        MutationHistory::create([
                            'code_callback' => $transaction->trx_id,
                            'nisn' => $user->nisn ?? $transaction->nisn_siswa,
                            'customer_name' => $user->nama ?? $transaction->customer_name,
                            'information' => 'Top Up Saldo',
                            'debet' => 0,
                            'kredit' => $transaction->amount,
                            'date_trx' => now(),
                            'merchant_name' => $user->merchant_kode ?? $transaction->merchant_kode,
                        ]);
                    }
                }
            }

        } catch (Exception $e) {
            Log::error('Error checking transaction status: ' . $e->getMessage(), [
                'trx_id' => $transaction->trx_id ?? null,
                'trace' => $e->getTrace()
            ]);
            throw $e;
        }
    }

    /**
     * Mengecek status pembayaran
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|string'
        ]);

        try {
            $trxId = $request->trx_id;
            $user = (object) session('auth');

            // Cek dari database dulu
            $transaction = TransactionHistory::where('trx_id', $trxId)->first();

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            // Jika masih pending, cek ke API menggunakan method private
            if ($transaction->status === 'pending') {
                $this->checkTransactionStatus($transaction);
                // Refresh transaction untuk mendapatkan data terbaru
                $transaction->refresh();
            }

            return response()->json([
                'success' => true,
                'data' => $transaction->getTransactionDetails()
            ]);

        } catch (Exception $e) {
            Log::error('Check status error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek status: ' . $e->getMessage()
            ], 500);
        }
    }
}
