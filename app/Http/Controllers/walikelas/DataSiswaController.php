<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Illuminate\Support\Facades\Auth;

class DataSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil kelas yang diampu sebagai wali kelas
        $waliKelas = WaliKelas::where('guru_id', $user->id)
            ->whereNull('tanggal_selesai')
            ->with(['kelas.jurusan', 'tahunAjaran'])
            ->first();
            
        if (!$waliKelas) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas yang diampu.');
        }
        
        // Ambil siswa di kelas tersebut dengan statistik
        $siswa = Siswa::where('kelas_id', $waliKelas->kelas_id)
            ->with(['kelas', 'pelanggaran' => function($q) {
                $q->where('status_verifikasi', 'disetujui');
            }, 'prestasi' => function($q) {
                $q->where('status_verifikasi', 'disetujui');
            }])
            ->paginate(10);
            
        // Statistik kelas
        $totalSiswa = $siswa->count();
        $totalPelanggaran = Pelanggaran::whereIn('siswa_id', $siswa->pluck('id'))
            ->where('status_verifikasi', 'disetujui')
            ->count();
        $totalPrestasi = Prestasi::whereIn('siswa_id', $siswa->pluck('id'))
            ->where('status_verifikasi', 'disetujui')
            ->count();
            
        return view('wali-kelas.data-siswa.index', compact(
            'siswa', 'waliKelas', 'totalSiswa', 'totalPelanggaran', 'totalPrestasi'
        ));
    }
}