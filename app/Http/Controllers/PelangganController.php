<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\User;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = User::where('role', 'pelanggan')->paginate(10);
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('admin.pelanggan.create'); // ✅ arahkan ke folder admin
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('admin.pelanggan.index') // ✅ route pakai prefix admin
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan')); // ✅ arahkan ke folder admin
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
        ]);

        $pelanggan->update($request->all());

        return redirect()->route('admin.pelanggan.index') // ✅ route pakai prefix admin
            ->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('admin.pelanggan.index') // ✅ route pakai prefix admin
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}
