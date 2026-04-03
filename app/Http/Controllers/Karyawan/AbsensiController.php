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
}