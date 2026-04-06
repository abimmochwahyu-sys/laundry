<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\DiskonController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\SettingAbsensiController;
use App\Http\Controllers\UserProfileController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Pelanggan Routes
        Route::resource('pelanggan', PelangganController::class);

        // Layanan Routes
        Route::resource('layanan', LayananController::class);

        // Transaksi Routes
        Route::resource('transaksi', TransaksiController::class);
        Route::post('transaksi/{id}/payment', [TransaksiController::class, 'confirmPayment'])->name('transaksi.payment');
        Route::put('transaksi/{id}/lunas', [TransaksiController::class, 'markAsLunas'])->name('transaksi.lunas');

        // Karyawan Routes
        Route::resource('karyawan', KaryawanController::class);

        // Diskon Routes
        Route::resource('diskon', DiskonController::class);
        Route::post('diskon/{diskon}/toggle-status', [DiskonController::class, 'toggleStatus'])->name('diskon.toggle-status');

        // Laporan Routes
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
        Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan/invoice/{id}', [LaporanController::class, 'invoice'])->name('laporan.invoice');

        // Profile Admin
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');

        // Absensi Routes
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/scan-absensi/{userId}', [AbsensiController::class, 'scan'])->name('absen.scan');

        // Setting Absensi
        Route::get('/setting-absensi', [SettingAbsensiController::class, 'index'])->name('setting.absensi');
        Route::post('/setting-absensi/update', [SettingAbsensiController::class, 'update'])->name('setting.absensi.update');
    });
