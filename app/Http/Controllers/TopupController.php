<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\MutationHistory;
use App\Models\TransactionHistory;
use App\Services\PaymentApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
        $tglAwal = $request->filled('start_date') ? $request->start_date : date('Y-m-01');
        $tglAkhir = $request->filled('end_date') ? $request->end_date : date('Y-m-d');

        // Ambil riwayat transaksi untuk tab riwayat dengan filter
        $transactionsQuery = TransactionHistory::where('merchant_kode', $user->merchant_kode)
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan tanggal awal jika ada
        if ($request->filled('start_date')) {
            $transactionsQuery->whereDate('created_at', '>=', $tglAwal);
        }

        // Filter berdasarkan tanggal akhir jika ada
        if ($request->filled('end_date')) {
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
                'redirect' => route('topup.callback'),
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
                    now()->addHours(1)
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
                        now()->addHours(1),
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
            $user = (object) session('auth');

            // Cek status ke API
            $apiStatus = $this->paymentApiService->checkInvoiceStatus($transaction->gateway_reference);

            // Update status berdasarkan response API
            if (isset($apiStatus['status'])) {
                $status = ($apiStatus['status'] == '1' || $apiStatus['status'] === 'success') ? 'success' : 'failed';

                $statusMessage = match ($status) {
                    'success' => 'Top Up Saldo berhasil',
                    'failed' => 'Top Up Saldo gagal',
                    default => 'Status tidak diketahui'
                };

                // cek belum expired_at
                if ($transaction->expired_at > now()) {
                    return;
                }

                $transaction->updateStatus($status, $statusMessage, $apiStatus);

                // Jika berhasil, buat mutation history
                if ($status === 'success') {

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

                Notification::create([
                    'merchant_kode' => $transaction->merchant_kode,
                    'judul' => $statusMessage,
                    'pesan' => 'Top Up Saldo sebesar Rp ' . number_format($transaction->amount, 0, ',', '.') . ($apiStatus['status'] == '1' ? ' berhasil' : ' gagal') . ' diproses.',
                    'tipe' => $apiStatus['status'] == '1' ? 'success' : 'error',
                    'is_read' => false,
                ]);
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

    /**
     * Callback sekaligus halaman detail topup.
     * Menerima payload dari gateway pembayaran (POST JSON) atau menampilkan detail (GET).
     */
    public function callback(Request $request)
    {
        try {
            $payload = $request->all();

            // Ambil data invoice dari API berdasarkan parameter dari payload
            $invoiceApiData = null;
            $apiParams = [];

            // Ambil parameter yang mungkin diperlukan untuk API (reference, orderid, dll)
            if (isset($payload['invoice']['reference'])) {
                $apiParams['id'] = $payload['invoice']['reference'];
            } elseif (isset($payload['invoice']['orderid'])) {
                $apiParams['orderid'] = $payload['invoice']['orderid'];
            } elseif ($request->has('reference')) {
                $apiParams['id'] = $request->input('reference');
            } elseif ($request->has('orderid')) {
                $apiParams['orderid'] = $request->input('orderid');
            }

            // Ambil data dari API jika ada parameter
            if (!empty($apiParams)) {
                try {
                    $queryString = http_build_query($apiParams);
                    $apiUrl = 'https://pay.amzhadigitalnusantara.co.id/invoice/data?' . $queryString;

                    $response = Http::withoutVerifying()
                        ->timeout(10)
                        ->get($apiUrl);

                    if ($response->successful()) {
                        $invoiceApiData = $response->json();
                        Log::info('Invoice data fetched from API', [
                            'params' => $apiParams,
                            'response' => $invoiceApiData
                        ]);
                    } else {
                        Log::warning('Failed to fetch invoice data from API', [
                            'params' => $apiParams,
                            'status' => $response->status(),
                            'response' => $response->body()
                        ]);
                    }
                } catch (Exception $e) {
                    Log::error('Error fetching invoice data from API: ' . $e->getMessage(), [
                        'params' => $apiParams,
                        'trace' => $e->getTrace()
                    ]);
                }
            }

            // Normalisasi struktur data
            $invoice = $invoiceApiData['invoice'] ?? null;
            $statusRaw = $invoiceApiData['status'] ?? ($invoice['status'] ?? null);

            $trxId = $invoice['orderid'] ?? $request->query('trx_id');

            $transaction = null;
            if ($trxId) {
                $transaction = TransactionHistory::where('trx_id', $trxId)->first();
            }

            // Jika ada payload dari gateway atau data dari API, proses update
            if ($invoice && $trxId && $transaction) {
                // Prioritaskan data dari API jika tersedia, jika tidak gunakan dari payload
                $invoiceData = $invoiceApiData && isset($invoiceApiData['invoice']) ? $invoiceApiData['invoice'] : $invoice;

                $gatewayReference = $invoiceData['reference'] ?? null;
                $amount = isset($invoiceData['amount']) ? (int) $invoiceData['amount'] : ($transaction->amount ?? 0);
                $paidAt = $invoiceData['tgljam'] ?? null;

                // Konversi status - prioritaskan dari API jika tersedia
                $finalStatus = $invoiceApiData && isset($invoiceApiData['status']) ? $invoiceApiData['status'] : $statusRaw;
                $normalizedStatus = (string) $finalStatus === '1' || $finalStatus === 1 || $finalStatus === 'success' ? 'success' : 'failed';
                $statusMessage = $normalizedStatus === 'success' ? 'Pembayaran berhasil' : 'Pembayaran gagal';

                // Simpan response gateway & field terkait (termasuk data API jika ada)
                $fullResponse = array_merge($payload, ['api_data' => $invoiceApiData]);
                $transaction->gateway_reference = $gatewayReference ?: $transaction->gateway_reference;
                $transaction->amount = $amount;
                $transaction->total_amount = $amount;
                if ($paidAt) {
                    $transaction->paid_at = Carbon::parse($paidAt);
                }
                $transaction->gateway_response = $fullResponse;
                $transaction->save();

                // Update status menggunakan helper model
                $transaction->updateStatus($normalizedStatus, $statusMessage);

                // Buat MutationHistory jika sukses dan belum ada
                if ($normalizedStatus === 'success') {
                    $existingMutation = MutationHistory::where('code_callback', $transaction->trx_id)->first();
                    if (!$existingMutation) {
                        MutationHistory::create([
                            'code_callback' => $transaction->trx_id,
                            'nisn' => $transaction->nisn_siswa,
                            'customer_name' => $invoiceData['nama'] ?? $transaction->customer_name,
                            'information' => $invoiceData['product'] ?? 'Top Up Saldo',
                            'debet' => 0,
                            'kredit' => $amount,
                            'date_trx' => $paidAt ? Carbon::parse($paidAt) : now(),
                            'merchant_name' => $transaction->merchant_kode,
                        ]);
                    }
                }
            }

            // Build data untuk tampilan detail
            $detail = null;
            if ($transaction) {
                $detail = $transaction->getTransactionDetails();
            } else if ($invoice || ($invoiceApiData && isset($invoiceApiData['invoice']))) {
                // Fallback jika transaksi tidak ditemukan tetapi ingin tetap menampilkan payload atau data API
                // Prioritaskan data dari API jika tersedia
                $invoiceData = $invoiceApiData && isset($invoiceApiData['invoice']) ? $invoiceApiData['invoice'] : $invoice;
                $finalStatus = $invoiceApiData && isset($invoiceApiData['status']) ? $invoiceApiData['status'] : $statusRaw;

                // Decode items jika berupa string JSON
                $itemsRaw = $invoiceData['items'] ?? null;
                $items = $itemsRaw;
                if (is_string($itemsRaw)) {
                    try {
                        $items = json_decode($itemsRaw, true) ?: $itemsRaw;
                    } catch (\Throwable $e) {
                        $items = $itemsRaw;
                    }
                }

                $detail = [
                    'trx_id' => $trxId ?: ($invoiceData['orderid'] ?? null),
                    'customer_name' => $invoiceData['nama'] ?? null,
                    'product' => $invoiceData['product'] ?? 'Top Up Saldo',
                    'amount' => isset($invoiceData['amount']) ? (int) $invoiceData['amount'] : null,
                    'total_amount' => isset($invoiceData['amount']) ? (int) $invoiceData['amount'] : null,
                    'status' => ((string) $finalStatus === '1' || $finalStatus === 1 || $finalStatus === 'success') ? 'success' : 'failed',
                    'gateway_reference' => $invoiceData['reference'] ?? null,
                    'paid_at' => isset($invoiceData['tgljam']) ? Carbon::parse($invoiceData['tgljam'])->format('d M Y H:i') : null,
                    'created_at' => isset($invoiceData['tgljam']) ? Carbon::parse($invoiceData['tgljam'])->format('d M Y H:i') : null,
                    'items' => $items,
                ];
            }

            // Jika request menginginkan JSON
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'payload' => $payload,
                        'detail' => $detail,
                    ]
                ]);
            }

            return view('topup.callback', [
                'payload' => $payload,
                'detail' => $detail,
                'invoiceApiData' => $invoiceApiData,
            ]);

        } catch (Exception $e) {
            Log::error('Topup callback error: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses callback: ' . $e->getMessage(),
                ], 500);
            }

            return response()->view('topup.callback', [
                'payload' => $request->all(),
                'detail' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
