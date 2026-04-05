<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    /**
     * Tampilkan halaman profil (untuk semua role)
     */
    public function index()
    {
        $user = auth()->user();
        $role = auth()->user()->role;
        
        // Tentukan view berdasarkan role
        if ($role === 'admin') {
            return view('admin.profile-unified', compact('user', 'role'));
        } elseif ($role === 'karyawan') {
            return view('karyawan.profile', compact('user', 'role'));
        } elseif ($role === 'owner') {
            return view('owner.profile', compact('user', 'role'));
        } else {
            return view('pelanggan.profile', compact('user', 'role'));
        }
    }
    
    /**
     * Update data profil (untuk semua role)
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Update data profil
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update password jika diisi
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        $routeName = auth()->user()->role === 'admin' ? 'admin.profile.index' : 
                     (auth()->user()->role === 'karyawan' ? 'karyawan.profile' :
                     (auth()->user()->role === 'owner' ? 'owner.profile' : 'pelanggan.profile'));
        
        return redirect()->route($routeName)->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Update password (untuk semua role)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();
        
        $routeName = auth()->user()->role === 'admin' ? 'admin.profile.index' : 
                     (auth()->user()->role === 'karyawan' ? 'karyawan.profile' :
                     (auth()->user()->role === 'owner' ? 'owner.profile' : 'pelanggan.profile'));
        
        return back()->with('success', 'Password berhasil diperbarui!');
    }
}