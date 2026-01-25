<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('owner.login');
        }

        if (Auth::user()->role !== 'owner') {
            Auth::logout();
            return redirect()->route('owner.login')
                ->with('error', 'Akses ditolak');
        }

        return $next($request);
    }
}
