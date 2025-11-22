<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Carbon\Carbon;

class DataDiriController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $guru = $user->guru;
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // PERBAIKAN: Gunakan $guru->id untuk query
        $pelanggaranDicatat = Pelanggaran::where('guru_pencatat', $guru->id)->count();
        $prestasiDicatat = Prestasi::where('guru_pencatat', $guru->id)->count();
        
        // Hitung pelanggaran yang sudah disetujui
        $pelanggaranDisetujui = Pelanggaran::where('guru_pencatat', $guru->id)
            ->where('status_verifikasi', 'disetujui')
            ->count();

        return view('guru.data-diri.index', compact(
            'user', 
            'guru',
            'pelanggaranDicatat', 
            'prestasiDicatat', 
            'pelanggaranDisetujui'
        ));
    }
}