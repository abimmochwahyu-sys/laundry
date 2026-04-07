<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Exports\LaporanTransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Carbon\Carbon;

class OwnerLaporanController extends Controller
{
    public function index()
    {
        $laporan = Transaksi::with(['layanan', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.laporan', compact('laporan'));
    }

    public function exportExcel()
    {
        $laporan = Transaksi::with(['layanan', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'laporan-transaksi-' . Carbon::now()->format('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new LaporanTransaksiExport($laporan), $fileName);
    }

    public function exportPdf()
    {
        $laporan = Transaksi::with(['layanan', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'laporan' => $laporan,
            'tanggal' => Carbon::now()->format('d M Y'),
            'total_transaksi' => $laporan->count(),
            'total_pendapatan' => $laporan->sum('total_harga'),
            'rata_rata' => $laporan->avg('total_harga') ?? 0,
        ];

        $dompdf = new Dompdf();
        $html = view('owner.exports.laporan-pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
 
        $fileName = 'laporan-transaksi-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';
 
        return $dompdf->stream($fileName, ['Attachment' => false]);
    }

    public function testPdf()
    {
        try {
            $data = [
                'message' => 'PDF Test Berhasil!',
                'timestamp' => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            $dompdf = new Dompdf();
            $html = view('owner.exports.test-pdf', $data)->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $dompdf->stream('test-pdf.pdf', ['Attachment' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
