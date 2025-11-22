<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\OrangTua;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get children data based on orang tua relationship
        $orangTuaRecords = OrangTua::where('user_id', $user->id)->pluck('siswa_id');
        $anak = Siswa::whereIn('id', $orangTuaRecords)
            ->with(['kelas.jurusan', 'pelanggaran' => function($q) {
                $q->where('status_verifikasi', 'disetujui');
            }, 'prestasi' => function($q) {
                $q->where('status_verifikasi', 'disetujui');
            }])
            ->get();
        
        $totalAnak = $anak->count();
        $totalPelanggaran = $anak->sum(function($child) {
            return $child->pelanggaran->count();
        });
        $totalPrestasi = $anak->sum(function($child) {
            return $child->prestasi->count();
        });
        $totalPoinPelanggaran = $anak->sum(function($child) {
            return $child->pelanggaran->sum('poin');
        });
        $totalPoinPrestasi = $anak->sum(function($child) {
            return $child->prestasi->sum('poin');
        });
        
        return view('orang-tua.dashboard', compact(
            'user', 'anak', 'totalAnak', 'totalPelanggaran', 'totalPrestasi',
            'totalPoinPelanggaran', 'totalPoinPrestasi'
        ));
    }
}