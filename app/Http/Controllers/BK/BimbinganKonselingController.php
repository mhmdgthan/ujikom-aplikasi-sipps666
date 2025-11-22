<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganKonselingController extends Controller
{
  public function index()
{
    // Optimasi query dengan eager loading yang lebih dalam
    $konseling = BimbinganKonseling::with([
        'siswa.user', 
        'siswa.kelas',
        'tahunAjaran', 
        'konselor'
    ])->orderBy('tanggal_konseling', 'desc')
      ->paginate(10);

    $siswa = Siswa::with(['user', 'kelas'])->get();
    $tahunAjaran = TahunAjaran::all();

    // Debug untuk memeriksa data
    // dd($konseling->first()); // Uncomment untuk debugging

    return view('bk.konseling.index', compact('konseling', 'siswa', 'tahunAjaran'));
}

public function show(BimbinganKonseling $konseling)
{
    // Load relasi dengan lebih eksplisit
    $konseling->load([
        'siswa.user',
        'siswa.kelas', 
        'tahunAjaran',
        'konselor'
    ]);
    
    return response()->json($konseling);
}

    public function create(Request $request)
    {
        $siswaId = $request->get('siswa_id');
        return redirect()->route('bk.konseling.index', ['siswa_id' => $siswaId]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jenis_layanan' => 'required|string|max:100',
            'topik' => 'required|string|max:255',
            'tanggal_konseling' => 'required|date',
            'tindakan_solusi' => 'nullable|string',
            'status' => 'nullable|string|max:50',
            'tanggal_tindak_lanjut' => 'nullable|date',
            'hasil_evaluasi' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        BimbinganKonseling::create($data);

        return redirect()->route('bk.konseling.index')
            ->with('success', 'Data konseling berhasil ditambahkan');
    }

    public function update(Request $request, BimbinganKonseling $konseling)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jenis_layanan' => 'required|string|max:100',
            'topik' => 'required|string|max:255',
            'tanggal_konseling' => 'required|date',
            'tindakan_solusi' => 'nullable|string',
            'status' => 'nullable|string|max:50',
            'tanggal_tindak_lanjut' => 'nullable|date',
            'hasil_evaluasi' => 'nullable|string|max:255',
        ]);

        $konseling->update($request->all());

        return redirect()->route('bk.konseling.index')
            ->with('success', 'Data konseling berhasil diperbarui');
    }

    public function destroy(BimbinganKonseling $konseling)
    {
        $konseling->delete();

        return redirect()->route('bk.konseling.index')
            ->with('success', 'Data konseling berhasil dihapus');
    }

    public function complete($id)
    {
        $konseling = BimbinganKonseling::findOrFail($id);
        $konseling->update(['status' => 'Selesai']);

        return redirect()->route('bk.konseling.index')
            ->with('success', 'Konseling berhasil diselesaikan');
    }

    public function siswaPerluKonseling()
    {
        // Siswa yang memiliki pelanggaran dan belum dikonseling
        $siswaPerluKonseling = Siswa::with(['user', 'kelas', 'pelanggaran.jenisPelanggaran'])
            ->whereHas('pelanggaran')
            ->whereDoesntHave('bimbinganKonseling')
            ->get()
            ->map(function($siswa) {
                $siswa->total_pelanggaran = $siswa->pelanggaran->count();
                $siswa->pelanggaran_terbaru = $siswa->pelanggaran->sortByDesc('tanggal_pelanggaran')->first();
                return $siswa;
            })
            ->sortByDesc('total_pelanggaran');

        return view('bk.siswa-perlu-konseling.index', compact('siswaPerluKonseling'));
    }
}