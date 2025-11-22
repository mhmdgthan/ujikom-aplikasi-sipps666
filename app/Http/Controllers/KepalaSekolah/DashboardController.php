<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\TahunAjaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalPelanggaran = Pelanggaran::where('status_verifikasi', 'disetujui')->count();
        $totalPrestasi = Prestasi::where('status_verifikasi', 'disetujui')->count();
        $totalKonseling = BimbinganKonseling::count();
        
        $pelanggaranBulanIni = Pelanggaran::where('status_verifikasi', 'disetujui')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
            
        $prestasiBulanIni = Prestasi::where('status_verifikasi', 'disetujui')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $konselingBulanIni = BimbinganKonseling::whereMonth('tanggal_konseling', now()->month)
            ->whereYear('tanggal_konseling', now()->year)
            ->count();
            
        // Data per kelas
        $dataPerKelas = Siswa::with(['kelas', 'pelanggaran' => function($q) {
            $q->where('status_verifikasi', 'disetujui');
        }, 'prestasi' => function($q) {
            $q->where('status_verifikasi', 'disetujui');
        }])->get()->groupBy('kelas.nama_kelas');
        
        return view('kepala-sekolah.dashboard', compact(
            'totalSiswa', 'totalPelanggaran', 'totalPrestasi', 'totalKonseling',
            'pelanggaranBulanIni', 'prestasiBulanIni', 'konselingBulanIni', 'dataPerKelas'
        ));
    }
}