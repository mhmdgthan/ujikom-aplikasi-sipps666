<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    /**
     * Display a listing of wali kelas.
     */
   // File: app/Http/Controllers/Admin/WaliKelasController.php

public function index()
    {
        $waliKelas = WaliKelas::with(['guru', 'kelas', 'tahunAjaran'])->latest()->paginate(10)->appends(request()->query());

        // Ambil guru yang sudah punya user_id dan user dengan level guru/wali_kelas
        $guru = Guru::with('user')
            ->whereNotNull('user_id')
            ->whereHas('user', function($q) {
                $q->whereIn('level', ['guru', 'wali_kelas']);
            })
            ->orderBy('nama_guru')
            ->get();
            
        $kelas = Kelas::with('jurusan')->orderBy('tingkat_kelas')->get();
        
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();

        return view('admin.wali-kelas.index', compact('waliKelas', 'guru', 'kelas', 'tahunAjaran'));
    }
    /**
     * Show the specified wali kelas.
     */
    public function show($id)
    {
        $waliKelas = WaliKelas::with(['guru', 'kelas.jurusan', 'tahunAjaran'])->findOrFail($id);
        return response()->json($waliKelas);
    }
    /**
     * Store a newly created wali kelas.
     */
  // File: app/Http/Controllers/Admin/WaliKelasController.php

// File: app/Http/Controllers/Admin/WaliKelasController.php

// File: app/Http/Controllers/Admin/WaliKelasController.php

// File: app/Http/Controllers/Admin/WaliKelasController.php

public function store(Request $request)
{
    $request->validate([
        'guru_id' => 'required|exists:users,id',
        'kelas_id' => 'required|exists:kelas,id',
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
        'catatan' => 'nullable|string',
    ]);
    
    // Cek duplikasi kelas di tahun ajaran yang sama
    $existingKelas = WaliKelas::where('kelas_id', $request->kelas_id)
        ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
        ->whereNull('tanggal_selesai')
        ->first();
        
    if ($existingKelas) {
        return redirect()->back()
            ->with('error', 'Kelas ini sudah memiliki wali kelas aktif di tahun ajaran yang sama!')
            ->withInput();
    }
    
    // Cek duplikasi guru di tahun ajaran yang sama
    $existingGuru = WaliKelas::where('guru_id', $request->guru_id)
        ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
        ->whereNull('tanggal_selesai')
        ->first();
        
    if ($existingGuru) {
        return redirect()->back()
            ->with('error', 'Guru ini sudah menjadi wali kelas di tahun ajaran yang sama!')
            ->withInput();
    }
    
    // Create wali kelas
    WaliKelas::create($request->all());
    
    // Update user level to wali_kelas
    \App\Models\User::where('id', $request->guru_id)->update(['level' => 'wali_kelas']);

    return redirect()->route('admin.wali-kelas.index')
        ->with('success', 'Wali kelas berhasil ditambahkan!');
}
// File: app/Http/Controllers/Admin/WaliKelasController.php

public function update(Request $request, $id)
{
    $waliKelas = WaliKelas::findOrFail($id);

    $request->validate([
        'guru_id' => 'required|exists:users,id',
        'kelas_id' => 'required|exists:kelas,id',
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
        'catatan' => 'nullable|string',
    ]);

    // Cek duplikasi kelas di tahun ajaran yang sama (kecuali data yang sedang diedit)
    $existingKelas = WaliKelas::where('kelas_id', $request->kelas_id)
        ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
        ->where('id', '!=', $id)
        ->whereNull('tanggal_selesai')
        ->first();
        
    if ($existingKelas) {
        return redirect()->back()
            ->with('error', 'Kelas ini sudah memiliki wali kelas aktif di tahun ajaran yang sama!')
            ->withInput();
    }
    
    // Cek duplikasi guru di tahun ajaran yang sama (kecuali data yang sedang diedit)
    $existingGuru = WaliKelas::where('guru_id', $request->guru_id)
        ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
        ->where('id', '!=', $id)
        ->whereNull('tanggal_selesai')
        ->first();
        
    if ($existingGuru) {
        return redirect()->back()
            ->with('error', 'Guru ini sudah menjadi wali kelas di tahun ajaran yang sama!')
            ->withInput();
    }

    // Reset old user level to guru if different
    if ($waliKelas->guru_id != $request->guru_id) {
        \App\Models\User::where('id', $waliKelas->guru_id)->update(['level' => 'guru']);
    }
    
    // Update wali kelas
    $waliKelas->update($request->all());
    
    // Update new user level to wali_kelas
    \App\Models\User::where('id', $request->guru_id)->update(['level' => 'wali_kelas']);

    return redirect()->route('admin.wali-kelas.index')
        ->with('success', 'Wali kelas berhasil diupdate!');
}

    /**
     * Remove the specified wali kelas.
     */
    public function destroy($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        
        // Reset user level back to guru
        \App\Models\User::where('id', $waliKelas->guru_id)->update(['level' => 'guru']);
        
        $waliKelas->delete();

        return redirect()->route('admin.wali-kelas.index')
            ->with('success', 'Wali kelas berhasil dihapus!');
    }

    /**
     * Mark wali kelas as finished
     */
    public function selesai($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        
        $waliKelas->update([
            'tanggal_selesai' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Status wali kelas berhasil diselesaikan!');
    }
}