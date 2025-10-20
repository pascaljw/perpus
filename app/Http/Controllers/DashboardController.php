<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::sum('jumlah_total');
        $totalAnggota = Anggota::where('status', 'Aktif')->count();
        $peminjamanAktif = Peminjaman::whereIn('status', ['Dipinjam', 'Terlambat'])->count();
        $dendaBelumLunas = Denda::where('status_bayar', 'Belum Lunas')->count();

        $peminjamanTerbaru = Peminjaman::with('anggota')
                                      ->latest()
                                      ->limit(5)
                                      ->get();

        $bukuPopuler = Buku::with('kategori')
                          ->withCount('detailPeminjaman')
                          ->orderBy('detail_peminjaman_count', 'desc')
                          ->limit(5)
                          ->get();

        return view('dashboard', compact(
            'totalBuku',
            'totalAnggota', 
            'peminjamanAktif',
            'dendaBelumLunas',
            'peminjamanTerbaru',
            'bukuPopuler'
        ));
    }
}