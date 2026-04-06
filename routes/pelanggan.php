<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pelanggan\PelangganDashboardController;
use App\Http\Controllers\Pelanggan\PelangganTransaksiController;
use App\Http\Controllers\UserProfileController;

Route::middleware(['auth', 'role:pelanggan'])
    ->prefix('pelanggan')
    ->name('pelanggan.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');

        // PROFILE
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');

        // TRANSAKSI
        Route::resource('transaksi', PelangganTransaksiController::class);
        Route::post('transaksi/{id}/pickup', [PelangganTransaksiController::class, 'pickup'])->name('transaksi.pickup');

        // Validasi kode diskon
        Route::post('diskon/validate', [PelangganTransaksiController::class, 'validateDiskon'])->name('diskon.validate');
    });
