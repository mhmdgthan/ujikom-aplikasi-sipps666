<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek user web (admin, guru, dsb)
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if (in_array($user->level, $roles)) {
                return $next($request);
            }

            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Cek user siswa
        if (Auth::guard('siswa')->check()) {
            if (in_array('siswa', $roles)) {
                return $next($request);
            }

            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Kalau belum login sama sekali, redirect ke halaman login sesuai role
        if (in_array('siswa', $roles)) {
            return redirect()->route('login.siswa');
        }

        return redirect()->route('login');
    }
}
