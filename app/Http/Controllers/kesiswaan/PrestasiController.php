<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\JenisPrestasi;
use App\Models\TahunAjaran;
use App\Models\Guru;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::with([
            'siswa.user',
            'siswa.kelas',
            'jenisPrestasi',
            'tahunAjaran'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $siswa = Siswa::with(['user', 'kelas'])->get();
        $jenisPrestasi = JenisPrestasi::all();
        $tahunAjaran = TahunAjaran::all();
        $guru = Guru::all();

        return view('kesiswaan.prestasi.index', compact('prestasi', 'siswa', 'jenisPrestasi', 'tahunAjaran', 'guru'));
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load([
            'siswa.user',
            'siswa.kelas',
            'jenisPrestasi',
            'tahunAjaran'
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
            'keterangan' => 'required|string',
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($request->jenis_prestasi_id);

        $data = $request->only(['siswa_id', 'jenis_prestasi_id', 'tahun_ajaran_id', 'keterangan']);
        $data['poin'] = $jenisPrestasi->poin;
        $data['status_verifikasi'] = 'pending';

        Prestasi::create($data);

        return redirect()->route('kesiswaan.prestasi.index')
            ->with('success', 'Data prestasi berhasil ditambahkan');
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        if (strtolower($prestasi->status_verifikasi) != 'pending') {
            return redirect()->back()
                ->with('error', 'Prestasi yang sudah diverifikasi tidak dapat diubah');
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'keterangan' => 'required|string',
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($request->jenis_prestasi_id);

        $data = $request->only(['siswa_id', 'jenis_prestasi_id', 'tahun_ajaran_id', 'keterangan']);
        $data['poin'] = $jenisPrestasi->poin;

        $prestasi->update($data);

        return redirect()->route('kesiswaan.prestasi.index')
            ->with('success', 'Data prestasi berhasil diperbarui');
    }

    public function destroy(Prestasi $prestasi)
    {
        if (strtolower($prestasi->status_verifikasi) != 'pending') {
            return redirect()->back()
                ->with('error', 'Prestasi yang sudah diverifikasi tidak dapat dihapus');
        }

        $prestasi->delete();

        return redirect()->route('kesiswaan.prestasi.index')
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
        ]);

        return redirect()->route('kesiswaan.prestasi.index')
            ->with('success', 'Prestasi berhasil diverifikasi');
    }
}