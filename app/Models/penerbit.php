<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penerbit extends Model
{
    use HasFactory;

    protected $table = 'penerbit';
    protected $primaryKey = 'id_penerbit';

    protected $fillable = [
        'nama_penerbit',
        'alamat',
        'no_telepon',
        'email',
        'website',
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_penerbit');
    }
}
