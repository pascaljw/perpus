@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <h2>Tambah Anggota</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nomor Anggota</label>
                        <input type="text" name="nomor_anggota" class="form-control" value="{{ old('nomor_anggota') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (opsional)</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Anggota</label>
                        <select name="jenis_anggota" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Mahasiswa" {{ old('jenis_anggota')=='Mahasiswa'?'selected':'' }}>Mahasiswa</option>
                            <option value="Dosen" {{ old('jenis_anggota')=='Dosen'?'selected':'' }}>Dosen</option>
                            <option value="Umum" {{ old('jenis_anggota')=='Umum'?'selected':'' }}>Umum</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Daftar</label>
                        <input type="date" name="tanggal_daftar" class="form-control" value="{{ old('tanggal_daftar') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" name="tanggal_kadaluarsa" class="form-control" value="{{ old('tanggal_kadaluarsa') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Aktif" {{ old('status')=='Aktif'?'selected':'' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status')=='Nonaktif'?'selected':'' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Profil (opsional)</label>
                        <input type="file" name="foto_profil" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
