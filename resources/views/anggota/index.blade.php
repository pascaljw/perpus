@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Anggota</h2>
    <a href="{{ route('anggota.create') }}" class="btn btn-primary">+ Tambah Anggota</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 table-striped">
                <thead>
                    <tr>
                        <th>Nomor Anggota</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $a)
                        <tr>
                            <td>{{ $a->nomor_anggota }}</td>
                            <td>{{ $a->nama_lengkap }}</td>
                            <td>
                                <span class="badge bg-{{ $a->status=='Aktif'?'success':'secondary' }}">
                                    {{ $a->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('anggota.edit', $a->id_anggota) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('anggota.destroy', $a->id_anggota) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $anggota->links() }}
</div>
@endsection
