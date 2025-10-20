<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'isbn',
        'judul',
        'id_kategori',
        'id_penerbit',
        'tahun_terbit',
        'jumlah_halaman',
        'bahasa',
        'deskripsi',
        'cover_buku',
        'jumlah_total',
        'jumlah_tersedia',
        'id_rak',
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_rak');
    }

    public function penulis()
    {
        return $this->belongsToMany(Penulis::class, 'buku_penulis', 'id_buku', 'id_penulis')
                    ->withPivot('urutan');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_buku');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_buku');
    }
}
