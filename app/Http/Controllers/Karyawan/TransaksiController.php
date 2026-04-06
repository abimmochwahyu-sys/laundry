<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diskon;

class TransaksiController extends Controller
{
    public function create()
    {
        return view('karyawan.transaksi.create', [
            'layanans' => Layanan::all(),
            'metodePembayarans' => MetodePembayaran::all(),
            'diskons' => Diskon::active()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,e-wallet',
            'diskon_id' => 'nullable|exists:diskons,id',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $subtotal = $layanan->harga * $request->berat;
        $diskon = 0;

        // Hitung diskon jika dipilih
        if ($request->diskon_id) {
            $diskonModel = Diskon::findOrFail($request->diskon_id);

            // Validasi diskon
            if (!$diskonModel->isValidForAmount($subtotal)) {
                return back()
                    ->withInput()
                    ->withErrors(['diskon_id' => 'Diskon tidak valid untuk total belanja ini']);
            }

            $diskon = $diskonModel->calculateDiscount($subtotal);
        }

        $total = $subtotal - $diskon;

        Transaksi::create([
            'user_id' => Auth::id(),
            'layanan_id' => $request->layanan_id,
            'berat_kg' => $request->berat,
            'diskon_id' => $request->diskon_id,
            'subtotal' => $subtotal,
            'total_diskon' => $diskon,
            'total_harga' => $total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'proses',
        ]);

        return redirect()
            ->route('karyawan.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }
}
