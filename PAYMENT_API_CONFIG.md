# Konfigurasi API Payment

Tambahkan konfigurasi berikut ke file `.env` Anda:

```env
# Payment API Configuration
PAYMENT_API_BASE_URL=https://pay.amzadigitalnusantara.com
PAYMENT_API_USERNAME=your_username_here
PAYMENT_API_PASSWORD=your_password_here
PAYMENT_API_TIMEOUT=30
```

## Cara Penggunaan

1. **Mendapatkan Username dan Password**: Hubungi penyedia API untuk mendapatkan credentials
2. **Update .env**: Ganti `your_username_here` dan `your_password_here` dengan credentials yang benar
3. **Test Koneksi**: Jalankan aplikasi dan coba fitur top-up

## Endpoint yang Digunakan

-   **Authentication**: `POST /auth/login`
-   **Create Invoice**: `POST /create_invoice`
-   **Check Status**: `GET /invoice/status/{trx_id}`

## Parameter Create Invoice

-   `trx_id`: ID transaksi unik
-   `customer`: Nama customer
-   `product`: Nama produk (Top Up Saldo)
-   `items`: JSON array berisi detail item

## Database Schema

Tabel `transaction_histories` telah dibuat dengan struktur:

-   `id`: Primary key (bigint)
-   `trx_id`: ID transaksi unik (varchar 100)
-   `nisn_siswa`: NISN siswa (varchar 20)
-   `merchant_kode`: Kode merchant (varchar 50)
-   `customer_name`: Nama customer (varchar 255)
-   `product`: Nama produk (varchar 255)
-   `amount`: Jumlah transaksi (decimal 15,0)
-   `total_amount`: Total amount (decimal 15,0)
-   `status`: Status transaksi (enum: pending, success, failed)
-   `status_message`: Pesan status (text)
-   `gateway_response`: Response dari gateway (longtext)
-   `gateway_url`: URL gateway (varchar 100)
-   `gateway_reference`: Reference gateway (varchar 100)
-   `paid_at`: Waktu pembayaran (timestamp)
-   `expired_at`: Waktu expired (timestamp)
-   `created_at`, `updated_at`: Timestamps

## Webhook

Sistem mendukung webhook untuk update status otomatis:

-   **URL**: `/topup/webhook`
-   **Method**: POST
-   **Parameters**: `trx_id`, `status`, `status_message`
