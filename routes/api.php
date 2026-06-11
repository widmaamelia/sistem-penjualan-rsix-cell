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
});
