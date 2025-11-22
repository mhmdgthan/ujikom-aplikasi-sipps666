<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tingkat_kelas', 'like', "%{$search}%")
                  ->orWhereHas('jurusan', function($q) use ($search) {
                      $q->where('nama_jurusan', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('tingkat')) {
            $query->where('tingkat_kelas', $request->tingkat);
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan_id', $request->jurusan);
        }
        
        $kelas = $query->with(['jurusan'])->latest()->paginate(10)->appends(request()->query());
        $jurusan = Jurusan::all();
        $guru = Guru::with('user')->get();

        return view('admin.kelas.index', compact('kelas', 'jurusan', 'guru'));
    }

    public function show($id)
    {
        $kelas = Kelas::with(['jurusan', 'siswa'])->findOrFail($id);
        
        $kelas->siswa_count = $kelas->siswa->count();
        
        return response()->json($kelas);
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        $guru = Guru::with('user')->get();
        
        return view('admin.kelas.partials.form', [
            'kelas' => new Kelas(),
            'method' => 'POST',
            'url' => route('admin.kelas.store'),
            'title' => 'Tambah Kelas',
            'jurusan' => $jurusan,
            'guru' => $guru
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat_kelas' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'kapasitas' => 'required|integer|min:1',
        ]);

        // Cek duplikasi tingkat + jurusan
        $existing = Kelas::where('tingkat_kelas', $request->tingkat_kelas)
            ->where('jurusan_id', $request->jurusan_id)
            ->first();
            
        if ($existing) {
            return redirect()->back()
                ->with('error', 'Kelas dengan tingkat dan jurusan yang sama sudah ada!')
                ->withInput();
        }

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $jurusan = Jurusan::all();
        $guru = Guru::with('user')->get();
        
        return view('admin.kelas.partials.form', [
            'kelas' => $kela,
            'method' => 'PUT',
            'url' => route('admin.kelas.update', $kela->id),
            'title' => 'Edit Kelas',
            'jurusan' => $jurusan,
            'guru' => $guru
        ]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'tingkat_kelas' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'kapasitas' => 'required|integer|min:1',
        ]);

        // Cek duplikasi tingkat + jurusan (kecuali data yang sedang diedit)
        $existing = Kelas::where('tingkat_kelas', $request->tingkat_kelas)
            ->where('jurusan_id', $request->jurusan_id)
            ->where('id', '!=', $kela->id)
            ->first();
            
        if ($existing) {
            return redirect()->back()
                ->with('error', 'Kelas dengan tingkat dan jurusan yang sama sudah ada!')
                ->withInput();
        }

        $kela->update($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}