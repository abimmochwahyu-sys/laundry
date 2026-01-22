<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        return view('owner.dashboard', [
            'totalPendapatan' => Transaksi::sum('total_harga'),
            'totalTransaksi'  => Transaksi::count(),
            'transaksiProses' => Transaksi::where('status', 'diproses')->count(),
            'totalKaryawan'   => User::where('role', 'karyawan')->count(),
        ]);
    }
}
