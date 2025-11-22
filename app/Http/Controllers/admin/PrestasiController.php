<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\JenisPrestasi;
use App\Models\TahunAjaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::with([
            'siswa.user',
            'siswa.kelas',
            'jenisPrestasi',
            'tahunAjaran',
            'guruPencatat'
        ])
        ->orderBy('tanggal_prestasi', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

        $siswa = Siswa::with(['user', 'kelas'])->get();
        $jenisPrestasi = JenisPrestasi::all();
        $tahunAjaran = TahunAjaran::all();
        $guru = Guru::all();

        return view('admin.prestasi.index', compact('prestasi', 'siswa', 'jenisPrestasi', 'tahunAjaran', 'guru'));
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load([
            'siswa.user',
            'siswa.kelas',
            'jenisPrestasi',
            'tahunAjaran',
            'guruPencatat'
        ]);
        return response()->json($prestasi);
    }

    public function edit(Prestasi $prestasi)
    {
        return response()->json($prestasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal_prestasi' => 'required|date',
            'keterangan' => 'required|string',
            'guru_pencatat' => 'required|exists:guru,id',
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($request->jenis_prestasi_id);

        $data = $request->all();
        $data['poin'] = $jenisPrestasi->poin;
        $data['status_verifikasi'] = 'pending';
        
        // Format tanggal jika perlu
        if ($request->has('tanggal_prestasi') && $request->tanggal_prestasi) {
            $data['tanggal_prestasi'] = Carbon::parse($request->tanggal_prestasi)->format('Y-m-d');
        }

        Prestasi::create($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Data prestasi berhasil ditambahkan');
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal_prestasi' => 'required|date',
            'keterangan' => 'required|string',
            'guru_pencatat' => 'required|exists:guru,id',
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($request->jenis_prestasi_id);

        $data = $request->all();
        $data['poin'] = $jenisPrestasi->poin;
        
        // Format tanggal jika perlu
        if ($request->has('tanggal_prestasi') && $request->tanggal_prestasi) {
            $data['tanggal_prestasi'] = Carbon::parse($request->tanggal_prestasi)->format('Y-m-d');
        }

        $prestasi->update($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Data prestasi berhasil diperbarui');
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Data prestasi berhasil dihapus');
    }

    public function verifikasi(Request $request, $id)
    {
        $prestasi = Prestasi::findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
        ]);

        $prestasi->update([
            'status_verifikasi' => $request->status_verifikasi,
            // Jika ingin menambahkan tanggal verifikasi
            // 'tanggal_verifikasi' => now(),
        ]);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diverifikasi');
    }
}