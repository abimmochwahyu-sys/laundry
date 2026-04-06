<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan']);

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate   = Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $transaksis = $query
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.index', compact('transaksis'));
    }

    // ===============================
    // EXPORT LAPORAN (EXCEL)
    // ===============================
    public function export(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate   = Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $transaksis = $query
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $filename = 'laporan-transaksi-' . now()->format('Y-m-d') . '.xlsx';

        // Create CSV content manually (Excel compatible)
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($transaksis) {
            $file = fopen('php://output', 'w');

            // Write BOM for Excel UTF-8 recognition
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Write headers
            fputcsv($file, [
                'No',
                'Kode Transaksi',
                'Tanggal',
                'Pelanggan',
                'Layanan',
                'Berat (Kg)',
                'Harga / Kg',
                'Total Harga',
                'Diskon',
                'Total Akhir',
                'Status Pembayaran',
                'Status Transaksi',
            ]);

            // Write data
            foreach ($transaksis as $index => $transaksi) {
                fputcsv($file, [
                    $index + 1,
                    $transaksi->kode_transaksi,
                    $transaksi->tanggal_transaksi->format('d-m-Y'),
                    $transaksi->user->name ?? '-',
                    $transaksi->layanan->jenis_layanan ?? '-',
                    number_format($transaksi->berat, 2),
                    'Rp ' . number_format($transaksi->layanan->harga_per_kg ?? 0, 0, ',', '.'),
                    'Rp ' . number_format($transaksi->total_harga, 0, ',', '.'),
                    'Rp ' . number_format($transaksi->diskon, 0, ',', '.'),
                    'Rp ' . number_format($transaksi->total_akhir, 0, ',', '.'),
                    $transaksi->status_pembayaran === 'pending' ? 'Pending' : 'Lunas',
                    ucfirst($transaksi->status_transaksi),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ===============================
    // CETAK PELAPORAN PDF
    // ===============================
    public function print(Request $request)
    {
        $query = Transaksi::with(['user', 'layanan']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate   = Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $transaksis = $query
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('admin.laporan.print', compact('transaksis'));
    }

    // ===============================
    // CETAK INVOICE
    // ===============================
    public function invoice($id)
    {
        $transaksi = Transaksi::with(['user', 'layanan'])
            ->findOrFail($id);

        return view('admin.laporan.invoice', compact('transaksi'));
    }
}
