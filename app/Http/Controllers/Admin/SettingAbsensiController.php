<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingAbsensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SettingAbsensiController extends Controller
{

    public function index()
    {
        $setting = SettingAbsensi::first();

        return view('admin.absensi.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required',
            'batas_telat' => 'required',
            'jam_keluar' => 'required'
        ]);

        $setting = SettingAbsensi::first();

        if ($setting) {

            // update jika sudah ada
            $setting->update([
                'jam_masuk' => $request->jam_masuk,
                'batas_telat' => $request->batas_telat,
                'jam_keluar' => $request->jam_keluar,
            ]);

        } else {

            // create jika belum ada
            SettingAbsensi::create([
                'jam_masuk' => $request->jam_masuk,
                'batas_telat' => $request->batas_telat,
                'jam_keluar' => $request->jam_keluar,
            ]);

        }

        return back()->with('success','Pengaturan jam absensi berhasil disimpan');
    }
}