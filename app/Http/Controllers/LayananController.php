<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    // ... kode lainnya ...

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $layanan = Layanan::findOrFail($id);
        
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'jenis_layanan' => 'required|string|max:255',
            'harga_per_kilo' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $layanan->update($validatedData);

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        $request->validate([
            'status_pembayaran' => 'required|in:pending,dibayar,dibatalkan',
        ]);
        
        $transaksi->status_pembayaran = $request->status_pembayaran;
        
        // If payment is marked as paid, update status to proses
        if ($request->status_pembayaran == 'dibayar' && $transaksi->status == 'pending') {
            $transaksi->status = 'proses';
        }
        
        $transaksi->save();
        
        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}