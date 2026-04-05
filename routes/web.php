<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\User\UserLayananController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\User\UserTransaksiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Auth\OwnerAuthController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\OwnerLaporanController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;           
use App\Http\Controllers\Karyawan\KaryawanTransaksiController;
use App\Http\Controllers\Pelanggan\PelangganDashboardController;
use App\Http\Controllers\pelanggan\PelangganTransaksiController;
use App\Http\Controllers\Pelanggan\ProfilController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Karyawan\AbsensiController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\SettingAbsensiController;




/*
|--------------------------------------------------------------------------
| Halaman Awal & Authentication Routes
|--------------------------------------------------------------------------
*/
// Halaman Landing
Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Register

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.process');




// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Pelanggan Routes
        Route::resource('pelanggan', PelangganController::class);

        // Layanan Routes
        Route::resource('layanan', App\Http\Controllers\Admin\LayananController::class);

        // Transaksi Routes
        Route::resource('transaksi', AdminTransaksiController::class);
        Route::post('transaksi/{id}/payment', [AdminTransaksiController::class, 'confirmPayment'])
            ->name('transaksi.payment');
        Route::put('transaksi/{id}/lunas', [App\Http\Controllers\Admin\TransaksiController::class, 'markAsLunas'])
            ->name('transaksi.lunas');

        // Karyawan Routes
        Route::resource('karyawan', KaryawanController::class);

        // Laporan Routes
        Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])
            ->name('laporan.index');
        Route::get('/laporan/export', [App\Http\Controllers\Admin\LaporanController::class, 'export'])
            ->name('laporan.export');
        Route::get('/laporan/invoice/{id}', [App\Http\Controllers\Admin\LaporanController::class, 'invoice'])
            ->name('laporan.invoice');

        // Profile Admin (using unified controller)
        Route::get('/profile', [UserProfileController::class, 'index'])
            ->name('profile.index');
        Route::put('/profile', [UserProfileController::class, 'update'])
            ->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])
            ->name('profile.password.update');

        // Absensi Routes
        Route::get('/absensi', [AdminAbsensiController::class, 'index'])
            ->name('absensi.index');
        Route::get('/scan-absensi/{userId}', [AdminAbsensiController::class, 'scan'])
            ->name('absen.scan');

        // Setting Absensi
        Route::get('/setting-absensi', [SettingAbsensiController::class, 'index'])
            ->name('setting.absensi');
        Route::post('/setting-absensi/update', [SettingAbsensiController::class, 'update'])
            ->name('setting.absensi.update');
    });


/*
|--------------------------------------------------------------------------
| User/Pelanggan Routes
|--------------------------------------------------------------------------
*/

// Route::prefix('owner')->group(function () {

//     Route::get('/login', [OwnerAuthController::class, 'showLogin'])
//         ->name('owner.login');

//     Route::post('/login', [OwnerAuthController::class, 'login'])
//         ->name('owner.login.post');

//     Route::middleware('owner')->group(function () {

//         Route::get('/dashboard', function () {
//             return view('owner.dashboard');
//         })->name('owner.dashboard');

//     });
// });

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        // DASHBOARD OWNER
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // LAPORAN OWNER
        Route::get('/laporan', [OwnerLaporanController::class, 'index'])
            ->name('laporan');
        
        // PROFILE OWNER
        Route::get('/profile', [UserProfileController::class, 'index'])
            ->name('profile');
        Route::put('/profile', [UserProfileController::class, 'update'])
            ->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])
            ->name('profile.password.update');
});


    Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])
            ->name('dashboard');
        
        // PROFILE KARYAWAN
        Route::get('/profile', [UserProfileController::class, 'index'])
            ->name('profile');
        Route::put('/profile', [UserProfileController::class, 'update'])
            ->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])
            ->name('profile.password.update');

        // Resource transaksi
        Route::resource('transaksi', KaryawanTransaksiController::class);

        // Custom route untuk update status
        Route::put('transaksi/{id}/status', [KaryawanTransaksiController::class, 'updateStatus'])
            ->name('transaksi.updateStatus');

        // Custom route untuk "pickup"
        Route::get('transaksi/{id}/pickup', [KaryawanTransaksiController::class, 'pickup'])
            ->name('transaksi.pickup');

        // CETAK INVOICE
        Route::get('transaksi/{id}/invoice', [KaryawanTransaksiController::class, 'invoice'])
            ->name('transaksi.invoice');

        // Konfirmasi pembayaran
        Route::post('transaksi/{id}/payment', [KaryawanTransaksiController::class, 'confirmPayment'])
            ->name('transaksi.payment');

        Route::put('/transaksi/{id}/lunas', [App\Http\Controllers\Karyawan\KaryawanTransaksiController::class, 'markAsLunas'])
        ->name('transaksi.lunas');
    });




    Route::middleware(['auth', 'role:pelanggan'])
    ->prefix('pelanggan')
    ->name('pelanggan.')
    ->group(function () {

        // ===== DASHBOARD =====
        Route::get('/dashboard', [PelangganDashboardController::class, 'index'])
            ->name('dashboard');

        // PROFILE PELANGGAN (using unified controller)
        Route::get('/profile', [UserProfileController::class, 'index'])
            ->name('profile');
        Route::put('/profile', [UserProfileController::class, 'update'])
            ->name('profile.update');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])
            ->name('profile.password.update');

        // ===== TRANSAKSI =====
        Route::resource('transaksi', PelangganTransaksiController::class);

        Route::post('transaksi/{id}/pickup', [PelangganTransaksiController::class, 'pickup'])
            ->name('transaksi.pickup');
});


    //     Route::resource('transaksi', KaryawanTransaksiController::class);
    // });


    
Route::prefix('karyawan')->middleware(['auth'])->group(function () {

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('karyawan.absensi.index');

    // scan qr absensi
    Route::get('/absen/scan/{token}', [AbsensiController::class, 'scan'])->name('karyawan.absen.scan');

});
    


Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/absensi', [AdminAbsensiController::class, 'index'])->name('admin.absensi.index');

    // scan qr karyawan
    Route::get('/scan-absensi/{userId}', [AdminAbsensiController::class, 'scan'])->name('admin.absen.scan');

});


Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/setting-absensi',[SettingAbsensiController::class,'index'])
        ->name('admin.setting.absensi');

    Route::post('/setting-absensi/update',[SettingAbsensiController::class,'update'])
        ->name('admin.setting.absensi.update');

});