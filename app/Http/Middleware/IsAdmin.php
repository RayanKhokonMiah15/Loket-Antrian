<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return $next($request); // ✅ Admin boleh lanjut
            }

            // ✅ Sudah login tapi bukan admin
            return redirect()->route('user.index')->withErrors('Anda tidak memiliki akses ke halaman admin.');
        }

        // ✅ Belum login
        return redirect()->route('admin.login');
    }
}
