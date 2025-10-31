<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'merchant';

    protected $fillable = [
        'kode_merchant',
        'nama_merchant',
        'alamat',
        'telepon',
        'email',
        'kepala_sekolah',
        'npsn',
        'status',
        'api_key',
        'secret_key',
        'callback_url',
        'logo',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi hasMany ke TagihanSiswa
     */
    public function tagihan()
    {
        return $this->hasMany(TagihanSiswa::class, 'merchant_kode', 'kode_merchant');
    }

    /**
     * Scope untuk merchant aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk merchant non-aktif
     */
    public function scopeNonAktif($query)
    {
        return $query->where('status', '!=', 'aktif');
    }
}

