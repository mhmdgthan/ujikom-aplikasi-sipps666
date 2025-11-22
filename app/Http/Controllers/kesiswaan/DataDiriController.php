<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Carbon\Carbon;

class DataDiriController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalPelanggaran = Pelanggaran::count();
        $totalPrestasi = Prestasi::count();
        $pelanggaranBulanIni = Pelanggaran::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $prestasiPending = Prestasi::where('status_verifikasi', 'pending')->count();

        return view('kesiswaan.data-diri.index', compact(
            'user', 'totalPelanggaran', 'totalPrestasi', 
            'pelanggaranBulanIni', 'prestasiPending'
        ));
    }
}