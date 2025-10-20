<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = \App\Models\Anggota::orderBy('nama_lengkap', 'asc')->paginate(10);
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nomor_anggota'    => 'required|unique:anggota',
        'nama_lengkap'     => 'required|string|max:100',
        'email'            => 'nullable|email|unique:anggota',
        'no_telepon'       => 'nullable|string|max:20',
        'tanggal_lahir'    => 'nullable|date',
        'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
        'jenis_anggota'    => 'required|string',
        'status'           => 'required|in:Aktif,Nonaktif',
        'alamat'           => 'nullable|string',
        'foto_profil'      => 'nullable|image|max:2048'
    ]);

    $foto = null;
    if ($request->hasFile('foto_profil')) {
        $foto = $request->file('foto_profil')->store('foto_anggota', 'public');
    }

    $data = $request->except('foto_profil');
    $data['foto_profil'] = $foto;

    Anggota::create($data);

    return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan');
}


    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama_lengkap'   => 'required|string|max:100',
            'email'          => 'nullable|email|unique:anggota,email,' . $anggota->id_anggota . ',id_anggota',
            'status'         => 'required|in:Aktif,Nonaktif',
        ]);

        $data = $request->except('foto_profil');

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_anggota', 'public');
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus');
    }
}
