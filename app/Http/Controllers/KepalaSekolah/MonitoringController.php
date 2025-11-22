<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\{Siswa, Guru, Pelanggaran, Prestasi, Sanksi, Kelas, Jurusan};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $filterType = $request->filter_type;
        $perPage = $request->per_page ?? 20;

        // Get counts for statistics
        $siswaCount = Siswa::count();
        $guruCount = Guru::count();
        $pelanggaranCount = Pelanggaran::count();
        $prestasiCount = Prestasi::count();
        $sanksiCount = Sanksi::count();
        $kelasCount = Kelas::count();
        $jurusanCount = Jurusan::count();

        // Build unified query for pagination
        $allData = collect();
        
        if (!$filterType || $filterType === 'siswa') {
            $siswaQuery = Siswa::with(['user', 'kelas']);
            if ($tanggalMulai && $tanggalSelesai) {
                $siswaQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            foreach($siswaQuery->get() as $item) {
                $allData->push((object)[
                    'id' => $item->id,
                    'type' => 'siswa',
                    'nama' => $item->user->nama_lengkap ?? 'Nama tidak tersedia',
                    'detail' => $item->nisn ?? 'NISN tidak tersedia',
                    'info' => $item->kelas->nama_kelas ?? 'Belum ada kelas',
                    'tanggal' => $item->created_at,
                    'status' => 'Aktif'
                ]);
            }
        }
        
        if (!$filterType || $filterType === 'guru') {
            $guruQuery = Guru::query();
            if ($tanggalMulai && $tanggalSelesai) {
                $guruQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            foreach($guruQuery->get() as $item) {
                $allData->push((object)[
                    'id' => $item->id,
                    'type' => 'guru', 
                    'nama' => $item->nama_guru,
                    'detail' => $item->nip ?? 'NIP tidak tersedia',
                    'info' => $item->bidang_studi ?? 'Belum ditentukan',
                    'tanggal' => $item->created_at,
                    'status' => 'Aktif'
                ]);
            }
        }
        
        if (!$filterType || $filterType === 'pelanggaran') {
            $pelanggaranQuery = Pelanggaran::with(['siswa.user', 'jenisPelanggaran']);
            if ($tanggalMulai && $tanggalSelesai) {
                $pelanggaranQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
            }
            foreach($pelanggaranQuery->get() as $item) {
                $allData->push((object)[
                    'id' => $item->id,
                    'type' => 'pelanggaran',
                    'nama' => $item->siswa->user->nama_lengkap ?? 'Nama tidak tersedia',
                    'detail' => $item->jenisPelanggaran->nama_pelanggaran ?? 'Jenis tidak tersedia',
                    'info' => $item->deskripsi ?? 'Tidak ada deskripsi',
                    'tanggal' => $item->tanggal,
                    'status' => ucfirst($item->status)
                ]);
            }
        }
        
        if (!$filterType || $filterType === 'prestasi') {
            $prestasiQuery = Prestasi::with(['siswa.user', 'jenisPrestasi']);
            if ($tanggalMulai && $tanggalSelesai) {
                $prestasiQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
            }
            foreach($prestasiQuery->get() as $item) {
                $allData->push((object)[
                    'id' => $item->id,
                    'type' => 'prestasi',
                    'nama' => $item->siswa->user->nama_lengkap ?? 'Nama tidak tersedia',
                    'detail' => $item->jenisPrestasi->nama_prestasi ?? 'Jenis tidak tersedia',
                    'info' => $item->deskripsi ?? 'Tidak ada deskripsi',
                    'tanggal' => $item->tanggal,
                    'status' => 'Tercatat'
                ]);
            }
        }
        
        if (!$filterType || $filterType === 'sanksi') {
            $sanksiQuery = Sanksi::with(['pelanggaran.siswa.user']);
            if ($tanggalMulai && $tanggalSelesai) {
                $sanksiQuery->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai]);
            }
            foreach($sanksiQuery->get() as $item) {
                $allData->push((object)[
                    'id' => $item->id,
                    'type' => 'sanksi',
                    'nama' => $item->pelanggaran->siswa->user->nama_lengkap ?? 'Nama tidak tersedia',
                    'detail' => $item->jenis_sanksi ?? 'Jenis tidak tersedia',
                    'info' => $item->deskripsi ?? 'Tidak ada deskripsi',
                    'tanggal' => $item->tanggal_mulai,
                    'status' => ucfirst($item->status)
                ]);
            }
        }
        
        if (!$filterType || $filterType === 'kelas') {
            $kelasQuery = Kelas::with(['jurusan']);
            if ($tanggalMulai && $tanggalSelesai) {
                $kelasQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            foreach($kelasQuery->get() as $item) {
                $allData->push((object)[
                    'id' => $item->id,
                    'type' => 'kelas',
                    'nama' => $item->nama_kelas,
                    'detail' => $item->jurusan->nama_jurusan ?? 'Jurusan tidak tersedia',
                    'info' => 'Kapasitas: ' . $item->kapasitas ?? 'Tidak ditentukan',
                    'tanggal' => $item->created_at,
                    'status' => 'Aktif'
                ]);
            }
        }
        
        if (!$filterType || $filterType === 'jurusan') {
            $jurusanQuery = Jurusan::query();
            if ($tanggalMulai && $tanggalSelesai) {
                $jurusanQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            foreach($jurusanQuery->get() as $item) {
                $allData->push((object)[
                    'id' => $item->id,
                    'type' => 'jurusan',
                    'nama' => $item->nama_jurusan,
                    'detail' => $item->kode_jurusan ?? 'Kode tidak tersedia',
                    'info' => $item->deskripsi ?? 'Tidak ada deskripsi',
                    'tanggal' => $item->created_at,
                    'status' => 'Aktif'
                ]);
            }
        }

        // Sort by date descending and reset keys
        $allData = $allData->sortByDesc('tanggal')->values();
        
        // Manual pagination
        $currentPage = $request->get('page', 1);
        $total = $allData->count();
        $paginatedData = $allData->forPage($currentPage, $perPage);
        
        // Reset collection keys for proper indexing
        $paginatedData = $paginatedData->values();
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedData,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('kepala-sekolah.monitoring-all.index', compact(
            'paginator', 'siswaCount', 'guruCount', 'pelanggaranCount', 'prestasiCount', 
            'sanksiCount', 'kelasCount', 'jurusanCount', 'tanggalMulai', 'tanggalSelesai', 
            'filterType', 'perPage'
        ));
    }

    public function exportPdf(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $filterType = $request->filter_type;

        $data = [];
        $stats = [];

        if ($filterType === 'pelanggaran' || !$filterType) {
            $pelanggaranQuery = Pelanggaran::with(['siswa.user', 'jenisPelanggaran']);
            if ($tanggalMulai && $tanggalSelesai) {
                $pelanggaranQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
            }
            $data['pelanggaran'] = $pelanggaranQuery->get();
            $stats['pelanggaran'] = $data['pelanggaran']->count();
        }

        if ($filterType === 'prestasi' || !$filterType) {
            $prestasiQuery = Prestasi::with(['siswa.user', 'jenisPrestasi']);
            if ($tanggalMulai && $tanggalSelesai) {
                $prestasiQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
            }
            $data['prestasi'] = $prestasiQuery->get();
            $stats['prestasi'] = $data['prestasi']->count();
        }

        if ($filterType === 'sanksi' || !$filterType) {
            $sanksiQuery = Sanksi::with(['pelanggaran.siswa.user']);
            if ($tanggalMulai && $tanggalSelesai) {
                $sanksiQuery->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai]);
            }
            $data['sanksi'] = $sanksiQuery->get();
            $stats['sanksi'] = $data['sanksi']->count();
        }

        if ($filterType === 'siswa' || !$filterType) {
            $siswaQuery = Siswa::with(['user', 'kelas']);
            if ($tanggalMulai && $tanggalSelesai) {
                $siswaQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            $data['siswa'] = $siswaQuery->get();
            $stats['siswa'] = $data['siswa']->count();
        }

        if ($filterType === 'guru' || !$filterType) {
            $guruQuery = Guru::query();
            if ($tanggalMulai && $tanggalSelesai) {
                $guruQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            $data['guru'] = $guruQuery->get();
            $stats['guru'] = $data['guru']->count();
        }

        if ($filterType === 'kelas' || !$filterType) {
            $kelasQuery = Kelas::with(['jurusan']);
            if ($tanggalMulai && $tanggalSelesai) {
                $kelasQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            $data['kelas'] = $kelasQuery->get();
            $stats['kelas'] = $data['kelas']->count();
        }

        if ($filterType === 'jurusan' || !$filterType) {
            $jurusanQuery = Jurusan::query();
            if ($tanggalMulai && $tanggalSelesai) {
                $jurusanQuery->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            }
            $data['jurusan'] = $jurusanQuery->get();
            $stats['jurusan'] = $data['jurusan']->count();
        }

        $pdf = Pdf::loadView('kepala-sekolah.monitoring-all.pdf', compact(
            'data', 'stats', 'tanggalMulai', 'tanggalSelesai', 'filterType'
        ));

        $filename = 'monitoring-' . ($filterType ?: 'all') . '-' . date('Y-m-d-H-i-s') . '.pdf';
        return $pdf->download($filename);
    }
}