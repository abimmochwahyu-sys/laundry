<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan', 'layanan'])->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function create()
{
    $pelanggans = Pelanggan::all();
    $layanans   = Layanan::all();

    return view('admin.transaksi.create', compact('pelanggans', 'layanans'));
}


    public function store(Request $request)
{
    $request->validate([
        'layanan_id' => 'required|exists:layanans,id',
        'berat' => 'required|numeric|min:0.1',
        'metode_pembayaran' => 'required|in:cash,e-wallet',
    ]);

    $layanan = Layanan::find($request->layanan_id);
    $total_harga = $layanan->harga * $request->berat;
    
    // Hitung diskon jika berat > 4kg
    $diskon = 0;
    if ($request->berat > 4) {
        $diskon = $total_harga * 0.1;
    }
    
    $total_akhir = $total_harga - $diskon;

    // Generate kode transaksi unik
    $kode_transaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(4));

    $transaksi = Transaksi::create([
        'user_id' => auth()->id(),
        'layanan_id' => $request->layanan_id,
        'kode_transaksi' => $kode_transaksi,
        'berat' => $request->berat,
        'total_harga' => $total_harga,
        'diskon' => $diskon,
        'total_akhir' => $total_akhir,
        'metode_pembayaran' => $request->metode_pembayaran,
        'status_pembayaran' => 'pending',
        'status_transaksi' => 'pending',
        'tanggal_transaksi' => now()->toDateString(),
        'tanggal_selesai' => now()->addDays($layanan->estimasi_waktu)->toDateString(),
    ]);

    return redirect()->route('user.transaksi.show', $transaksi->id)
        ->with('success', 'Transaksi berhasil dibuat!');
}

    public function edit(Transaksi $transaksi)
    {
        $pelanggans = Pelanggan::all();
        $layanans = Layanan::all();
        return view('admin.transaksi.edit', compact('transaksi', 'pelanggans', 'layanans'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'layanan_id' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $total_harga = $layanan->harga * $request->jumlah;

        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'layanan_id' => $request->layanan_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
        ]);

        // ✅ route pakai prefix "admin"
        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Transaksi berhasil diupdate');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        // ✅ route pakai prefix "admin"
        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Transaksi berhasil dihapus');
    }
}
