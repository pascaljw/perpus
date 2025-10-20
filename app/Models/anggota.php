<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'nomor_anggota',
        'nama_lengkap',
        'email',
        'no_telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'jenis_anggota',
        'tanggal_daftar',
        'tanggal_kadaluarsa',
        'status',
        'foto_profil',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
        'tanggal_kadaluarsa' => 'date',
    ];

    // Relationships
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_anggota');
    }
}
