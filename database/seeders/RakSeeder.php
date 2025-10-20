<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rak;

class RakSeeder extends Seeder
{
    public function run()
    {
        $rak = [
            ['kode_rak' => 'A01', 'nama_rak' => 'Rak A1', 'lokasi' => 'Lantai 1 - Timur', 'kapasitas' => 100],
            ['kode_rak' => 'A02', 'nama_rak' => 'Rak A2', 'lokasi' => 'Lantai 1 - Barat', 'kapasitas' => 100],
            ['kode_rak' => 'B01', 'nama_rak' => 'Rak B1', 'lokasi' => 'Lantai 2 - Timur', 'kapasitas' => 150],
            ['kode_rak' => 'B02', 'nama_rak' => 'Rak B2', 'lokasi' => 'Lantai 2 - Barat', 'kapasitas' => 150],
        ];

        foreach ($rak as $r) {
    Rak::updateOrCreate(
        ['kode_rak' => $r['kode_rak']], // kunci unique
        $r
    );
}
    }
}