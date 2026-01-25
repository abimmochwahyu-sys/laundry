<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class PelangganTransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pelanggan.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        return view('pelanggan.transaksi.create', [
            'layanans' => Layanan::all(),
            'metodePembayarans' => MetodePembayaran::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
            'berat_kg' => 'required|numeric|min:1',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);

        Transaksi::create([
            'kode_transaksi' => 'TRX-' . time(),
            'user_id' => auth()->id(), // karyawan
            'layanan_id' => $layanan->id,
            'metode_pembayaran_id' => $request->metode_pembayaran_id,
            'berat_kg' => $request->berat_kg,
            'harga_per_kg' => $layanan->harga_per_kg,
            'total_harga' => $layanan->harga_per_kg * $request->berat_kg,
            'status' => 'pending',
        ]);

        return redirect()->route('Pelanggan.transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat');
    }
}
