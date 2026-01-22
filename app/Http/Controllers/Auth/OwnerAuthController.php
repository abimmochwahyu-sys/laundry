<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerAuthController extends Controller
{
    public function showLogin()
    {
        return view('owner.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            if (Auth::user()->role !== 'owner') {
                Auth::logout();
                return back()->with('error', 'Bukan akun owner');
            }

            return redirect()->route('owner.dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }
}
