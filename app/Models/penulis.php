<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penulis extends Model
{
    use HasFactory;

    protected $table = 'penulis';
    protected $primaryKey = 'id_penulis';

    protected $fillable = [
        'nama_penulis',
        'biografi',
        'tanggal_lahir',
        'kebangsaan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'buku_penulis', 'id_penulis', 'id_buku')
                    ->withPivot('urutan');
    }
}
