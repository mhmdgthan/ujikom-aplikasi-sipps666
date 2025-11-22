<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Prestasi;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelas.jurusan', 'pelanggaran' => function($q) {
            $q->where('status_verifikasi', 'disetujui');
        }, 'prestasi' => function($q) {
            $q->where('status_verifikasi', 'disetujui');
        }])->get();
        
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalPelanggaran = Pelanggaran::where('status_verifikasi', 'disetujui')->count();
        $totalPrestasi = Prestasi::where('status_verifikasi', 'disetujui')->count();
        
        return view('kepala-sekolah.data-siswa.index', compact(
            'siswa', 'totalSiswa', 'totalKelas', 'totalPelanggaran', 'totalPrestasi'
        ));
    }
    
    public function show($id)
    {
        $siswa = Siswa::with(['kelas.jurusan', 'pelanggaran', 'prestasi'])->findOrFail($id);
        
        return view('kepala-sekolah.data-siswa.show', compact('siswa'));
    }
}