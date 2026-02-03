<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Transaksi;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            // hanya user karyawan yang benar-benar punya data karyawan
            'jumlahKaryawan' => User::where('role', 'karyawan')
                                    ->whereHas('karyawan')
                                    ->count(),

            // hanya user pelanggan yang benar-benar punya data pelanggan
            'jumlahPelanggan' => User::where('role', 'pelanggan')
                                     ->whereHas('pelanggan')
                                     ->count(),

            'jumlahLayanan'   => Layanan::count(),
            'jumlahTransaksi' => Transaksi::count(),
            'totalPendapatan' => Transaksi::sum('total_akhir'),
        ]);
    }
}
