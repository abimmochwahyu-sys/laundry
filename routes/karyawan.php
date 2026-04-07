<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\Karyawan\KaryawanTransaksiController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Karyawan\KaryawanDiskonController;
use App\Http\Controllers\UserProfileController;

Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // PROFILE KARYAWAN
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');

        // Resource transaksi
        Route::resource('transaksi', KaryawanTransaksiController::class);

        // Custom route untuk update status
        Route::put('transaksi/{id}/status', [KaryawanTransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');

        // Custom route untuk "pickup"
        Route::get('transaksi/{id}/pickup', [KaryawanTransaksiController::class, 'pickup'])->name('transaksi.pickup');

        // CETAK INVOICE
        Route::get('transaksi/{id}/invoice', [KaryawanTransaksiController::class, 'invoice'])->name('transaksi.invoice');

        // Konfirmasi pembayaran
        Route::post('transaksi/{id}/payment', [KaryawanTransaksiController::class, 'confirmPayment'])->name('transaksi.payment');

        Route::put('/transaksi/{id}/lunas', [KaryawanTransaksiController::class, 'markAsLunas'])->name('transaksi.lunas');

        // Absensi
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absen/scan/{token}', [AbsensiController::class, 'scan'])->name('absen.scan');

        // Diskon Routes
        Route::resource('diskon', KaryawanDiskonController::class);
        Route::post('diskon/{diskon}/toggle-status', [KaryawanDiskonController::class, 'toggleStatus'])->name('diskon.toggle-status');
    });
