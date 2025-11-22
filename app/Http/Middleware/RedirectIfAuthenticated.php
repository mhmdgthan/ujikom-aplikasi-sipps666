<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'siswa') {
                    return redirect()->route('siswa.dashboard');
                }
                
                $user = Auth::guard('web')->user();
                return $this->redirectByLevel($user->level ?? 'home');
            }
        }

        return $next($request);
    }

    protected function redirectByLevel($level)
    {
        $redirects = [
            'admin' => route('admin.dashboard'),
            'kepala_sekolah' => route('kepala-sekolah.dashboard'),
            'kesiswaan' => route('kesiswaan.dashboard'),
            'bk' => route('bk.dashboard'),
            'guru' => route('guru.dashboard'),
            'wali_kelas' => route('wali-kelas.dashboard'),
            'orang_tua' => route('orang-tua.dashboard'),
        ];

        return redirect()->to($redirects[$level] ?? route('welcome'));
    }
}
