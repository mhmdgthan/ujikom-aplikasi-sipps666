<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\BimbinganKonseling;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('kesiswaan.laporan.index', compact('kelas'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:pelanggaran,prestasi,siswa,konseling',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        $data = $this->getData($request);
        
        if ($request->format === 'pdf') {
            return $this->generatePDF($request, $data);
        } elseif ($request->format === 'excel') {
            return $this->generateExcel($request, $data);
        }
        
        return view('kesiswaan.laporan.preview', compact('data', 'request'));
    }

    private function getData($request)
    {
        $query = null;
        
        switch ($request->jenis_laporan) {
            case 'pelanggaran':
                $query = Pelanggaran::with(['siswa.user', 'siswa.kelas.jurusan', 'jenisPelanggaran', 'tahunAjaran', 'guruPencatat.user'])
                    ->where('status_verifikasi', 'disetujui');
                break;
            case 'prestasi':
                $query = Prestasi::with(['siswa.user', 'siswa.kelas.jurusan', 'jenisPrestasi.kategoriPrestasi', 'tahunAjaran'])
                    ->where('status_verifikasi', 'disetujui');
                break;
            case 'siswa':
                $query = Siswa::with(['user', 'kelas.jurusan']);
                break;
            case 'konseling':
                $query = BimbinganKonseling::with(['siswa.user', 'siswa.kelas.jurusan']);
                break;
        }

        if ($request->kelas_id) {
            if ($request->jenis_laporan === 'siswa') {
                $query->where('kelas_id', $request->kelas_id);
            } else {
                $query->whereHas('siswa', function($q) use ($request) {
                    $q->where('kelas_id', $request->kelas_id);
                });
            }
        }

        if ($request->tanggal_mulai && $request->tanggal_selesai) {
            if ($request->jenis_laporan === 'pelanggaran') {
                $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            } else {
                $query->whereBetween('created_at', [$request->tanggal_mulai, $request->tanggal_selesai]);
            }
        }

        return $query->get()->map(function($item) use ($request) {
            switch ($request->jenis_laporan) {
                case 'pelanggaran':
                    $item->nama_siswa = $item->siswa->user->nama_lengkap ?? 'Tidak Diketahui';
                    $item->kelas_siswa = $item->siswa->kelas->nama_kelas ?? 'Tidak Diketahui';
                    $item->jurusan_siswa = $item->siswa->kelas->jurusan->nama_jurusan ?? 'Tidak Diketahui';
                    $item->jenis_pelanggaran_nama = $item->jenisPelanggaran->nama_pelanggaran ?? 'Tidak Diketahui';
                    $item->tahun_ajaran_nama = $item->tahunAjaran->tahun_ajaran ?? 'Tidak Diketahui';
                    $item->guru_pencatat_nama = $item->guruPencatat->user->nama_lengkap ?? 'Tidak Diketahui';
                    break;
                case 'prestasi':
                    $item->nama_siswa = $item->siswa->user->nama_lengkap ?? 'Tidak Diketahui';
                    $item->kelas_siswa = $item->siswa->kelas->nama_kelas ?? 'Tidak Diketahui';
                    $item->jurusan_siswa = $item->siswa->kelas->jurusan->nama_jurusan ?? 'Tidak Diketahui';
                    $item->jenis_prestasi_nama = $item->jenisPrestasi->nama_prestasi ?? 'Tidak Diketahui';
                    $item->kategori_prestasi_nama = $item->jenisPrestasi->kategoriPrestasi->nama_kategori ?? 'Tidak Diketahui';
                    $item->tahun_ajaran_nama = $item->tahunAjaran->tahun_ajaran ?? 'Tidak Diketahui';
                    break;
                case 'siswa':
                    $item->nama_lengkap = $item->user->nama_lengkap ?? 'Tidak Diketahui';
                    $item->kelas_nama = $item->kelas->nama_kelas ?? 'Tidak Diketahui';
                    $item->jurusan_nama = $item->kelas->jurusan->nama_jurusan ?? 'Tidak Diketahui';
                    break;
            }
            return $item;
        });
    }

    private function generatePDF($request, $data)
    {
        try {
            $pdf = PDF::loadView('kesiswaan.laporan.pdf', compact('data', 'request'))
                ->setPaper('a4', 'landscape')
                ->setOptions(['defaultFont' => 'sans-serif']);
            $filename = 'laporan_' . $request->jenis_laporan . '_' . date('Y-m-d') . '.pdf';
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    private function generateExcel($request, $data)
    {
        try {
            $filename = 'laporan_' . $request->jenis_laporan . '_' . date('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            $callback = function() use ($data, $request) {
                $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                switch ($request->jenis_laporan) {
                    case 'pelanggaran':
                        fputcsv($file, ['No', 'Nama Siswa', 'Kelas', 'Jurusan', 'Jenis Pelanggaran', 'Poin', 'Tanggal', 'Tahun Ajaran', 'Guru Pencatat']);
                        foreach ($data as $index => $item) {
                            fputcsv($file, [
                                $index + 1,
                                $item->nama_siswa,
                                $item->kelas_siswa,
                                $item->jurusan_siswa,
                                $item->jenis_pelanggaran_nama,
                                $item->poin ?? 0,
                                $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : 'Tidak Diketahui',
                                $item->tahun_ajaran_nama,
                                $item->guru_pencatat_nama
                            ]);
                        }
                        break;
                    case 'prestasi':
                        fputcsv($file, ['No', 'Nama Siswa', 'Kelas', 'Jurusan', 'Jenis Prestasi', 'Kategori', 'Poin', 'Tanggal', 'Tahun Ajaran']);
                        foreach ($data as $index => $item) {
                            fputcsv($file, [
                                $index + 1,
                                $item->nama_siswa,
                                $item->kelas_siswa,
                                $item->jurusan_siswa,
                                $item->jenis_prestasi_nama,
                                $item->kategori_prestasi_nama,
                                $item->poin ?? 0,
                                $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : 'Tidak Diketahui',
                                $item->tahun_ajaran_nama
                            ]);
                        }
                        break;
                    case 'siswa':
                        fputcsv($file, ['No', 'Nama Lengkap', 'NIS', 'NISN', 'Kelas', 'Jurusan', 'Jenis Kelamin']);
                        foreach ($data as $index => $item) {
                            fputcsv($file, [
                                $index + 1,
                                $item->nama_lengkap,
                                $item->nis ?? 'Tidak Diketahui',
                                $item->nisn ?? 'Tidak Diketahui',
                                $item->kelas_nama,
                                $item->jurusan_nama,
                                $item->jenis_kelamin ?? 'Tidak Diketahui'
                            ]);
                        }
                        break;
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal generate Excel: ' . $e->getMessage());
        }
    }
}