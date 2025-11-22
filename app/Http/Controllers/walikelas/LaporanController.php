<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil kelas yang diampu oleh wali kelas yang sedang login
        $waliKelas = WaliKelas::where('guru_id', Auth::id())
            ->whereNull('tanggal_selesai')
            ->with('kelas.jurusan')
            ->first();
            
        $kelas = $waliKelas ? collect([$waliKelas->kelas]) : collect([]);
        return view('wali-kelas.laporan.index', compact('kelas'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:pelanggaran,prestasi,siswa',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        $data = $this->getData($request);
        
        if ($request->format === 'pdf') {
            return $this->generatePDF($request, $data);
        }
        
        if ($request->format === 'excel') {
            return $this->generateExcel($request, $data);
        }
        
        return view('wali-kelas.laporan.preview', compact('data', 'request'));
    }

    private function getData($request)
    {
        $query = null;
        
        switch ($request->jenis_laporan) {
            case 'pelanggaran':
                $query = Pelanggaran::with(['siswa.kelas.jurusan', 'jenisPelanggaran', 'tahunAjaran'])
                    ->where('status_verifikasi', 'disetujui');
                break;
            case 'prestasi':
                $query = Prestasi::with(['siswa.kelas.jurusan', 'jenisPrestasi', 'tahunAjaran'])
                    ->where('status_verifikasi', 'disetujui');
                break;
            case 'siswa':
                $query = Siswa::with(['kelas.jurusan']);
                break;
        }

        // Batasi hanya untuk kelas yang diampu wali kelas
        $waliKelas = WaliKelas::where('guru_id', Auth::id())
            ->whereNull('tanggal_selesai')
            ->first();
            
        if ($waliKelas) {
            if ($request->jenis_laporan === 'siswa') {
                $query->where('kelas_id', $waliKelas->kelas_id);
            } else {
                $query->whereHas('siswa', function($q) use ($waliKelas) {
                    $q->where('kelas_id', $waliKelas->kelas_id);
                });
            }
        }

        if ($request->tanggal_mulai && $request->tanggal_selesai) {
            $query->whereBetween('created_at', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        return $query->get();
    }

    private function generatePDF($request, $data)
    {
        $pdf = PDF::loadView('wali-kelas.laporan.pdf', compact('data', 'request'));
        $filename = 'laporan_' . $request->jenis_laporan . '_' . date('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

    private function generateExcel($request, $data)
    {
        $export = new LaporanExport($data, $request);
        return $export->export();
    }
}