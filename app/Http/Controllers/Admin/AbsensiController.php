<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with('user')->latest()->paginate(10);

        return view('admin.absensi.index', compact('absensis'));
    }
}