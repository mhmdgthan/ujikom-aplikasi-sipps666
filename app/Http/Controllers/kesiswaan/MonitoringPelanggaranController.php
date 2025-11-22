<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\MonitoringPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringPelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MonitoringPelanggaran::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'kepalaSekolah']);
        if ($request->filled('status_monitoring')) {
            $query->where('status_monitoring', $request->status_monitoring);
        }
        if ($request->filled('search')) {
            $query->whereHas('pelanggaran.siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', "%{$request->search}%");
            });
        }

        $monitoring = $query->latest('tanggal_monitoring')->paginate(20);
        $pelanggaranBelumMonitoring = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('status_verifikasi', 'disetujui')
            ->whereDoesntHave('monitoring')
            ->get();

        return view('kepala-sekolah.monitoring-pelanggaran.index', compact('monitoring', 'pelanggaranBelumMonitoring'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'status_monitoring' => 'required|in:Dalam Proses,Selesai,Ditunda',
            'catatan_monitoring' => 'nullable|string',
            'tanggal_monitoring' => 'required|date',
            'tindak_lanjut' => 'nullable|string',
            'hasil' => 'nullable|string',
        ]);

        MonitoringPelanggaran::create([
            'pelanggaran_id' => $request->pelanggaran_id,
            'kepala_sekolah_id' => Auth::id(),
            'status_monitoring' => $request->status_monitoring,
            'catatan_monitoring' => $request->catatan_monitoring,
            'tanggal_monitoring' => $request->tanggal_monitoring,
            'tindak_lanjut' => $request->tindak_lanjut,
            'hasil' => $request->hasil,
        ]);

        return redirect()->route('kepala-sekolah.monitoring-pelanggaran.index')
            ->with('success', 'Data monitoring pelanggaran berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $monitoring = MonitoringPelanggaran::findOrFail($id);

        $request->validate([
            'status_monitoring' => 'required|in:Dalam Proses,Selesai,Ditunda',
            'catatan_monitoring' => 'nullable|string',
            'tanggal_monitoring' => 'required|date',
            'tindak_lanjut' => 'nullable|string',
            'hasil' => 'nullable|string',
        ]);

        $monitoring->update($request->only([
            'status_monitoring',
            'catatan_monitoring',
            'tanggal_monitoring',
            'tindak_lanjut',
            'hasil'
        ]));

        return redirect()->route('kepala-sekolah.monitoring-pelanggaran.index')
            ->with('success', 'Data monitoring pelanggaran berhasil diupdate!');
    }

    public function destroy($id)
    {
        $monitoring = MonitoringPelanggaran::findOrFail($id);
        $monitoring->delete();

        return redirect()->route('kepala-sekolah.monitoring-pelanggaran.index')
            ->with('success', 'Data monitoring pelanggaran berhasil dihapus!');
    }
}