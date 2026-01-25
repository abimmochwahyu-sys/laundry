<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik transaksi karyawan
        $totalTransaksi = Transaksi::count();
        $pending = Transaksi::where('status_transaksi', 'pending')->count();
        $selesai = Transaksi::where('status_transaksi', 'selesai')->count();
        $diambil = Transaksi::where('status_transaksi', 'diambil')->count();
        $transaksis = Transaksi::with(['user', 'layanan'])
        ->whereHas('user', function($query) {
            $query->where('role', 'pelanggan');
        })
        ->latest()
        ->take(10)
        ->get();

        return view('karyawan.dashboard', compact('totalTransaksi','pending','selesai','diambil','transaksis'));
    }
}
