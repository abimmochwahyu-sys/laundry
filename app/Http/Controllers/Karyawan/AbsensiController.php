<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('karyawan.absensi.index', compact('absensis'));
    }

    public function absenMasuk()
{
    $today = Carbon::today();
    $now = Carbon::now();
    $jamMasuk = Carbon::createFromTime(8, 0, 0); // 08:00

    $cek = Absensi::where('user_id', Auth::id())
        ->where('tanggal', $today)
        ->first();

    if ($cek) {
        return back()->with('error', 'Anda sudah absen hari ini');
    }

    $status = 'hadir';

    if ($now->greaterThan($jamMasuk)) {
        $status = 'telat';
        session()->flash('warning', 'Anda telat masuk!');
    }

    Absensi::create([
        'user_id' => Auth::id(),
        'tanggal' => $today,
        'jam_masuk' => $now->format('H:i:s'),
        'status' => $status
    ]);

    return back()->with('success', 'Berhasil absen masuk');
}
    public function absenKeluar()
{
    $today = Carbon::today();
    $now = Carbon::now();
    $jamKeluar = Carbon::createFromTime(14, 30, 0); // 14:30

    $absen = Absensi::where('user_id', Auth::id())
        ->where('tanggal', $today)
        ->first();

    if (!$absen) {
        return back()->with('error', 'Anda belum absen masuk');
    }

    if ($now->lessThan($jamKeluar)) {
        return back()->with('error', 'Belum waktunya absen keluar (14:30)');
    }

    $absen->update([
        'jam_keluar' => $now->format('H:i:s')
    ]);

    return back()->with('success', 'Berhasil absen keluar');
}
}