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
    
    // Manajemen Produk
    Route::resource('produk', ProdukController::class);
    
    // Master Kategori
    Route::resource('kategori', \App\Http\Controllers\Web\KategoriController::class)->except(['show']);

    // Master Cabang
    Route::resource('cabang', \App\Http\Controllers\Web\CabangController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
