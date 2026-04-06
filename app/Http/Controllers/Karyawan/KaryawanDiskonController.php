<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KaryawanDiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diskons = Diskon::orderBy('created_at', 'desc')->paginate(10);

        return view('karyawan.diskon.index', compact('diskons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.diskon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_diskon' => 'required|string|unique:diskons,kode_diskon',
            'keterangan' => 'required|string|max:255',
            'tipe_diskon' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimum_belanja' => 'required|numeric|min:0',
            'berlaku_sampai' => 'required|date|after:today',
            'is_active' => 'boolean'
        ]);

        // Validasi nilai berdasarkan tipe diskon
        if ($request->tipe_diskon === 'persen' && $request->nilai > 100) {
            return back()->withErrors(['nilai' => 'Diskon persen tidak boleh lebih dari 100%']);
        }

        Diskon::create($request->all());

        return redirect()->route('karyawan.diskon.index')
                        ->with('success', 'Diskon berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diskon $diskon)
    {
        return view('karyawan.diskon.show', compact('diskon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diskon $diskon)
    {
        return view('karyawan.diskon.edit', compact('diskon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diskon $diskon)
    {
        $request->validate([
            'kode_diskon' => 'required|string|unique:diskons,kode_diskon,' . $diskon->id,
            'keterangan' => 'required|string|max:255',
            'tipe_diskon' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'minimum_belanja' => 'required|numeric|min:0',
            'berlaku_sampai' => 'required|date',
            'is_active' => 'boolean'
        ]);

        // Validasi nilai berdasarkan tipe diskon
        if ($request->tipe_diskon === 'persen' && $request->nilai > 100) {
            return back()->withErrors(['nilai' => 'Diskon persen tidak boleh lebih dari 100%']);
        }

        $diskon->update($request->all());

        return redirect()->route('karyawan.diskon.index')
                        ->with('success', 'Diskon berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diskon $diskon)
    {
        $diskon->delete();

        return redirect()->route('karyawan.diskon.index')
                        ->with('success', 'Diskon berhasil dihapus');
    }

    /**
     * Toggle status aktif/nonaktif diskon
     */
    public function toggleStatus(Diskon $diskon)
    {
        $diskon->update(['is_active' => !$diskon->is_active]);

        $status = $diskon->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('karyawan.diskon.index')
                        ->with('success', 'Diskon berhasil ' . $status);
    }
}
