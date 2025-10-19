<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $table = 'riwayat_transaksi';

    protected $fillable = [
        'trx_id',
        'nisn_siswa',
        'merchant_kode',
        'customer_name',
        'product',
        'amount',
        'total_amount',
        'status',
        'status_message',
        'gateway_response',
        'gateway_url',
        'gateway_reference',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'amount' => 'decimal:0',
        'total_amount' => 'decimal:0',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'gateway_response' => 'array',
    ];

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan merchant
     */
    public function scopeByMerchant($query, $merchantKode)
    {
        return $query->where('merchant_kode', $merchantKode);
    }

    /**
     * Scope untuk filter berdasarkan NISN siswa
     */
    public function scopeByNisn($query, $nisn)
    {
        return $query->where('nisn_siswa', $nisn);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope untuk transaksi yang belum expired
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expired_at')
                ->orWhere('expired_at', '>', now());
        });
    }

    /**
     * Scope untuk transaksi yang sudah expired
     */
    public function scopeExpired($query)
    {
        return $query->where('expired_at', '<=', now());
    }

    /**
     * Accessor untuk format amount dengan pemisah ribuan
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Accessor untuk format total amount dengan pemisah ribuan
     */
    public function getFormattedTotalAmountAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Accessor untuk status dalam bahasa Indonesia
     */
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'pending' => 'Tertunda',
            'success' => 'Berhasil',
            'failed' => 'Gagal',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Accessor untuk warna status
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'success' => 'green',
            'failed' => 'red',
            default => 'gray'
        };
    }

    /**
     * Accessor untuk mengecek apakah transaksi sudah expired
     */
    public function getIsExpiredAttribute()
    {
        return $this->expired_at && $this->expired_at->isPast();
    }

    /**
     * Accessor untuk mengecek apakah transaksi masih pending
     */
    public function getIsPendingAttribute()
    {
        return $this->status === 'pending' && !$this->is_expired;
    }

    /**
     * Accessor untuk mengecek apakah transaksi berhasil
     */
    public function getIsSuccessAttribute()
    {
        return $this->status === 'success';
    }

    /**
     * Accessor untuk mengecek apakah transaksi gagal
     */
    public function getIsFailedAttribute()
    {
        return $this->status === 'failed';
    }

    /**
     * Method untuk update status transaksi
     */
    public function updateStatus($status, $statusMessage = null, $gatewayResponse = null)
    {
        $this->status = $status;

        if ($statusMessage) {
            $this->status_message = $statusMessage;
        }

        if ($gatewayResponse) {
            $this->gateway_response = $gatewayResponse;
        }

        if ($status === 'success') {
            $this->paid_at = now();
        }

        $this->save();

        return $this;
    }

    /**
     * Method untuk mengecek apakah transaksi bisa dibatalkan
     */
    public function canBeCancelled()
    {
        return $this->status === 'pending' && !$this->is_expired;
    }

    /**
     * Method untuk membatalkan transaksi
     */
    public function cancel($reason = null)
    {
        if (!$this->canBeCancelled()) {
            return false;
        }

        $this->updateStatus('failed', $reason ?: 'Transaksi dibatalkan');

        return true;
    }

    /**
     * Method untuk mendapatkan waktu tersisa sebelum expired
     */
    public function getTimeRemaining()
    {
        if (!$this->expired_at || $this->is_expired) {
            return null;
        }

        return $this->expired_at->diffForHumans();
    }

    /**
     * Method untuk mendapatkan detail transaksi dalam format array
     */
    public function getTransactionDetails()
    {
        return [
            'id' => $this->id,
            'trx_id' => $this->trx_id,
            'customer_name' => $this->customer_name,
            'product' => $this->product,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'formatted_amount' => $this->formatted_amount,
            'formatted_total_amount' => $this->formatted_total_amount,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'status_color' => $this->status_color,
            'status_message' => $this->status_message,
            'gateway_url' => $this->gateway_url,
            'gateway_reference' => $this->gateway_reference,
            'paid_at' => $this->paid_at?->format('d M Y H:i'),
            'expired_at' => $this->expired_at?->format('d M Y H:i'),
            'created_at' => $this->created_at->format('d M Y H:i'),
            'is_expired' => $this->is_expired,
            'is_pending' => $this->is_pending,
            'is_success' => $this->is_success,
            'is_failed' => $this->is_failed,
            'time_remaining' => $this->getTimeRemaining(),
        ];
    }
}
