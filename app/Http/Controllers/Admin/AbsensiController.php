<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\SettingAbsensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with('user')->latest()->paginate(10);

        return view('admin.absensi.index', compact('absensis'));
    }

    public function scan($userId)
{
    // 1. Ambil Setting Absensi
    $settings = SettingAbsensi::first();

    if (!$settings) {
        return redirect()->route('admin.absensi.index')
            ->with('error', 'Setting absensi belum dikonfigurasi!');
    }

    // 2. Cari user
    $user = \App\Models\User::find($userId);
    if (!$user) {
        return redirect()->route('admin.absensi.index')
            ->with('error', 'Karyawan tidak ditemukan!');
    }

    // Gunakan timezone Jakarta agar sinkron dengan waktu lokal
    $now = Carbon::now('Asia/Jakarta');
    $today = $now->toDateString(); // Format YYYY-MM-DD

    // Ambil data absen hari ini
    $absen = Absensi::where('user_id', $user->id)
        ->where('tanggal', $today)
        ->first();

    // --- LOGIKA ABSEN MASUK ---
    if (!$absen) {
        $status = 'hadir';

        // Bandingkan waktu sekarang dengan batas telat
        // Kita buat objek Carbon dari string database untuk perbandingan yang valid
        $batasTelat = Carbon::createFromFormat('H:i:s', $settings->batas_telat, 'Asia/Jakarta');
        
        if ($now->greaterThan($batasTelat)) {
            $status = 'telat';
            session()->flash('warning', "{$user->name} telat masuk!");
        }

        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'jam_masuk' => $now->format('H:i:s'),
            'status' => $status
        ]);

        return redirect()->route('admin.absensi.index')
            ->with('success', "Berhasil absen masuk: {$user->name}");
    }

    // --- LOGIKA ABSEN KELUAR ---
    
    // 1. Cek jika sudah pernah absen keluar
    if ($absen->jam_keluar) {
        return redirect()->route('admin.absensi.index')
            ->with('error', "{$user->name} sudah absen keluar hari ini!");
    }

    // 2. Perbaikan perbandingan jam keluar
    // Kita paksa formatnya sama (H:i:s) agar tidak ada gangguan milidetik
    $waktuSekarang = $now->format('H:i:s');
    $waktuPulang   = $settings->jam_keluar;

    if ($waktuSekarang < $waktuPulang) {
        return redirect()->route('admin.absensi.index')
            ->with('error', "Gagal! Belum waktunya pulang. Jam pulang: " . $waktuPulang);
    }

    // 3. Jika sudah waktunya, update jam keluar
    $absen->update([
        'jam_keluar' => $waktuSekarang
    ]);

    return redirect()->route('admin.absensi.index')
        ->with('success', "Berhasil absen keluar: {$user->name}. Selamat istirahat!");
}
}