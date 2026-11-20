<?php

use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DasborAdminController;
use App\Http\Controllers\DasborSenimanController;
use App\Http\Controllers\KaryaSeniController;
use App\Http\Controllers\SenimanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Web ARTSPACE — Laravel 13 MVC (OJT HEXA)
|--------------------------------------------------------------------------
| Seluruh rute publik dapat diakses Pengunjung tanpa login.
| Tidak ada rute marketplace, keranjang, checkout, transaksi, atau agenda pameran terpisah.
*/

// Halaman Publik (Pengunjung tidak wajib login)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/jelajahi', [KaryaSeniController::class, 'index'])->name('karya.jelajahi');
Route::get('/karya/{slug}', [KaryaSeniController::class, 'detail'])->name('karya.detail');
Route::get('/seniman', [SenimanController::class, 'index'])->name('seniman.daftar');
Route::get('/seniman/{slug}', [SenimanController::class, 'profil'])->name('seniman.profil');

// Autentikasi (FR-01 — Pendaftaran publik khusus Seniman)
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AutentikasiController::class, 'formMasuk'])->name('masuk');
    Route::post('/masuk', [AutentikasiController::class, 'prosesMasuk'])->name('masuk.proses');
    Route::get('/daftar', [AutentikasiController::class, 'formDaftar'])->name('daftar');
    Route::post('/daftar', [AutentikasiController::class, 'prosesDaftar'])->name('daftar.proses');
});

Route::post('/keluar', [AutentikasiController::class, 'keluar'])
    ->middleware('auth')
    ->name('keluar');

// Dasbor Seniman (FR-02 & FR-03)
Route::middleware(['auth', 'peran:seniman'])->prefix('dasbor-seniman')->group(function () {
    Route::get('/', [DasborSenimanController::class, 'index'])->name('dasbor.seniman');
    Route::put('/profil', [DasborSenimanController::class, 'perbaruiProfil'])->name('dasbor.seniman.profil');

    Route::post('/karya', [DasborSenimanController::class, 'simpanKarya'])->name('dasbor.seniman.karya.simpan');
    Route::put('/karya/{karya}', [DasborSenimanController::class, 'perbaruiKarya'])->name('dasbor.seniman.karya.perbarui');
    Route::delete('/karya/{karya}', [DasborSenimanController::class, 'hapusKarya'])->name('dasbor.seniman.karya.hapus');

    Route::post('/pameran', [DasborSenimanController::class, 'simpanPameran'])->name('dasbor.seniman.pameran.simpan');
    Route::put('/pameran/{riwayat}', [DasborSenimanController::class, 'perbaruiPameran'])->name('dasbor.seniman.pameran.perbarui');
    Route::delete('/pameran/{riwayat}', [DasborSenimanController::class, 'hapusPameran'])->name('dasbor.seniman.pameran.hapus');
});

// Dasbor Admin (Pemantauan & Pengelolaan Sistem — tanpa fitur keuangan/transaksi)
Route::middleware(['auth', 'peran:admin'])->prefix('dasbor-admin')->group(function () {
    Route::get('/', [DasborAdminController::class, 'index'])->name('dasbor.admin');
    Route::patch('/pengguna/{pengguna}/status', [DasborAdminController::class, 'ubahStatusPengguna'])->name('dasbor.admin.pengguna.status');
    Route::patch('/karya/{karya}/moderasi', [DasborAdminController::class, 'moderasiKarya'])->name('dasbor.admin.karya.moderasi');
    Route::delete('/karya/{karya}', [DasborAdminController::class, 'hapusKaryaPelanggaran'])->name('dasbor.admin.karya.hapus');
});
