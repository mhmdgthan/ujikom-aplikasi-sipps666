<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\WaliKelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaKelasController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru->id ?? null;
        
        if (!$guruId) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        // Check if guru is wali kelas
        $waliKelas = WaliKelas::with(['kelas', 'tahunAjaran'])
            ->where('guru_id', $guruId)
            ->whereNull('tanggal_selesai')
            ->first();

        if (!$waliKelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda bukan wali kelas aktif');
        }

        // Get students in the class
        $siswa = Siswa::with(['kelas', 'orangTua'])
            ->where('kelas_id', $waliKelas->kelas_id)
            ->orderBy('nama_siswa')
            ->get();

        return view('guru.siswa-kelas.index', compact('siswa', 'waliKelas'));
    }
}