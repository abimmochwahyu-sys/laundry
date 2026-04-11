<?php

namespace App\Http\Controllers\Owner;

// Update OwnerKaryawanController and add logic for index only

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Exports\KaryawanExport;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OwnerKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Mengambil semua data karyawan beserta informasi user-nya
        $karyawans = Karyawan::with('user')->latest()->get();
        return view('owner.karyawan.index', compact('karyawans'));
    }

    public function exportExcel()
    {
        $karyawans = Karyawan::with('user')->latest()->get();
        $fileName = 'data-karyawan-' . Carbon::now()->format('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new KaryawanExport($karyawans), $fileName);
    }

    public function exportPdf()
    {
        $karyawans = Karyawan::with('user')->latest()->get();
        
        $data = [
            'karyawans' => $karyawans,
            'tanggal' => Carbon::now()->format('d M Y'),
            'total_karyawan' => $karyawans->count(),
        ];

        $dompdf = new Dompdf();
        $html = view('owner.exports.karyawan-pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'data-karyawan-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        return $dompdf->stream($fileName, ['Attachment' => false]);
    }
}
