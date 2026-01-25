<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;

class KaryawanTransaksiController extends Controller
{
    // Menampilkan daftar transaksi milik user dengan relasi layanan dan paginasi
    public function index()
    {
        $transaksis = Transaksi::with('layanan')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('karyawan.transaksi.index', compact('transaksis'));
    }

    // Form membuat transaksi baru
    public function create()
    {
        $layanans = Layanan::all();
        return view('karyawan.transaksi.create', compact('layanans'));
    }

    // Simpan transaksi baru dengan perhitungan harga dan diskon
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
        $diskon = $berat > 4 ? $subtotal * 0.1 : 0;
        $totalAkhir = $subtotal - $diskon;

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

        return redirect()->route('karyawan.transaksi.index')
                         ->with('success', 'Transaksi berhasil dibuat');
    }

    // Detail transaksi milik user
    public function show($id)
    {
        $transaksi = Transaksi::with('layanan')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('karyawan.transaksi.show', compact('transaksi'));
    }

    // Pickup laundry, ubah status transaksi jadi diambil jika status sebelumnya selesai
    public function pickup($id)
    {
        $transaksi = Transaksi::where('user_id', auth()->id())->findOrFail($id);

        if ($transaksi->status_transaksi != 'selesai') {
            return redirect()->back()->with('error', 'Transaksi belum selesai');
        }

        $transaksi->update(['status_transaksi' => 'diambil']);

        return redirect()->route('karyawan.transaksi.index')
                         ->with('success', 'Terima kasih, laundry Anda telah diambil');
    }

    // Update status transaksi dari form
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_transaksi' => 'required|in:pending,selesai,diambil',
        ]);

        $transaksi = Transaksi::where('user_id', auth()->id())->findOrFail($id);
        $transaksi->status_transaksi = $request->status_transaksi;
        $transaksi->save();

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
