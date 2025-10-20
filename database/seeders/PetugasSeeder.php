<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run()
    {
        Petugas::updateOrCreate(
            ['nip' => 'PET001'], // unique check
            [
                'nama_petugas' => 'Admin Utama',
                'email' => 'admin@perpus.com',
                'password' => Hash::make('admin123'),
                'jabatan' => 'Admin',
                'status' => 'Aktif',
            ]
        );

        Petugas::updateOrCreate(
            ['nip' => 'PET002'],
            [
                'nama_petugas' => 'Pustakawan 1',
                'email' => 'pustaka@perpus.com',
                'password' => Hash::make('pustaka123'),
                'jabatan' => 'Pustakawan',
                'status' => 'Aktif',
            ]
        );
    }
}
