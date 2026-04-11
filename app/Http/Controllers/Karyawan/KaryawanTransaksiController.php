<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Layanan;
use App\Models\Diskon;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class KaryawanTransaksiController extends Controller
{
    public function __construct()
    {
        // ✅ Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION'), FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = filter_var(env('MIDTRANS_SANITIZED'), FILTER_VALIDATE_BOOLEAN);
        Config::$is3ds = filter_var(env('MIDTRANS_3DS'), FILTER_VALIDATE_BOOLEAN);
    }
    // Tampilkan semua transaksi
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'layanan'])->latest()->paginate(10);
        return view('karyawan.transaksi.index', compact('transaksis'));
    }

    // Form buat transaksi baru
    public function create()
    {
        return view('karyawan.transaksi.create', [
            'layanans' => Layanan::all(),
            'diskons' => Diskon::active()->get(),
            'pelanggans' => \App\Models\User::where('role', 'pelanggan')->get(),
        ]);
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nama_guest' => 'required_without:user_id|nullable|string|max:255',
            'no_hp_guest' => 'required_without:user_id|nullable|string|max:20',
            'layanan_id' => 'required|exists:layanans,id',
            'berat' => 'required|numeric|min:0.1',
            'metode_pembayaran' => 'required|in:cash,midtrans',
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

        $kodeTransaksi = 'TRX-' . now()->format('Ymd') . '-' . rand(1000, 9999);

        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'nama_guest' => $request->nama_guest,
            'no_hp_guest' => $request->no_hp_guest,
            'layanan_id' => $request->layanan_id,
            'berat' => $request->berat,
            'diskon_id' => $request->diskon_id,
            'kode_transaksi' => $kodeTransaksi,
            'subtotal' => $subtotal,
            'total_diskon' => $diskon,
            'diskon' => $diskon,
            'total_harga' => $total,
            'total_akhir' => $total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->metode_pembayaran === 'cash' ? 'lunas' : 'pending',
            'status_transaksi' => 'proses',
            'tanggal_transaksi' => now()->toDateString(),
        ]);

        // 🔹 Generate Snap token jika metode Midtrans
        if ($request->metode_pembayaran === 'midtrans') {
            $transaksi = $this->generateSnapToken($transaksi);
        }

        return redirect()
            ->route('karyawan.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    // Tampilkan detail transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])->findOrFail($id);

        // 🔹 Pastikan Snap token ada untuk transaksi Midtrans
        if ($transaksi->metode_pembayaran === 'midtrans' && !$transaksi->snap_token) {
            $transaksi = $this->generateSnapToken($transaksi);
        }

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
    // ⚠️ IMPORTANT: Karyawan hanya bisa set ke pending/proses/selesai
    // 'diambil' status hanya bisa di-set oleh customer via pickup confirmation
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'status_transaksi' => 'required|in:pending,proses,selesai',
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

    // Update status transaksi saja
    // ⚠️ IMPORTANT: Karyawan hanya bisa set ke pending/proses/selesai
    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'status_transaksi' => 'required|in:pending,proses,selesai',
        ]);

        $transaksi->update([
            'status_transaksi' => $request->status_transaksi,
        ]);

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui');
    }

    // Tandai pembayaran sebagai lunas / konfirmasi pembayaran
    public function confirmPayment($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->status_pembayaran = 'lunas';
        $transaksi->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil dikonfirmasi LUNAS.');
    }

    // Mark transaksi as lunas (untuk route PUT)
    public function markAsLunas($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->status_pembayaran = 'lunas';
        $transaksi->save();

        return redirect()->back()->with('success', 'Transaksi berhasil ditandai LUNAS.');
    }

    // Tampilkan invoice
    public function invoice($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])->findOrFail($id);
        return view('karyawan.transaksi.invoice', compact('transaksi'));
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
                'first_name' => $transaksi->customer_name,
                'email' => $transaksi->user ? $transaksi->user->email : 'guest@siclean.com',
                'phone' => $transaksi->customer_phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);
            $transaksi->snap_token = $snapToken;
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan Midtrans: ' . $e->getMessage());
        }

        return $transaksi;
    }
}
