<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Diskon;
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
    
    public function update(Request $request, $id)
{
    $transaksi = Transaksi::with(['layanan'])->findOrFail($id);

    $request->validate([
        'status_transaksi' => 'required|in:pending,proses,selesai',
        'status_pembayaran' => 'required|in:pending,lunas',
        'tanggal_selesai' => 'nullable|date',
        'diskon_id' => 'nullable|exists:diskons,id',
    ]);

    $updateData = [
        'status_transaksi' => $request->status_transaksi,
        'status_pembayaran' => $request->status_pembayaran,
        'tanggal_selesai' => $request->tanggal_selesai,
        'diskon_id' => $request->diskon_id,
    ];

    // Hitung ulang diskon jika ada perubahan diskon
    if ($request->has('diskon_id')) {
        $diskon = null;
        $nilaiDiskon = 0;

        if ($request->diskon_id) {
            $diskon = Diskon::find($request->diskon_id);
            if ($diskon && $diskon->isValidForAmount($transaksi->total_harga)) {
                $nilaiDiskon = $diskon->calculateDiscount($transaksi->total_harga);
            }
        }

        $updateData['diskon'] = $nilaiDiskon;
        $updateData['total_akhir'] = $transaksi->total_harga - $nilaiDiskon;
    }

    $transaksi->update($updateData);

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

public function destroy($id)
{
    $transaksi = Transaksi::findOrFail($id);

    if ($transaksi->status_pembayaran !== 'lunas') {
        return redirect()->back()->with('error', 'Transaksi belum lunas. Bayar terlebih dahulu sebelum menghapus.');
    }

    $transaksi->delete();

    return redirect()->route('admin.transaksi.index')
        ->with('success', 'Transaksi berhasil dihapus.');
}

}