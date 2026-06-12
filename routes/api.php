<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        // Load relasi cabang sebelum dikembalikan
        return $request->user()->load('cabang');
    });
    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Kas Keluar
    Route::get('/kas-keluar', [\App\Http\Controllers\Api\KasKeluarController::class, 'index']);
    Route::post('/kas-keluar', [\App\Http\Controllers\Api\KasKeluarController::class, 'store']);

    // Manajemen Stok
    Route::get('/stok', [\App\Http\Controllers\Api\StokController::class, 'index']);

    // Manajemen Shift
    Route::get('/shift', [\App\Http\Controllers\Api\ShiftController::class, 'index']);
    Route::post('/shift/buka', [\App\Http\Controllers\Api\ShiftController::class, 'buka']);
    Route::get('/shift/ringkasan-tutup', [\App\Http\Controllers\Api\ShiftController::class, 'ringkasanTutup']);
    Route::post('/shift/tutup', [\App\Http\Controllers\Api\ShiftController::class, 'tutup']);

    // Mesin Kasir / POS
    Route::get('/pos/produk', [\App\Http\Controllers\Api\PosController::class, 'produk']);
    Route::post('/pos/checkout', [\App\Http\Controllers\Api\PosController::class, 'checkout']);

    // Riwayat Transaksi
    Route::get('/riwayat-transaksi', [\App\Http\Controllers\Api\RiwayatController::class, 'index']);
    Route::get('/riwayat-transaksi/{id}', [\App\Http\Controllers\Api\RiwayatController::class, 'show']);

    // Profil & Pengaturan
    Route::post('/profil/edit', [\App\Http\Controllers\Api\ProfilController::class, 'updateProfil']);
    Route::post('/profil/ubah-password', [\App\Http\Controllers\Api\ProfilController::class, 'ubahPassword']);
});
