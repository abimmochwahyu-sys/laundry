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
    // EXPORT LAPORAN (CSV)
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

        $filename = 'laporan-transaksi-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($transaksis) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Tanggal',
                'Pelanggan',
                'Layanan',
                'Berat (Kg)',
                'Total Harga'
            ]);

            foreach ($transaksis as $t) {
                fputcsv($file, [
                    $t->tanggal_transaksi,
                    $t->user->name ?? '-',
                    $t->layanan->nama_layanan ?? '-',
                    $t->berat,
                    $t->total_harga,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
