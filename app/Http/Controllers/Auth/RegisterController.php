<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // WAJIB DIIMPORT

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'alamat' => 'required|string',
        'telepon' => 'required|string|max:20',
    ], [
        'email.unique' => 'Email sudah terdaftar!',
        'password.min' => 'Password minimal 6 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    try {
        return DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'pelanggan',
            ]);

            Pelanggan::create([
                'user_id' => $user->id,
                'telepon' => $validated['telepon'],
                'alamat'  => $validated['alamat'],
            ]);

            return redirect()
                ->route('login')
                ->with('success', 'Akun berhasil didaftarkan. Silahkan login.');
        });

    } catch (\Throwable $th) {

        \Log::error("Registrasi Gagal: " . $th->getMessage());

        return back()
            ->withInput()
            ->withErrors(['email' => 'Gagal daftar']);
    }
}
}