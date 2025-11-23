<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // jika belum login → arahkan ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // jika login tapi bukan admin → kembalikan ke login (bukan ke kasir)
        if (Auth::user()->role !== 'admin') {
            Auth::logout(); // supaya bersih
            return redirect()->route('login')
                ->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        // jika admin → lanjut
        return $next($request);
    }
}
