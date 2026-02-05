<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        return view('pelanggan.profil');
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,' . Auth::id(),
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        Auth::user()->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
