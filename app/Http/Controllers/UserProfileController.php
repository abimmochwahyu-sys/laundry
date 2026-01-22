<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user = User::find(auth()->id());
        
        // Update data profil
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        
        // Update password jika diisi
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}