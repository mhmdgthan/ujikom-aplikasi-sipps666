<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggaran = Pelanggaran::with([
            'siswa.user',
            'siswa.kelas',
            'jenisPelanggaran',
            'tahunAjaran',
            'guruPencatat',
            'guruVerifikator'
        ])
        ->where('status_verifikasi', 'disetujui')
        ->orderBy('tanggal', 'desc')
        ->paginate(10);

        $siswa = Siswa::with(['user', 'kelas'])->get();
        $jenisPelanggaran = JenisPelanggaran::with('kategoriPelanggaran')->get();
        $tahunAjaran = TahunAjaran::all();
        $guru = Guru::all();

        return view('admin.pelanggaran.index', compact('pelanggaran', 'siswa', 'jenisPelanggaran', 'tahunAjaran', 'guru'));
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load([
            'siswa.user',
            'siswa.kelas',
            'jenisPelanggaran.kategoriPelanggaran',
            'tahunAjaran',
            'guruPencatat.user',
            'guruVerifikator.user'
        ]);
        
        // Convert to array and add additional fields
        $response = $pelanggaran->toArray();
        
        // Add guru pencatat detail
        if ($pelanggaran->guruPencatat) {
            $guruPencatat = $pelanggaran->guruPencatat;
            $namaPencatat = $guruPencatat->nama_guru ?? ($guruPencatat->user ? $guruPencatat->user->nama_lengkap : null);
            $response['guru_pencatat_detail'] = [
                'nama_guru' => $namaPencatat ?? 'Tidak diketahui'
            ];
            $response['guru_pencatat_nama'] = $namaPencatat ?? 'Tidak diketahui';
        } else {
            $response['guru_pencatat_detail'] = [
                'nama_guru' => 'Tidak diketahui'
            ];
            $response['guru_pencatat_nama'] = 'Tidak diketahui';
        }
        
        // Add verifikator detail
        if ($pelanggaran->guruVerifikator) {
            $guruVerifikator = $pelanggaran->guruVerifikator;
            $namaVerifikator = $guruVerifikator->nama_guru ?? ($guruVerifikator->user ? $guruVerifikator->user->nama_lengkap : null);
            $response['guru_verifikator_detail'] = [
                'nama_guru' => $namaVerifikator ?? 'Belum diverifikasi'
            ];
            $response['guru_verifikator_nama'] = $namaVerifikator ?? 'Belum diverifikasi';
        } else {
            $response['guru_verifikator_detail'] = [
                'nama_guru' => 'Belum diverifikasi'
            ];
            $response['guru_verifikator_nama'] = 'Belum diverifikasi';
        }
        
        // Add kategori and poin info
        if ($pelanggaran->jenisPelanggaran) {
            $kategori = $pelanggaran->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'Tidak diketahui';
            $response['kategori_poin'] = $kategori . ' (' . $pelanggaran->poin . ' poin)';
        } else {
            $response['kategori_poin'] = 'Tidak diketahui';
        }
        
        return response()->json($response);
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
            'guru_pencatat' => 'required|exists:guru,id',
            'guru_verifikator' => 'nullable|exists:guru,id',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

        $data = $request->all();
        $data['guru_pencatat'] = $request->guru_pencatat;
        $data['poin'] = $jenisPelanggaran->poin;
        $data['status_verifikasi'] = 'pending';
        
        // Format tanggal
        if ($request->has('tanggal') && $request->tanggal) {
            $data['tanggal'] = Carbon::parse($request->tanggal)->format('Y-m-d');
        }

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pelanggaran', $filename, 'public');
            $data['bukti_foto'] = $path;
        }

        Pelanggaran::create($data);

        // Send notification to admin and kesiswaan
        session()->flash('notification', [
            'type' => 'success',
            'title' => 'Pelanggaran Baru!',
            'message' => 'Data pelanggaran siswa berhasil ditambahkan'
        ]);

        return redirect()->route('admin.pelanggaran.index')
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
            'guru_pencatat' => 'required|exists:guru,id',
            'guru_verifikator' => 'nullable|exists:guru,id',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

        $data = $request->all();
        $data['guru_pencatat'] = $request->guru_pencatat;
        $data['poin'] = $jenisPelanggaran->poin;
        
        // Format tanggal
        if ($request->has('tanggal') && $request->tanggal) {
            $data['tanggal'] = Carbon::parse($request->tanggal)->format('Y-m-d');
        }

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

        return redirect()->route('admin.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil diperbarui');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        if ($pelanggaran->bukti_foto && Storage::disk('public')->exists($pelanggaran->bukti_foto)) {
            Storage::disk('public')->delete($pelanggaran->bukti_foto);
        }

        // Delete related verifikasi_data
        \App\Models\VerifikasiData::where('tabel_terkait', 'pelanggaran')
            ->where('id_terkait', $pelanggaran->id)
            ->delete();

        $pelanggaran->delete();

        return redirect()->route('admin.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus');
    }

    public function verifikasi(Request $request, $id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        // Get current user's guru ID
        $guruId = null;
        if (auth()->user() && auth()->user()->guru) {
            $guruId = auth()->user()->guru->id;
        }

        $pelanggaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'guru_verifikator' => $guruId,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        return redirect()->route('admin.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil diverifikasi');
    }
}