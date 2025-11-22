<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\PelaksanaanSanksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa()->with(['kelas.jurusan'])->first();
        
        // Get pelanggaran and prestasi data
        $pelanggaran = Pelanggaran::with('jenisPelanggaran')
            ->where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'disetujui')
            ->latest()
            ->paginate(10, ['*'], 'pelanggaran_page');
            
        $prestasi = Prestasi::with('jenisPrestasi')
            ->where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'disetujui')
            ->latest()
            ->paginate(10, ['*'], 'prestasi_page');
            
        $konseling = BimbinganKonseling::with('konselor')
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(10, ['*'], 'konseling_page');
            
        $sanksi = PelaksanaanSanksi::with(['sanksi.pelanggaran'])
            ->whereHas('sanksi.pelanggaran', function($query) use ($siswa) {
                $query->where('siswa_id', $siswa->id);
            })
            ->latest()
            ->paginate(10, ['*'], 'sanksi_page');
        
        // Cek jika data siswa tidak ditemukan (opsional tapi disarankan)
        if (!$siswa) {
            // Handle jika user login tidak memiliki data siswa terkait
            return redirect('/')->with('error', 'Data siswa tidak ditemukan.');
        }

        $totalPelanggaran = $pelanggaran->total();
        $totalPrestasi = $prestasi->total();
        $totalKonseling = $konseling->total();
        $totalSanksi = $sanksi->total();
        
        // Get total poin from all data, not just paginated
        $poinPelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'disetujui')
            ->sum('poin');
        $poinPrestasi = Prestasi::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'disetujui')
            ->sum('poin');
        
        // Recent activities
        $recentActivities = collect();
        
        foreach($pelanggaran->items() as $p) {
            if($recentActivities->count() >= 3) break;
            $recentActivities->push([
                'type' => 'pelanggaran',
                'title' => $p->jenisPelanggaran->nama_pelanggaran ?? 'Pelanggaran',
                'description' => $p->keterangan ?? 'Tidak ada deskripsi',
                'date' => $p->tanggal?->format('d M Y') ?? 'N/A' 
            ]);
        }
        
        foreach($prestasi->items() as $p) {
            if($recentActivities->count() >= 6) break;
            $recentActivities->push([
                'type' => 'prestasi',
                'title' => $p->jenisPrestasi->nama_prestasi ?? 'Prestasi',
                'description' => $p->deskripsi ?? 'Tidak ada deskripsi',
                'date' => $p->created_at?->format('d M Y') ?? 'N/A' 
            ]);
        }
        
        foreach($konseling->items() as $k) {
            if($recentActivities->count() >= 9) break;
            $recentActivities->push([
                'type' => 'konseling',
                'title' => $k->jenis_layanan ?? 'Bimbingan Konseling',
                'description' => $k->topik ?? 'Tidak ada topik',
                'date' => $k->tanggal_konseling?->format('d M Y') ?? 'N/A' 
            ]);
        }
        
        foreach($sanksi->items() as $s) {
            if($recentActivities->count() >= 12) break;
            $recentActivities->push([
                'type' => 'sanksi',
                'title' => $s->sanksi->jenis_sanksi ?? 'Sanksi',
                'description' => $s->sanksi->deskripsi_sanksi ?? 'Tidak ada deskripsi',
                'date' => $s->tanggal_pelaksanaan?->format('d M Y') ?? 'N/A' 
            ]);
        }
        
        // Mengurutkan koleksi berdasarkan tanggal, bukan string date
        // Asumsi data tanggal (d M Y) sudah cukup untuk sorting
        $recentActivities = $recentActivities->sortByDesc('date')->take(5);
        
        return view('siswa.dashboard', compact(
            'siswa', 'totalPelanggaran', 'totalPrestasi', 'totalKonseling', 'totalSanksi',
            'poinPelanggaran', 'poinPrestasi', 'recentActivities',
            'pelanggaran', 'prestasi', 'konseling', 'sanksi'
        ));
    }
}