@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Dashboard Perpustakaan</h2>
    </div>
</div>

<div class="row g-4">
    <!-- Total Buku -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <i class="bi bi-book fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Anggota -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Anggota</h6>
                        <h2 class="mb-0">{{ $totalAnggota }}</h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Peminjaman Aktif</h6>
                        <h2 class="mb-0">{{ $peminjamanAktif }}</h2>
                    </div>
                    <i class="bi bi-bookmark-check fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Denda Belum Lunas -->
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Denda Belum Lunas</h6>
                        <h2 class="mb-0">{{ $dendaBelumLunas }}</h2>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Peminjaman Terbaru -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Peminjaman Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Anggota</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamanTerbaru as $p)
                            <tr>
                                <td>{{ $p->kode_peminjaman }}</td>
                                <td>{{ $p->anggota->nama_lengkap }}</td>
                                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $p->status == 'Dipinjam' ? 'warning' : ($p->status == 'Dikembalikan' ? 'success' : 'danger') }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Terpopuler -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Buku Terpopuler</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Dipinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukuPopuler as $b)
                            <tr>
                                <td>{{ Str::limit($b->judul, 30) }}</td>
                                <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
                                <td><span class="badge bg-info">{{ $b->peminjaman_count }}x</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection