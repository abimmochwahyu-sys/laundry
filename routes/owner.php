<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\OwnerLaporanController;
use App\Http\Controllers\UserProfileController;

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        // DASHBOARD OWNER
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // LAPORAN OWNER
        Route::get('/laporan', [OwnerLaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/export/excel', [OwnerLaporanController::class, 'exportExcel'])->name('laporan.export.excel');
        Route::get('/laporan/export/pdf', [OwnerLaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
        Route::get('/laporan/test-pdf', [OwnerLaporanController::class, 'testPdf'])->name('laporan.test.pdf');
        
        // PROFILE OWNER
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
