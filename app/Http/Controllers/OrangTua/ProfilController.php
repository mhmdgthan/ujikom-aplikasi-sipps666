<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orangTua = $user->orangTua()->with(['siswa.kelas.jurusan'])->first();
        
        if (!$orangTua) {
            return redirect()->route('orang-tua.dashboard')->with('error', 'Data orang tua tidak ditemukan');
        }

        return view('orang-tua.profil.index', compact('user', 'orangTua'));
    }
}