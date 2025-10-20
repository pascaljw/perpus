<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    
    {
        $kategori = [
            ['nama_kategori' => 'Fiksi', 'kode_kategori' => 'FIK', 'deskripsi' => 'Novel dan cerita fiksi'],
            ['nama_kategori' => 'Non-Fiksi', 'kode_kategori' => 'NFK', 'deskripsi' => 'Buku pengetahuan umum'],
            ['nama_kategori' => 'Sains', 'kode_kategori' => 'SCI', 'deskripsi' => 'Buku sains dan teknologi'],
            ['nama_kategori' => 'Sejarah', 'kode_kategori' => 'HIS', 'deskripsi' => 'Buku sejarah'],
            ['nama_kategori' => 'Religi', 'kode_kategori' => 'REL', 'deskripsi' => 'Buku keagamaan'],
            ['nama_kategori' => 'Anak-Anak', 'kode_kategori' => 'CHI', 'deskripsi' => 'Buku untuk anak-anak'],
        ];

        foreach ($kategori as $k) {
        Kategori::firstOrCreate(['kode_kategori' => $k['kode_kategori']], $k);
}
    }
}