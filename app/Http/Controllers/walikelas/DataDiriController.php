<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\WaliKelas;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Illuminate\Support\Facades\Auth;

class DataDiriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data guru
        $guru = Guru::where('user_id', $user->id)->first();
        
        // Ambil data wali kelas jika ada
        $waliKelas = WaliKelas::where('guru_id', $user->id)
            ->whereNull('tanggal_selesai')
            ->with(['kelas.jurusan', 'tahunAjaran'])
            ->first();
        
        // Statistik
        $totalPelanggaran = Pelanggaran::where('guru_pencatat', $guru->id ?? 0)->count();
        $totalPrestasi = Prestasi::where('guru_pencatat', $guru->id ?? 0)->count();
        $pelanggaranBulanIni = Pelanggaran::where('guru_pencatat', $guru->id ?? 0)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        
        // Jika wali kelas, hitung siswa di kelasnya
        $totalSiswaKelas = 0;
        if ($waliKelas) {
            $totalSiswaKelas = \App\Models\Siswa::where('kelas_id', $waliKelas->kelas_id)->count();
        }
        
        return view('wali-kelas.data-diri.index', compact(
            'user', 'guru', 'waliKelas', 'totalPelanggaran', 
            'totalPrestasi', 'pelanggaranBulanIni', 'totalSiswaKelas'
        ));
    }
}