<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;

class PelangganTransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['layanan'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pelanggan.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $layanans = Layanan::all();
        return view('pelanggan.transaksi.create', compact('layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,e-wallet',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $berat = $request->berat;
        $subtotal = $layanan->harga * $berat;

        // Hitung diskon jika berat > 4kg (3%)
        $diskon = 0;
        if ($berat > 4) {
            $diskon = $subtotal * 0.03;
        }

        $totalAkhir = $subtotal - $diskon;

        // Generate kode transaksi unik
        $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . rand(1000, 9999);

        Transaksi::create([
            'user_id' => auth()->id(),
            'layanan_id' => $request->layanan_id,
            'kode_transaksi' => $kodeTransaksi,
            'berat' => $berat,
            'total_harga' => $subtotal,
            'diskon' => $diskon,
            'total_akhir' => $totalAkhir,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'pending',
            'status_transaksi' => 'pending',
            'tanggal_transaksi' => now(),
        ]);

        return redirect()
            ->route('pelanggan.transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['layanan'])
            ->where('user_id', auth()->id())
            ->findOrFail($id)
            ->fresh();

        return view('pelanggan.transaksi.show', compact('transaksi'));
    }

    public function pickup($id)
    {
        $transaksi = Transaksi::where('user_id', auth()->id())->findOrFail($id);

        if ($transaksi->status_transaksi != 'selesai') {
            return redirect()->back()->with('error', 'Transaksi belum selesai');
        }

        $transaksi->update(['status_transaksi' => 'diambil']);

        return redirect()
            ->route('pelanggan.transaksi.index')
            ->with('success', 'Terima kasih, laundry Anda telah diambil');
    }
}
