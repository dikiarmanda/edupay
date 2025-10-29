<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinSiswa extends Model
{
    use HasFactory;

    protected $table = 'izin_siswa';

    protected $fillable = [
        'nisn',
        'nama',
        'tanggal_izin',
        'jenis_izin',
        'durasi',
        'alasan',
        'bukti_surat',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_izin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the jenis izin text attribute.
     */
    public function getJenisIzinTextAttribute()
    {
        $jenis = [
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'dispensasi' => 'Dispensasi',
        ];

        return $jenis[$this->jenis_izin] ?? ucfirst($this->jenis_izin);
    }

    /**
     * Get the status text attribute.
     */
    public function getStatusTextAttribute()
    {
        if (!$this->status) {
            return 'Menunggu Persetujuan';
        }

        return $this->status == '1' ? 'Disetujui' : 'Ditolak';
    }

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeColorAttribute()
    {
        if (!$this->status) {
            return 'yellow';
        }

        return $this->status == '1' ? 'green' : 'red';
    }
}

