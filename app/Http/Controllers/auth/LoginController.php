<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Siswa;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showLoginSiswaForm()
    {
        return view('auth.login-siswa');
    }
    public function login(Request $request)
    {
        $request->validate(rules: [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::attemptLogin($request->username, $request->password);

        if ($user) {
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
            return $this->redirectByLevel($user->level);
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])
                     ->withInput($request->only('username'));
    }
    public function loginSiswa(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
            'password' => 'required|string',
        ]);

        $siswa = Siswa::attemptLogin($request->nisn, $request->password);

        if ($siswa) {
            Auth::guard('siswa')->login($siswa);
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['nisn' => 'NISN atau password salah.'])
                     ->withInput($request->only('nisn'));
    }
    protected function redirectByLevel($level)
    {
        $redirects = [
            'admin'           => route(name: 'admin.dashboard'),
            'kepala_sekolah'  => route('kepala-sekolah.dashboard'),
            'kesiswaan'       => route('kesiswaan.dashboard'),
            'bk'              => route('bk.dashboard'),
            'wali_kelas'      => route('wali-kelas.dashboard'),
            'orang_tua'       => route('orang-tua.dashboard'),
            'guru'            => route('guru.dashboard'),
            'siswa'           => route('siswa.dashboard'),
        ];

        return redirect()->to($redirects[$level] ?? route('login'));
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('message', 'Anda telah berhasil logout');
    }
    public function logoutSiswa(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->regenerateToken();
        return redirect()->route('login.siswa');
    }
}
