<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class PelangganDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalTransaksi = Transaksi::where('user_id', $userId)->count();

        $transaksiPending = Transaksi::where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->count();

        $transaksiSelesai = Transaksi::where('user_id', $userId)
            ->where('status_transaksi', 'selesai')
            ->count();

        $totalPengeluaran = Transaksi::where('user_id', $userId)
            ->where('status_pembayaran', 'lunas')
            ->sum('total_akhir');

        $transaksiTerbaru = Transaksi::with('layanan')
            ->where('user_id', $userId)
            ->latest('tanggal_transaksi')
            ->take(5)
            ->get();

        return view('pelanggan.dashboard', compact(
            'totalTransaksi',
            'transaksiPending',
            'transaksiSelesai',
            'totalPengeluaran',
            'transaksiTerbaru'
        ));
    }
}
