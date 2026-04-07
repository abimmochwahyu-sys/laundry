<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Exports\TransaksiExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;

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
        $startDate = $request->filled('start_date') ? $request->start_date : null;
        $endDate = $request->filled('end_date') ? $request->end_date : null;

        $filename = 'laporan-transaksi-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new TransaksiExport($startDate, $endDate), $filename);
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

        $data = [
            'transaksis' => $transaksis,
            'tanggal' => Carbon::now()->format('d M Y'),
            'total_transaksi' => $transaksis->count(),
            'total_pendapatan' => $transaksis->sum('total_harga'),
            'total_diskon' => $transaksis->sum('diskon'),
            'total_akhir' => $transaksis->sum('total_akhir'),
        ];

        $dompdf = new Dompdf();
        $html = view('admin.exports.laporan-pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'laporan-admin-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        return $dompdf->stream($fileName, ['Attachment' => false]);
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
