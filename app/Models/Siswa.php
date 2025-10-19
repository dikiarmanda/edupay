<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nisn',
        'nama',
        'no_hp',
        'kelas',
        'angkatan',
        'status',
        'nova',
        'agama',
        'kelamin',
        'tempat',
        'tgl_lahir',
        'alamat',
        'nama_ibu',
        'nama_ayah',
        'merchant_kode',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with this siswa.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'nisn_siswa', 'nisn');
    }
}
