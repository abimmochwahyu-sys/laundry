<?php

// app/Http/Controllers/Admin/LayananController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::latest()->paginate(10);
        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'estimasi_waktu' => 'nullable|numeric|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'estimasi_waktu' => 'nullable|numeric|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}

