<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentApiService
{
    private $baseUrl;
    private $apiUsername;
    private $apiPassword;
    private $token;

    public function __construct()
    {
        $this->baseUrl = config('services.payment_api.base_url');
        $this->apiUsername = config('services.payment_api.api_username');
        $this->apiPassword = config('services.payment_api.api_password');
    }

    /**
     * Mendapatkan token autentikasi dari API
     */
    public function authenticate()
    {
        try {
            // Log untuk debugging
            // Log::info('Credentials check', [
            //     'username' => $this->apiUsername,
            //     'password' => $this->apiPassword,
            //     'password_length' => strlen($this->apiPassword ?? ''),
            //     'base_url' => $this->baseUrl,
            // ]);

            $response = Http::withoutVerifying()->asForm()
                ->post($this->baseUrl . '/api/auth', [
                    'username' => $this->apiUsername,
                    'password' => $this->apiPassword
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->token = $data['token'] ?? null;

                if ($this->token) {
                    Log::info('Payment API authentication successful');
                    return true;
                }
            }

            Log::error('Payment API authentication failed', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return false;
        } catch (Exception $e) {
            Log::error('Payment API authentication error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Membuat invoice untuk pembayaran
     */
    public function createInvoice($data)
    {
        // Pastikan token tersedia
        if (!$this->token && !$this->authenticate()) {
            throw new Exception('Failed to authenticate with payment API');
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ])->asForm()->post($this->baseUrl . '/api/create_invoice', [
                        'trx_id' => $data['trx_id'],
                        'customer' => $data['customer'],
                        'product' => $data['product'],
                        'items' => $data['items'],
                        'redirect' => $data['redirect']
                    ]);

            if ($response->successful()) {
                Log::info('Invoice created successfully', [
                    'trx_id' => $data['trx_id'],
                    'response' => $response->json()
                ]);

                return $response->json();
            }

            Log::error('Failed to create invoice', [
                'status' => $response->status(),
                'response' => $response->body(),
                'data' => $data
            ]);

            throw new Exception('Failed to create invoice: ' . $response->body());

        } catch (Exception $e) {
            Log::error('Create invoice error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mengecek status invoice
     */
    public function checkInvoiceStatus($gateway_reference)
    {
        if (!$this->token && !$this->authenticate()) {
            throw new Exception('Failed to authenticate with payment API');
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/invoice/data?id=' . $gateway_reference);
            Log::info('Response Cek Invoice Status : ' . $response);
            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception('Failed to check invoice status: ' . $response->body());

        } catch (Exception $e) {
            Log::error('Check invoice status error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mendapatkan token saat ini
     */
    public function getToken()
    {
        return $this->token;
    }
}
