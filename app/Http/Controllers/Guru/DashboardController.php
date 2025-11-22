<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\WaliKelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru->id ?? null;
        
        if (!$guruId) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }

        $totalPelanggaran = Pelanggaran::where('guru_pencatat', $guruId)->count();
        $pelanggaranPending = Pelanggaran::where('guru_pencatat', $guruId)
            ->where('status_verifikasi', 'pending')->count();
        $pelanggaranDisetujui = Pelanggaran::where('guru_pencatat', $guruId)
            ->where('status_verifikasi', 'disetujui')->count();
        $pelanggaranBulanIni = Pelanggaran::where('guru_pencatat', $guruId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $recentPelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('guru_pencatat', $guruId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Check if guru is also wali kelas
        $waliKelas = WaliKelas::with(['kelas', 'tahunAjaran'])
            ->where('guru_id', $guruId)
            ->whereNull('tanggal_selesai')
            ->first();

        return view('guru.dashboard', compact(
            'totalPelanggaran', 'pelanggaranPending', 'pelanggaranDisetujui', 
            'pelanggaranBulanIni', 'recentPelanggaran', 'waliKelas'
        ));
    }
}