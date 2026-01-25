<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahPelanggan = Pelanggan::count();

        return view('admin.dashboard', compact('jumlahPelanggan'));
    }
}
