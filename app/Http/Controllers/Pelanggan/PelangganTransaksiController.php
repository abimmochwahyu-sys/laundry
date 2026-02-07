<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;


class PelangganTransaksiController extends Controller
{
    public function __construct()
    {
        // ✅ Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION'), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = filter_var(env('MIDTRANS_SANITIZED'), FILTER_VALIDATE_BOOLEAN);
        Config::$is3ds = filter_var(env('MIDTRANS_3DS'), FILTER_VALIDATE_BOOLEAN);
    }

    public function index()
    {
        $transaksis = Transaksi::with('layanan')
            ->where('user_id', Auth::id())
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
            'metode_pembayaran' => 'required|in:cash,midtrans',
        ]);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $berat = $request->berat;

        // 💰 Hitung harga sesuai KaryawanTransaksiController
        $subtotal = $layanan->harga * $berat;

        // ✅ Diskon 3% jika berat > 4 kg
        $diskon = $berat > 4 ? $subtotal * 0.03 : 0;

        // Total akhir
        $totalAkhir = $subtotal - $diskon;

        $kodeTransaksi = 'TRX-' . now()->format('Ymd') . '-' . rand(1000, 9999);

        // 🧾 Simpan transaksi
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'layanan_id' => $request->layanan_id,
            'kode_transaksi' => $kodeTransaksi,
            'berat' => $berat,
            'total_harga' => $subtotal,
            'diskon' => $diskon,
            'total_akhir' => $totalAkhir,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->metode_pembayaran === 'cash' ? 'lunas' : 'pending',
            'status_transaksi' => 'proses',
            'tanggal_transaksi' => now(),
        ]);

        // 🔹 Generate Snap token jika metode Midtrans
        if ($request->metode_pembayaran === 'midtrans') {
            $transaksi = $this->generateSnapToken($transaksi);
        }

        return redirect()
            ->route('pelanggan.transaksi.show', $transaksi->id)
            ->with('success', 'Transaksi berhasil dibuat, silakan lakukan pembayaran jika non-cash.');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('layanan')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // 🔹 Pastikan Snap token ada untuk transaksi lama
        if ($transaksi->metode_pembayaran === 'midtrans' && !$transaksi->snap_token) {
            $transaksi = $this->generateSnapToken($transaksi);
        }

        return view('pelanggan.transaksi.show', compact('transaksi'));
    }

    public function pickup($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($transaksi->status_transaksi !== 'selesai') {
            return back()->with('error', 'Transaksi belum selesai');
        }

        $transaksi->update([
            'status_transaksi' => 'diambil'
        ]);

        return redirect()
            ->route('pelanggan.transaksi.index')
            ->with('success', 'Terima kasih, laundry Anda telah diambil');
    }

    /**
     * 🔹 Generate Snap token untuk transaksi Midtrans
     */
    private function generateSnapToken($transaksi)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_transaksi,
                'gross_amount' => $transaksi->total_akhir,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);
            $transaksi->snap_token = $snapToken; // update langsung untuk view
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan Midtrans: ' . $e->getMessage());
        }

        return $transaksi;
    }
}
