<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'layanan'])->latest()->paginate(10);
        return view('admin.transaksi.index', compact('transaksis'));
    }
    
    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }
    
    public function edit($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])->findOrFail($id);
        return view('admin.transaksi.edit', compact('transaksi'));
    }
    
    // Di app/Http/Controllers/Admin/TransaksiController.php
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

    return redirect()->route('admin.transaksi.index')
        ->with('success', 'Transaksi berhasil diperbarui');
}

public function markAsLunas($id)
{
    $transaksi = Transaksi::findOrFail($id);

    $transaksi->status_pembayaran = 'lunas'; // ✅ konsisten
    $transaksi->save();

    return redirect()->back()->with('success', 'Status pembayaran berhasil diubah menjadi LUNAS.');
}

}