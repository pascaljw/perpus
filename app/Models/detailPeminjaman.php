<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class detailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'id_anggota',
        'id_petugas',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    // Relationships
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman');
    }

    public function denda()
    {
        return $this->hasMany(Denda::class, 'id_peminjaman');
    }

    // Helper Methods
    public function hitungHariTerlambat()
    {
        if ($this->status === 'Dikembalikan' && $this->tanggal_kembali_aktual) {
            $hari = $this->tanggal_kembali_aktual->diffInDays($this->tanggal_kembali_rencana, false);
            return $hari < 0 ? abs($hari) : 0;
        }

        if ($this->status === 'Dipinjam' || $this->status === 'Terlambat') {
            $hari = Carbon::now()->diffInDays($this->tanggal_kembali_rencana, false);
            return $hari < 0 ? abs($hari) : 0;
        }

        return 0;
    }

    public function isTerlambat()
    {
        return $this->hitungHariTerlambat() > 0;
    }
}
