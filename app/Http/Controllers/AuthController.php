<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ====== LOGIN ======
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect sesuai role
             if ($role === 'admin') {
        return redirect()->route('admin.dashboard');

    } elseif ($role === 'karyawan') {
        return redirect()->route('karyawan.dashboard');

    } elseif ($role === 'owner') {
        return redirect()->route('owner.dashboard');

    } else {
        Auth::logout();
        return back()->with('error', 'Role tidak dikenali');
    }
}

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // ====== REGISTER (khusus user/pelanggan) ======
    public function showRegisterForm()
    {
        return view('auth.register'); // bikin file resources/views/auth/register.blade.php
    }

    public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|unique:users,username|max:100',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|confirmed|min:6',
    ]);

    User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'user', // default role pelanggan
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
}


    // ====== LOGOUT ======
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
