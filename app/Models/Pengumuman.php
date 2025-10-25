<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'mulai_berlaku',
        'sampai_berlaku',
        'author',
        'merchant_kode'
    ];

    protected $casts = [
        'mulai_berlaku' => 'datetime',
        'sampai_berlaku' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Scope untuk pengumuman berdasarkan merchant_kode
     */
    public function scopeByMerchant($query, $merchantKode)
    {
        return $query->where('merchant_kode', $merchantKode);
    }

    /**
     * Scope untuk pengumuman yang sedang tampil berdasarkan tanggal
     */
    public function scopeTampil($query)
    {
        $now = Carbon::now();
        return $query->where('mulai_berlaku', '<=', $now)
            ->where('sampai_berlaku', '>=', $now);
    }

    /**
     * Format tanggal mulai berlaku
     */
    public function getMulaiBerlakuFormattedAttribute()
    {
        return $this->mulai_berlaku ? $this->mulai_berlaku->translatedFormat('d M Y H:i') : '-';
    }

    /**
     * Format tanggal sampai berlaku
     */
    public function getSampaiBerlakuFormattedAttribute()
    {
        return $this->sampai_berlaku ? $this->sampai_berlaku->translatedFormat('d M Y H:i') : '-';
    }

    /**
     * Get excerpt dari isi pengumuman
     */
    public function getExcerptAttribute($length = 100)
    {
        return strlen($this->isi) > $length ? substr($this->isi, 0, $length) . '...' : $this->isi;
    }
}
