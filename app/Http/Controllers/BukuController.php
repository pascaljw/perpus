<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Penulis;
use App\Models\Rak;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with(['kategori', 'penerbit', 'rak', 'penulis'])->paginate(10);
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $penulis = Penulis::all();
        $rak = Rak::all();
        return view('buku.create', compact('kategori', 'penerbit', 'penulis', 'rak'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'nullable|unique:buku,isbn',
            'judul' => 'required|max:200',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_penerbit' => 'required|exists:penerbit,id_penerbit',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'bahasa' => 'nullable|string|max:30',
            'deskripsi' => 'nullable|string',
            'jumlah_total' => 'required|integer|min:0',
            'id_rak' => 'nullable|exists:rak,id_rak',
            'penulis' => 'required|array',
        ]);

        $buku = Buku::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'id_kategori' => $request->id_kategori,
            'id_penerbit' => $request->id_penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'jumlah_halaman' => $request->jumlah_halaman,
            'bahasa' => $request->bahasa ?? 'Indonesia',
            'deskripsi' => $request->deskripsi,
            'jumlah_total' => $request->jumlah_total,
            'jumlah_tersedia' => $request->jumlah_total,
            'id_rak' => $request->id_rak,
        ]);

        // Attach penulis
        $buku->penulis()->attach($request->penulis);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategori', 'penerbit', 'rak', 'penulis']);
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $penulis = Penulis::all();
        $rak = Rak::all();
        $buku->load('penulis');
        return view('buku.edit', compact('buku', 'kategori', 'penerbit', 'penulis', 'rak'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'isbn' => 'nullable|unique:buku,isbn,' . $buku->id_buku . ',id_buku',
            'judul' => 'required|max:200',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_penerbit' => 'required|exists:penerbit,id_penerbit',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'jumlah_total' => 'required|integer|min:0',
            'penulis' => 'required|array',
        ]);

        $buku->update($request->except('penulis'));
        $buku->penulis()->sync($request->penulis);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}