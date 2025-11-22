<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\Guru;
use App\Services\SanksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggaran = Pelanggaran::with([
            'siswa.user',
            'siswa.kelas.jurusan',
            'jenisPelanggaran.kategoriPelanggaran',
            'tahunAjaran',
            'guruPencatat',
            'guruVerifikator'
        ])
        ->orderBy('tanggal', 'desc')
        ->paginate(10);

        $siswa = Siswa::with('user', 'kelas')->get();
        $jenisPelanggaran = JenisPelanggaran::with('kategoriPelanggaran')->get();
        $tahunAjaran = TahunAjaran::all();

        return view('kesiswaan.pelanggaran.index', compact('pelanggaran', 'siswa', 'jenisPelanggaran', 'tahunAjaran'));
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load([
            'siswa.user',
            'siswa.kelas.jurusan',
            'jenisPelanggaran',
            'tahunAjaran',
            'guruPencatat',
            'guruVerifikator'
        ]);

        return response()->json([
            'siswa' => [
                'user' => [
                    'nama_lengkap' => $pelanggaran->siswa->user->nama_lengkap ?? 'Nama tidak tersedia'
                ],
                'kelas' => [
                    'nama_kelas' => $pelanggaran->siswa->kelas->nama_kelas ?? 'Kelas tidak tersedia'
                ]
            ],
            'jenis_pelanggaran' => [
                'nama_pelanggaran' => $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'Jenis tidak tersedia',
                'kategori' => $pelanggaran->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'Ringan'
            ],
            'tahun_ajaran' => [
                'tahun_ajaran' => $pelanggaran->tahunAjaran->tahun_ajaran ?? 'Tidak tersedia'
            ],
            'guru_pencatat' => [
                'nama_guru' => $pelanggaran->guruPencatat->nama_guru ?? 'Tidak diketahui'
            ],
            'guru_verifikator' => [
                'nama_guru' => $pelanggaran->guruVerifikator->nama_guru ?? 'Belum diverifikasi'
            ],
            'poin' => $pelanggaran->poin,
            'tanggal' => $pelanggaran->tanggal,
            'status_verifikasi' => $pelanggaran->status_verifikasi,
            'keterangan' => $pelanggaran->keterangan,
            'bukti_foto' => $pelanggaran->bukti_foto,
            'catatan_verifikasi' => $pelanggaran->catatan_verifikasi
        ]);
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        return response()->json($pelanggaran);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

        // Otomatis set guru pencatat sebagai user kesiswaan yang sedang login
        $userKesiswaan = Auth::user();
        $guruKesiswaan = Guru::where('user_id', $userKesiswaan->id)->first();

        // Jika kesiswaan tidak terdaftar sebagai guru, gunakan guru pertama atau buat entry khusus
        if (!$guruKesiswaan) {
            // Cari guru dengan level kesiswaan atau ambil guru pertama
            $guruKesiswaan = Guru::whereHas('user', function($query) {
                $query->where('level', 'kesiswaan');
            })->first() ?? Guru::first();
            
            if (!$guruKesiswaan) {
                return redirect()->back()
                    ->with('error', 'Tidak ada data guru yang tersedia');
            }
        }

        $data = $request->all();
        $data['guru_pencatat'] = $guruKesiswaan->user_id; // Otomatis set guru pencatat
        $data['poin'] = $jenisPelanggaran->poin;
        $data['status_verifikasi'] = 'disetujui'; // Kesiswaan langsung disetujui
        $data['guru_verifikator'] = $guruKesiswaan->user_id; // Kesiswaan sebagai verifikator

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pelanggaran', $filename, 'public');
            $data['bukti_foto'] = $path;
        }

        Pelanggaran::create($data);

        return redirect()->route('kesiswaan.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil ditambahkan');
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        
        $data = $request->all();
        $data['poin'] = $jenisPelanggaran->poin;

        if ($request->hasFile('bukti_foto')) {
            if ($pelanggaran->bukti_foto && Storage::disk('public')->exists($pelanggaran->bukti_foto)) {
                Storage::disk('public')->delete($pelanggaran->bukti_foto);
            }
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pelanggaran', $filename, 'public');
            $data['bukti_foto'] = $path;
        }

        $pelanggaran->update($data);

        return redirect()->route('kesiswaan.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil diperbarui');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        if ($pelanggaran->bukti_foto && Storage::disk('public')->exists($pelanggaran->bukti_foto)) {
            Storage::disk('public')->delete($pelanggaran->bukti_foto);
        }

        $pelanggaran->delete();

        return redirect()->route('kesiswaan.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus');
    }

    public function verifikasi(Request $request, $id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $userKesiswaan = Auth::user();
        $guruKesiswaan = Guru::where('user_id', $userKesiswaan->id)->first();

        $pelanggaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'guru_verifikator' => $guruKesiswaan->user_id ?? null,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        // Auto assign sanksi if approved
        if ($request->status_verifikasi === 'disetujui') {
            SanksiService::assignSanksiOtomatis($pelanggaran->siswa_id, $pelanggaran->tahun_ajaran_id);
        }

        return redirect()->route('kesiswaan.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil diverifikasi');
    }
}