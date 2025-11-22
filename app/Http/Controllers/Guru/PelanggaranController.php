<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\Guru;
use App\Models\VerifikasiData;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; 

class PelanggaranController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $guru = Guru::where('user_id', $user->id)->first();
    
    if (!$guru) {
        return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
    }

    // Guru only sees pelanggaran they input through guru interface
    $pelanggaran = Pelanggaran::with([
        'siswa.user',
        'siswa.kelas',
        'jenisPelanggaran',
        'tahunAjaran'
    ])
    ->where('guru_pencatat', $guru->id) // ✅ Gunakan guru->id
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    $siswa = Siswa::with(['user', 'kelas'])->get();
    $jenisPelanggaran = JenisPelanggaran::all();
    $tahunAjaran = TahunAjaran::all();
    $guru = Guru::all();

    return view('guru.pelanggaran.index', compact('pelanggaran', 'siswa', 'jenisPelanggaran', 'tahunAjaran', 'guru'));
}
    public function show(Pelanggaran $pelanggaran)
    {
        $user = auth()->user();
        $guru = Guru::where('user_id', $user->id)->first();
        
        if ($pelanggaran->guru_pencatat != $guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pelanggaran->load([
            'siswa.user',
            'siswa.kelas',
            'jenisPelanggaran',
            'tahunAjaran'
        ]);
        return response()->json($pelanggaran);
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $user = auth()->user();
        $guru = Guru::where('user_id', $user->id)->first();
        
        if ($pelanggaran->guru_pencatat != $guru->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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

    $user = Auth::user();
    $guru = Guru::where('user_id', $user->id)->first();
    
    if (!$guru) {
        return redirect()->back()->with('error', 'Data guru tidak ditemukan');
    }

    $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

    $data = $request->all();
    $data['poin'] = $jenisPelanggaran->poin;
    $data['status_verifikasi'] = 'pending';
    $data['guru_pencatat'] = $guru->id;

    if ($request->hasFile('bukti_foto')) {
        $file = $request->file('bukti_foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pelanggaran', $filename, 'public');
        $data['bukti_foto'] = $path;
    }

    $pelanggaran = Pelanggaran::create($data);

    // Create verification entry
    VerifikasiData::create([
        'tabel_terkait' => 'pelanggaran',
        'id_terkait' => $pelanggaran->id,
        'status' => 'pending'
    ]);

    // Send notifications - disabled
    // NotificationService::notifyNewPelanggaran($pelanggaran);

    return redirect()->route('guru.pelanggaran.index')
        ->with('success', 'Data pelanggaran berhasil ditambahkan dan menunggu verifikasi');
}
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $user = auth()->user();
        $guru = Guru::where('user_id', $user->id)->first();
        
        if ($pelanggaran->guru_pencatat != $guru->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        if (strtolower($pelanggaran->status_verifikasi) != 'pending') {
            return redirect()->back()
                ->with('error', 'Pelanggaran yang sudah diverifikasi tidak dapat diubah');
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'guru_pencatat' => 'required|exists:guru,id',
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

        return redirect()->route('guru.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil diperbarui');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $user = auth()->user();
        $guru = Guru::where('user_id', $user->id)->first();
        
        if ($pelanggaran->guru_pencatat != $guru->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        if (strtolower($pelanggaran->status_verifikasi) != 'pending') {
            return redirect()->back()
                ->with('error', 'Pelanggaran yang sudah diverifikasi tidak dapat dihapus');
        }

        if ($pelanggaran->bukti_foto && Storage::disk('public')->exists($pelanggaran->bukti_foto)) {
            Storage::disk('public')->delete($pelanggaran->bukti_foto);
        }

        // Delete related verifikasi_data
        VerifikasiData::where('tabel_terkait', 'pelanggaran')
            ->where('id_terkait', $pelanggaran->id)
            ->delete();

        $pelanggaran->delete();

        return redirect()->route('guru.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus');
    }
}