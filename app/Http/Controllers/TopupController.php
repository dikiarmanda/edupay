<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $user = (object) session('auth');

        // Ambil riwayat transaksi untuk tab riwayat
        $transactions = TransactionHistory::where('merchant_kode', $user->merchant_kode)
            ->orderBy('created_at', 'desc')
            ->get();

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

            // Simpan ke database sebagai pending
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
                    now()->addHours(24)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dibuat',
                'data' => [
                    'trx_id' => $trxId,
                    'amount' => $amount,
                    'payment_url' => $invoiceResponse['payment_url'] ?? null,
                    'expires_at' => $invoiceResponse['expires_at'] ?? null,
                    'transaction_id' => $transaction->id
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
            $transaction = TransactionHistory::where('trx_id', $trxId)
                ->where('merchant_kode', $user->merchant_kode)
                ->first();

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            // Jika masih pending, cek ke API
            if ($transaction->status === 'pending') {
                $apiStatus = $this->paymentApiService->checkInvoiceStatus($trxId);

                // Update status berdasarkan response API
                if (isset($apiStatus['status'])) {
                    $transaction->updateStatus(
                        $apiStatus['status'],
                        $apiStatus['message'] ?? null,
                        $apiStatus
                    );

                    // Jika berhasil, update saldo user (jika ada field saldo)
                    if ($apiStatus['status'] === 'success' && isset($user->saldo)) {
                        $user->saldo += $transaction->amount;
                        // Simpan kembali ke session atau database sesuai kebutuhan
                    }
                }
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

    /**
     * Webhook untuk update status dari API eksternal
     */
    public function webhook(Request $request)
    {
        try {
            $trxId = $request->input('trx_id');
            $status = $request->input('status');

            if (!$trxId || !$status) {
                return response()->json(['error' => 'Missing required parameters'], 400);
            }

            $transaction = TransactionHistory::where('trx_id', $trxId)->first();

            if (!$transaction) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }

            // Update status menggunakan method dari model
            $transaction->updateStatus($status, $request->input('status_message'), $request->all());

            // Jika berhasil, update saldo user (jika diperlukan)
            if ($status === 'success') {
                // Logika update saldo bisa ditambahkan di sini
                Log::info('Transaction completed successfully', [
                    'trx_id' => $trxId,
                    'amount' => $transaction->amount
                ]);
            }

            Log::info('Webhook processed successfully', [
                'trx_id' => $trxId,
                'status' => $status
            ]);

            return response()->json(['success' => true]);

        } catch (Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
