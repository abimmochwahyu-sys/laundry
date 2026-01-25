<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::with('user')->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'alamat'   => 'required|string|max:255',
            'telepon'  => 'required|string|max:15',
        ]);

        // simpan ke tabel users
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make('password'),
            'role'     => 'pelanggan',
        ]);

        // simpan ke tabel pelanggans
        Pelanggan::create([
            'user_id' => $user->id,
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::with('user')->findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $pelanggan->user_id,
            'alamat'   => 'required|string|max:255',
            'telepon'  => 'required|string|max:15',
        ]);

        // update user
        $pelanggan->user->update([
            'name'  => $request->nama,
            'email' => $request->email,
        ]);

        // update pelanggan
        $pelanggan->update([
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // hapus user + pelanggan
        $pelanggan->user->delete();
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}
