<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanSiswa extends Model
{
    use HasFactory;

    protected $table = 'tagihan_siswa';

    protected $fillable = [
        'nisn',
        'nama',
        'tagihan',
        'total',
        'nilai',
        'potongan',
        'bayar',
        'sisa',
        'jenis',
        'tahun_ajaran',
        'kelas',
        'tgl_bayar',
        'active',
        'id_master_tagihan',
        'status_pembayaran',
        'bulan',
        'merchant_kode',
        'loket',
        'bukti',
    ];

    protected $casts = [
        'total' => 'decimal:0',
        'nilai' => 'decimal:0',
        'potongan' => 'decimal:0',
        'bayar' => 'decimal:0',
        'sisa' => 'decimal:0',
        'tahun_ajaran' => 'integer',
        'tgl_bayar' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope untuk tagihan yang belum lunas
    public function scopeBelumLunas($query)
    {
        return $query->where('status_pembayaran', '0');
    }

    // Scope untuk tagihan yang sudah lunas
    public function scopeLunas($query)
    {
        return $query->where('status_pembayaran', '1');
    }

    // Scope untuk tagihan aktif
    public function scopeAktif($query)
    {
        return $query->where('active', 'Y');
    }

    // Accessor untuk format status pembayaran
    public function getStatusPembayaranTextAttribute()
    {
        return $this->status_pembayaran == '1' ? 'Lunas' : 'Belum Lunas';
    }

    // Accessor untuk format jenis tagihan
    public function getJenisTextAttribute()
    {
        return ucfirst($this->jenis);
    }

    // Method untuk mengecek apakah tagihan sudah lunas
    public function isLunas()
    {
        return $this->status_pembayaran == '1';
    }

    // Method untuk mendapatkan nama bulan
    public function getNamaBulanAttribute()
    {
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return $bulan[$this->bulan] ?? $this->bulan;
    }

    // Relationship dengan MutationHistory
    public function mutationHistory()
    {
        return $this->hasMany(MutationHistory::class, 'nisn', 'nisn');
    }

    // Relationship dengan Notification
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'nisn', 'nisn');
    }
}
