<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectTo(Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    protected function redirectTo($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            case 'karyawan':
                return redirect()->route('karyawan.dashboard')->with('success', 'Selamat datang Karyawan!');
            case 'owner':
                return redirect()->route('owner.dashboard')->with('success', 'Selamat datang Owner!');
            case 'pelanggan':
                return redirect()->route('pelanggan.dashboard')->with('success', 'Selamat datang Pelanggan!');
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Role tidak dikenali.');
        }
    }


    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
