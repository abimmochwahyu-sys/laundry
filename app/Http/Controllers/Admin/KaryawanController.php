<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::latest()->get();
        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed', // pastikan ada input password_confirmation di form
    ]);

    // Buat user baru
    $user = User::create([
        'name'     => $request->nama,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'karyawan',
    ]);

    // Buat data karyawan terkait user
    Karyawan::create([
        'user_id' => $user->id,
        'telepon' => "-",
        'alamat'  => "-",
    ]);

    return redirect()
        ->route('admin.karyawan.index')
        ->with('success', 'Karyawan berhasil ditambahkan');
}

    public function edit(Karyawan $karyawan)
    {
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama'    => 'required',
            'telepon' => 'required',
            'alamat'  => 'required',
        ]);
    
        // Update nama di table users
        $user = $karyawan->user; // pastikan relasi di model Karyawan ada: user()
        $user->update([
            'name' => $request->nama,
        ]);
    
        // Update data karyawan
        $karyawan->update([
            'telepon' => $request->telepon,
            'alamat'  => $request->alamat,
        ]);
    
        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil diupdate');
    }


    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus');
    }
}
