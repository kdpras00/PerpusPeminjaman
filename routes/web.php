<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Buku Routes (Admin & Petugas)
    Route::resource('buku', BukuController::class);

    // Anggota Routes (Admin & Petugas)
    Route::resource('anggota', AnggotaController::class)->parameters([
        'anggota' => 'anggota'
    ]);

    // Peminjaman Routes (Petugas only)
    Route::middleware(['check.role:petugas'])->group(function () {
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);
    });

    // Laporan Routes (Admin & Petugas)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');

        Route::get('/peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman');
        Route::get('/peminjaman/pdf', [LaporanController::class, 'peminjamanPdf'])->name('peminjaman.pdf');
        Route::get('/peminjaman/excel', [LaporanController::class, 'peminjamanExcel'])->name('peminjaman.excel');

        Route::get('/pengembalian', [LaporanController::class, 'pengembalian'])->name('pengembalian');
        Route::get('/pengembalian/pdf', [LaporanController::class, 'pengembalianPdf'])->name('pengembalian.pdf');
        Route::get('/pengembalian/excel', [LaporanController::class, 'pengembalianExcel'])->name('pengembalian.excel');

        Route::get('/buku', [LaporanController::class, 'buku'])->name('buku');
        Route::get('/buku/pdf', [LaporanController::class, 'bukuPdf'])->name('buku.pdf');
        Route::get('/buku/excel', [LaporanController::class, 'bukuExcel'])->name('buku.excel');

        Route::get('/anggota', [LaporanController::class, 'anggota'])->name('anggota');
        Route::get('/anggota/pdf', [LaporanController::class, 'anggotaPdf'])->name('anggota.pdf');
        Route::get('/anggota/excel', [LaporanController::class, 'anggotaExcel'])->name('anggota.excel');
    });
});
