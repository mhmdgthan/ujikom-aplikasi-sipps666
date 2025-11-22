<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanSanksi;
use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelaksanaanSanksiController extends Controller
{
   public function index()
{
    $pelaksanaanSanksi = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa.user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Debug: Cek semua sanksi yang ada
    $allSanksi = Sanksi::count();
    $sanksiDisetujui = Sanksi::where('status', 'disetujui')->count();
    
    // Query sanksi dengan eager loading yang benar
    $sanksi = Sanksi::with([
            'pelanggaran' => function($query) {
                $query->with(['siswa.user', 'siswa.kelas']);
            }
        ])
        ->where('status', 'disetujui')
        ->whereDoesntHave('pelaksanaanSanksi')
        ->get();

    // Jika tidak ada sanksi disetujui, coba ambil semua sanksi
    if ($sanksi->isEmpty()) {
        $sanksi = Sanksi::with([
                'pelanggaran' => function($query) {
                    $query->with(['siswa.user', 'siswa.kelas']);
                }
            ])
            ->whereDoesntHave('pelaksanaanSanksi')
            ->get();
    }

    // Jika masih kosong, ambil semua sanksi untuk debug
    if ($sanksi->isEmpty()) {
        $sanksi = Sanksi::with([
                'pelanggaran' => function($query) {
                    $query->with(['siswa.user', 'siswa.kelas']);
                }
            ])
            ->get();
    }

    // Debug info untuk development
    if (config('app.debug')) {
        session()->flash('debug_info', [
            'total_sanksi' => $allSanksi,
            'sanksi_disetujui' => $sanksiDisetujui,
            'sanksi_tersedia' => $sanksi->count(),
            'query_status' => 'Menampilkan semua sanksi untuk debug'
        ]);
    }

    return view('kesiswaan.pelaksanaan-sanksi.index', compact('pelaksanaanSanksi', 'sanksi'));
}
    public function show(PelaksanaanSanksi $pelaksanaanSanksi)
    {
        $pelaksanaanSanksi->load(['sanksi.pelanggaran.siswa.user']);
        return response()->json($pelaksanaanSanksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sanksi_id' => 'required|exists:sanksi,id',
            'tanggal_pelaksanaan' => 'required|date',
            'catatan' => 'nullable|string',
            'bukti_pelaksanaan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['status'] = 'pending';

        if ($request->hasFile('bukti_pelaksanaan')) {
            $file = $request->file('bukti_pelaksanaan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pelaksanaan-sanksi', $filename, 'public');
            $data['bukti_pelaksanaan'] = $path;
        }

        PelaksanaanSanksi::create($data);

        return redirect()->route('kesiswaan.pelaksanaan-sanksi.index')
            ->with('success', 'Data pelaksanaan sanksi berhasil ditambahkan');
    }

    public function update(Request $request, PelaksanaanSanksi $pelaksanaanSanksi)
    {
        $request->validate([
            'sanksi_id' => 'required|exists:sanksi,id',
            'tanggal_pelaksanaan' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,selesai,dibatalkan',
            'bukti_pelaksanaan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['bukti_pelaksanaan']);

        if ($request->hasFile('bukti_pelaksanaan')) {
            if ($pelaksanaanSanksi->bukti_pelaksanaan && Storage::disk('public')->exists($pelaksanaanSanksi->bukti_pelaksanaan)) {
                Storage::disk('public')->delete($pelaksanaanSanksi->bukti_pelaksanaan);
            }
            $file = $request->file('bukti_pelaksanaan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pelaksanaan-sanksi', $filename, 'public');
            $data['bukti_pelaksanaan'] = $path;
        }

        $pelaksanaanSanksi->update($data);

        return redirect()->route('kesiswaan.pelaksanaan-sanksi.index')
            ->with('success', 'Data pelaksanaan sanksi berhasil diperbarui');
    }

    public function destroy(PelaksanaanSanksi $pelaksanaanSanksi)
    {
        if ($pelaksanaanSanksi->bukti_pelaksanaan && Storage::disk('public')->exists($pelaksanaanSanksi->bukti_pelaksanaan)) {
            Storage::disk('public')->delete($pelaksanaanSanksi->bukti_pelaksanaan);
        }

        $pelaksanaanSanksi->delete();

        return redirect()->route('kesiswaan.pelaksanaan-sanksi.index')
            ->with('success', 'Data pelaksanaan sanksi berhasil dihapus');
    }

    public function selesaikan(PelaksanaanSanksi $pelaksanaanSanksi)
    {
        // Update status pelaksanaan sanksi menjadi selesai
        $pelaksanaanSanksi->update(['status' => 'selesai']);
        
        // Update status sanksi asli menjadi selesai
        $pelaksanaanSanksi->sanksi->update(['status' => 'selesai']);
        
        return response()->json([
            'success' => true,
            'message' => 'Sanksi berhasil diselesaikan'
        ]);
    }
}