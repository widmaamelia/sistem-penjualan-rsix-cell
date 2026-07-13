<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProdukController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute Khusus Super Admin
    Route::middleware('role:super')->group(function () {
        // Master Cabang
        Route::post('cabang/{id}/toggle-status', [\App\Http\Controllers\Web\CabangController::class, 'toggleStatus'])->name('cabang.toggle-status');
        Route::resource('cabang', \App\Http\Controllers\Web\CabangController::class);

        // Manajemen Pengguna
        Route::post('pengguna/{id}/toggle-status', [\App\Http\Controllers\Web\PenggunaController::class, 'toggleStatus'])->name('pengguna.toggle-status');
        Route::resource('pengguna', \App\Http\Controllers\Web\PenggunaController::class);

        // Master Shift (Super Admin)
        Route::resource('master_shift', \App\Http\Controllers\Web\MasterShiftController::class)->except(['create', 'show', 'edit']);

        // Master Kategori
        Route::resource('kategori', \App\Http\Controllers\Web\KategoriController::class)->except(['show']);
    });

    // Rute untuk Super Admin & Admin Cabang
    Route::middleware('role:super,admin cabang')->group(function () {
        // Manajemen Produk
        Route::resource('produk', ProdukController::class);

        // Kas Keluar
        Route::resource('kas_keluar', \App\Http\Controllers\Web\KasKeluarController::class)->only(['index', 'store', 'destroy']);

        // Manajemen Stok
        Route::get('/stok/tambah', [\App\Http\Controllers\Web\StokController::class, 'tambahForm'])->name('stok.tambah-form');
        Route::post('/stok/tambah', [\App\Http\Controllers\Web\StokController::class, 'tambahProses'])->name('stok.tambah-proses');
        Route::get('/stok', [\App\Http\Controllers\Web\StokController::class, 'index'])->name('stok.index');
        Route::get('/stok/{id}/edit', [\App\Http\Controllers\Web\StokController::class, 'edit'])->name('stok.edit');
        Route::get('/stok/{id}/history', [\App\Http\Controllers\Web\StokController::class, 'history'])->name('stok.history');

        // Stok Opname
        Route::resource('stok_opname', \App\Http\Controllers\Web\StokOpnameController::class)->except(['edit', 'update', 'destroy']);
        Route::post('stok_opname/{id}/approve', [\App\Http\Controllers\Web\StokOpnameController::class, 'approve'])->name('stok_opname.approve');
        Route::post('stok_opname/{id}/reject', [\App\Http\Controllers\Web\StokOpnameController::class, 'reject'])->name('stok_opname.reject');

        // Jadwal Shift (Admin Cabang & Super Admin)
        Route::resource('jadwal_shift', \App\Http\Controllers\Web\JadwalShiftController::class)->only(['index', 'store', 'destroy']);
        Route::post('jadwal_shift/{id}/izin', [\App\Http\Controllers\Web\JadwalShiftController::class, 'setIzin'])->name('jadwal_shift.izin');

        // Laporan
        Route::get('/laporan', [\App\Http\Controllers\Web\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [\App\Http\Controllers\Web\LaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan/export/pdf', [\App\Http\Controllers\Web\LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
        Route::get('/laporan/export/excel', [\App\Http\Controllers\Web\LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
        Route::get('/laporan/{id}', [\App\Http\Controllers\Web\LaporanController::class, 'show'])->name('laporan.show');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
