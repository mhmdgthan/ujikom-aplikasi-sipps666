<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use Illuminate\Support\Facades\Auth;

class DataDiriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalKonseling = BimbinganKonseling::where('user_id', $user->id)->count();
        $konselingBulanIni = BimbinganKonseling::where('user_id', $user->id)
            ->whereMonth('tanggal_konseling', now()->month)
            ->whereYear('tanggal_konseling', now()->year)
            ->count();
        $konselingSelesai = BimbinganKonseling::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->count();
        
        return view('bk.data-diri.index', compact(
            'user', 'totalKonseling', 'konselingBulanIni', 'konselingSelesai'
        ));
    }
}