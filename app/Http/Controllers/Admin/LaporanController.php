<?php

// app/Http/Controllers/Admin/LaporanController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan']);
        
        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }
        
        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->paginate(10);
        
        return view('admin.laporan.index', compact('transaksis'));
    }
}