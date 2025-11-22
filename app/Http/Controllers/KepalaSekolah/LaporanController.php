<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::all();
        $kelas = Kelas::with('jurusan')->get();
        
        return view('kepala-sekolah.laporan.index', compact('tahunAjaran', 'kelas'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:siswa,pelanggaran,prestasi,konseling,rekap',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajaran,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $data = [];
        $tahunAjaran = null;
        $kelas = null;

        if ($request->tahun_ajaran_id) {
            $tahunAjaran = TahunAjaran::find($request->tahun_ajaran_id);
        }

        if ($request->kelas_id) {
            $kelas = Kelas::with('jurusan')->find($request->kelas_id);
        }

        switch ($request->jenis_laporan) {
            case 'siswa':
                $query = Siswa::with(['kelas.jurusan', 'user']);
                if ($request->kelas_id) {
                    $query->where('kelas_id', $request->kelas_id);
                }
                $data = $query->get();
                break;

            case 'pelanggaran':
                $query = Pelanggaran::with(['siswa.kelas.jurusan', 'siswa.user', 'jenisPelanggaran', 'tahunAjaran'])
                    ->where('status_verifikasi', 'disetujui');
                if ($request->tanggal_mulai) {
                    $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
                }
                if ($request->tanggal_selesai) {
                    $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
                }
                if ($request->kelas_id) {
                    $query->whereHas('siswa', function($q) use ($request) {
                        $q->where('kelas_id', $request->kelas_id);
                    });
                }
                $data = $query->get();
                break;

            case 'prestasi':
                $query = Prestasi::with(['siswa.kelas.jurusan', 'siswa.user', 'jenisPrestasi', 'tahunAjaran'])
                    ->where('status_verifikasi', 'disetujui');
                if ($request->tanggal_mulai) {
                    $query->whereDate('tanggal_prestasi', '>=', $request->tanggal_mulai);
                }
                if ($request->tanggal_selesai) {
                    $query->whereDate('tanggal_prestasi', '<=', $request->tanggal_selesai);
                }
                if ($request->kelas_id) {
                    $query->whereHas('siswa', function($q) use ($request) {
                        $q->where('kelas_id', $request->kelas_id);
                    });
                }
                $data = $query->get();
                break;

            case 'konseling':
                $query = BimbinganKonseling::with(['siswa.kelas.jurusan', 'siswa.user', 'tahunAjaran', 'konselor']);
                if ($request->tanggal_mulai) {
                    $query->whereDate('tanggal_konseling', '>=', $request->tanggal_mulai);
                }
                if ($request->tanggal_selesai) {
                    $query->whereDate('tanggal_konseling', '<=', $request->tanggal_selesai);
                }
                if ($request->kelas_id) {
                    $query->whereHas('siswa', function($q) use ($request) {
                        $q->where('kelas_id', $request->kelas_id);
                    });
                }
                $data = $query->get();
                break;

            case 'rekap':
                $data = $this->getRekapData($request);
                break;
        }

        if ($request->format === 'pdf') {
            $pdf = PDF::loadView('kepala-sekolah.laporan.pdf', compact('data', 'request', 'tahunAjaran', 'kelas'));
            $filename = 'laporan_' . $request->jenis_laporan . '_' . date('Y-m-d') . '.pdf';
            return $pdf->download($filename);
        }
        
        if ($request->format === 'excel') {
            $export = new LaporanExport($data, $request);
            return $export->export();
        }
        
        return view('kepala-sekolah.laporan.preview', compact('data', 'request', 'tahunAjaran', 'kelas'));
    }

    private function getRekapData($request)
    {
        $siswaQuery = Siswa::with(['kelas.jurusan', 'pelanggaran' => function($q) use ($request) {
            $q->where('status_verifikasi', 'disetujui');
            if ($request->tahun_ajaran_id) {
                $q->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            }
        }, 'prestasi' => function($q) use ($request) {
            $q->where('status_verifikasi', 'disetujui');
            if ($request->tahun_ajaran_id) {
                $q->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            }
        }]);

        if ($request->kelas_id) {
            $siswaQuery->where('kelas_id', $request->kelas_id);
        }

        return $siswaQuery->get();
    }
}