<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class OwnerLaporanController extends Controller
{
    public function index()
    {
        $laporan = Transaksi::with(['layanan', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.laporan', compact('laporan'));
    }
}
