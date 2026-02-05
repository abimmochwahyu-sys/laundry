<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ================= VALIDASI =================
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'alamat'  => 'nullable|string',
            'telepon' => 'nullable|string',
        ]);

        // ================= FOTO =================
        if ($request->hasFile('photo')) {

            // hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists('profile/' . $user->photo)) {
                Storage::disk('public')->delete('profile/' . $user->photo);
            }

            // nama file unik (AMAN)
            $filename = Str::uuid() . '.' . $request->photo->extension();

            // simpan ke storage/app/public/profile
            $request->photo->storeAs('profile', $filename, 'public');

            $user->photo = $filename;
        }

        // ================= USER =================
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        // ================= KARYAWAN =================
        if ($user->karyawan) {
            $user->karyawan->update([
                'alamat'  => $request->alamat,
                'telepon' => $request->telepon,
            ]);
        }

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
