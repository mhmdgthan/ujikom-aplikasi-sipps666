<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class DataDiriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        
        return view('kepala-sekolah.data-diri.index', compact(
            'user', 'totalSiswa', 'totalGuru', 'totalKelas'
        ));
    }
    
    public function update()
    {
        $user = Auth::user();
        
        $validated = request()->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'spesialisasi' => 'nullable|string|max:255'
        ]);
        
        $user->update($validated);
        
        return redirect()->route('kepala-sekolah.data-diri.index')
            ->with('success', 'Data diri berhasil diperbarui');
    }
}