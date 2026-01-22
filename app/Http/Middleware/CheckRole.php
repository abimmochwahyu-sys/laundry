<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  <-- Tambahkan parameter ini
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah role user sesuai dengan parameter middleware
        // Asumsi: Tabel users memiliki kolom 'role'
        if ($request->user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}