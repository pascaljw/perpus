<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'petugas', 'detailPeminjaman.buku'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggota = Anggota::where('status', 'Aktif')->get();
        $buku = Buku::where('jumlah_tersedia', '>', 0)->get();
        return view('peminjaman.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'lama_pinjam' => 'required|integer|min:1|max:14',
            'id_buku' => 'required|array|min:1',
            'id_buku.*' => 'exists:buku,id_buku',
        ]);

        // Generate kode peminjaman
        $kodePeminjaman = 'PJM' . date('Ymd') . strtoupper(Str::random(4));

        // Buat peminjaman
        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => $kodePeminjaman,
            'id_anggota' => $request->id_anggota,
            'id_petugas' => auth()->user()->id_petugas ?? 1,
            'tanggal_pinjam' => now(),
            'tanggal_kembali_rencana' => now()->addDays($request->lama_pinjam),
            'status' => 'Dipinjam',
        ]);

        // Buat detail peminjaman dan kurangi stok
        foreach ($request->id_buku as $idBuku) {
            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku' => $idBuku,
                'kondisi_pinjam' => 'Baik',
            ]);

            // Kurangi jumlah tersedia
            $buku = Buku::find($idBuku);
            $buku->decrement('jumlah_tersedia');
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'petugas', 'detailPeminjaman.buku', 'denda']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function pengembalian($id)
    {
        $peminjaman = Peminjaman::with(['detailPeminjaman.buku', 'anggota'])->findOrFail($id);
        return view('peminjaman.pengembalian', compact('peminjaman'));
    }

    public function prosesPengembalian(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_kembali' => 'required|array',
            'kondisi_kembali.*' => 'in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        
        // Update peminjaman
        $peminjaman->update([
            'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
            'status' => 'Dikembalikan',
        ]);

        // Update kondisi kembali dan tambah stok
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->update([
                'kondisi_kembali' => $request->kondisi_kembali[$detail->id_detail],
            ]);

            // Tambah jumlah tersedia
            $detail->buku->increment('jumlah_tersedia');
        }

        // Hitung denda keterlambatan
        $hariTerlambat = $peminjaman->hitungHariTerlambat();
        if ($hariTerlambat > 0) {
            $tarifPerHari = 1000;
            $totalDenda = $hariTerlambat * $tarifPerHari;

            Denda::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'jenis_denda' => 'Keterlambatan',
                'jumlah_hari_terlambat' => $hariTerlambat,
                'tarif_per_hari' => $tarifPerHari,
                'total_denda' => $totalDenda,
                'status_bayar' => 'Belum Lunas',
            ]);
        }

        return redirect()->route('peminjaman.show', $peminjaman->id_peminjaman)
                        ->with('success', 'Pengembalian berhasil diproses');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Kembalikan stok buku jika peminjaman belum dikembalikan
        if ($peminjaman->status !== 'Dikembalikan') {
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $detail->buku->increment('jumlah_tersedia');
            }
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }
}