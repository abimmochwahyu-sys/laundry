<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendapatan = Transaksi::sum('total_harga');
        $totalTransaksi  = Transaksi::count();
        $transaksiProses = Transaksi::count();
        $totalKaryawan   = User::where('role', 'karyawan')->count();

        // PENDAPATAN PER BULAN (REAL)
        $pendapatanBulanan = Transaksi::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan');

        // Label bulan Indonesia
        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $chartLabels = [];
        $chartData   = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $namaBulan[$i];
            $chartData[]   = $pendapatanBulanan[$i] ?? 0;
        }

        return view('owner.dashboard', compact(
            'totalPendapatan',
            'totalTransaksi',
            'transaksiProses',
            'totalKaryawan',
            'chartLabels',
            'chartData'
        ));
    }
}
