<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // tampilkan semua transaksi sebagai laporan
        $transaksis = Transaksi::with(['pelanggan','layanan'])->latest()->paginate(20);
        return view('admin.laporan.index', compact('transaksis'));
    }
}
