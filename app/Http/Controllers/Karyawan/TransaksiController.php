<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function create()
    {
        return view('karyawan.transaksi.create', [
            'layanans' => Layanan::all(),
            'metodePembayarans' => MetodePembayaran::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'berat_kg' => 'required|numeric|min:1',
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $total = $layanan->harga_per_kg * $request->berat_kg;

        Transaksi::create([
            'user_id' => Auth::id(), // karyawan
            'layanan_id' => $request->layanan_id,
            'berat_kg' => $request->berat_kg,
            'total_harga' => $total,
            'metode_pembayaran_id' => $request->metode_pembayaran_id,
            'status' => 'proses',
        ]);

        return redirect()
            ->route('karyawan.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }
}
