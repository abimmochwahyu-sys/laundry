<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KaryawanTransaksiController extends Controller
{
    // Tampilkan semua transaksi
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'layanan'])->latest()->paginate(10);
        return view('karyawan.transaksi.index', compact('transaksis'));
    }

    // Tampilkan detail transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])->findOrFail($id);

        // Jika tanggal_selesai kosong, hitung otomatis dari tanggal_transaksi + estimasi_hari
        if (!$transaksi->tanggal_selesai && $transaksi->layanan->estimasi_hari) {
            $transaksi->tanggal_selesai = Carbon::parse($transaksi->tanggal_transaksi)
                ->addDays($transaksi->layanan->estimasi_hari);
            $transaksi->save();
        }

        return view('karyawan.transaksi.show', compact('transaksi'));
    }

    // Form edit transaksi
    public function edit($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])->findOrFail($id);
        return view('karyawan.transaksi.edit', compact('transaksi'));
    }

    // Update transaksi (status / tanggal selesai)
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'status_transaksi' => 'required|in:pending,proses,selesai,diambil',
            'status_pembayaran' => 'required|in:pending,lunas',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $transaksi->update([
            'status_transaksi' => $request->status_transaksi,
            'status_pembayaran' => $request->status_pembayaran,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('karyawan.transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    // Tandai pembayaran sebagai lunas / konfirmasi pembayaran
    public function confirmPayment($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->status_pembayaran = 'lunas';
        $transaksi->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil dikonfirmasi LUNAS.');
    }

    // Tampilkan invoice
    public function invoice($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])->findOrFail($id);
        return view('karyawan.transaksi.invoice', compact('transaksi'));
    }
}
