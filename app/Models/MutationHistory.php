<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutationHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mutation_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code_callback',
        'nisn',
        'customer_name',
        'information',
        'debet',
        'kredit',
        'date_trx',
        'merchant_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_trx' => 'datetime',
        'debet' => 'decimal:0',
        'kredit' => 'decimal:0',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the siswa associated with this mutation history.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nisn', 'nisn');
    }

    /**
     * Scope untuk filter berdasarkan NISN
     */
    public function scopeByNisn($query, $nisn)
    {
        return $query->where('nisn', $nisn);
    }

    /**
     * Scope untuk filter berdasarkan merchant name
     */
    public function scopeByMerchant($query, $merchantName)
    {
        return $query->where('merchant_name', $merchantName);
    }

    /**
     * Scope untuk filter berdasarkan NISN dan merchant name
     */
    public function scopeByNisnAndMerchant($query, $nisn, $merchantName)
    {
        return $query->where('nisn', $nisn)->where('merchant_name', $merchantName);
    }
}
