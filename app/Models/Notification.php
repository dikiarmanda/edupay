<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'merchant_kode',
        'judul',
        'pesan',
        'tipe',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scope untuk notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk notifikasi yang sudah dibaca
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    // Scope untuk notifikasi berdasarkan tipe
    public function scopeByType($query, $type)
    {
        return $query->where('tipe', $type);
    }

    // Scope untuk notifikasi berdasarkan NISN
    public function scopeByNisn($query, $nisn)
    {
        return $query->where('nisn', $nisn);
    }

    // Scope untuk notifikasi berdasarkan merchant kode
    public function scopeByMerchant($query, $merchantKode)
    {
        return $query->where('merchant_kode', $merchantKode);
    }

    // Method untuk menandai notifikasi sebagai sudah dibaca
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    // Method untuk menandai notifikasi sebagai belum dibaca
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    // Method untuk mendapatkan class CSS berdasarkan tipe
    public function getTypeClass()
    {
        return match ($this->tipe) {
            'info' => 'bg-blue-100 text-blue-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            'success' => 'bg-green-100 text-green-800',
            'error' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Method untuk mendapatkan icon berdasarkan tipe
    public function getTypeIcon()
    {
        return match ($this->tipe) {
            'info' => 'info',
            'warning' => 'triangle-alert',
            'success' => 'circle-check-big',
            'error' => 'circle-x',
            default => 'bell'
        };
    }
}
