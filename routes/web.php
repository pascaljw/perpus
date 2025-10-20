<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\ReservasiController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Anggota Routes
Route::resource('anggota', AnggotaController::class);

// Buku Routes
Route::resource('buku', BukuController::class);

// Peminjaman Routes
Route::resource('peminjaman', PeminjamanController::class);
Route::get('peminjaman/{id}/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
Route::post('peminjaman/{id}/proses-pengembalian', [PeminjamanController::class, 'prosesPengembalian'])->name('peminjaman.proses-pengembalian');

// Denda Routes
Route::resource('denda', DendaController::class);
Route::post('denda/{id}/bayar', [DendaController::class, 'bayar'])->name('denda.bayar');

// Reservasi Routes
Route::resource('reservasi', ReservasiController::class);