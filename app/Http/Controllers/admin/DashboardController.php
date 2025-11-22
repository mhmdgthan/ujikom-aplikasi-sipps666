<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahSiswa = Siswa::count();
        $jumlahKelas = Kelas::count();
        $jumlahUser = User::count();
        $pelanggaranPending = Pelanggaran::where('status_verifikasi', 'pending')->count();
        $prestasiPending = Prestasi::where('status_verifikasi', 'pending')->count();

        $pelanggaranBulanan = [];
        $bulanLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $bulanLabels[] = $bulan->format('M Y');
            $pelanggaranBulanan[] = Pelanggaran::whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->where('status_verifikasi', 'disetujui')
                ->count();
        }

        $pelanggaranKategori = DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->join('kategori_pelanggaran', 'jenis_pelanggaran.kategori_pelanggaran_id', '=', 'kategori_pelanggaran.id')
            ->where('pelanggaran.status_verifikasi', 'disetujui')
            ->select('kategori_pelanggaran.kategori_induk', DB::raw('count(*) as total'))
            ->groupBy('kategori_pelanggaran.kategori_induk')
            ->get();

        $siswaPelanggaran = Siswa::with(['user', 'kelas'])
            ->withCount(['pelanggaran as total_pelanggaran' => function($query) {
                $query->where('status_verifikasi', 'disetujui');
            }])
            ->having('total_pelanggaran', '>', 0)
            ->orderBy('total_pelanggaran', 'desc')
            ->limit(5)
            ->get();

        $pelanggaranTerbaru = Pelanggaran::with([
            'siswa.user', 
            'siswa.kelas', 
            'jenisPelanggaran'
        ])
        ->where('status_verifikasi', 'disetujui')
        ->latest()
        ->take(5)
        ->get();
        $prestasiTerbaru = Prestasi::with([
            'siswa.user', 
            'siswa.kelas', 
            'jenisPrestasi'
        ])
        ->latest()
        ->take(5)
        ->get();

        return view('admin.dashboard', compact(
            'jumlahSiswa', 
            'jumlahKelas', 
            'jumlahUser', 
            'pelanggaranPending', 
            'prestasiPending',
            'pelanggaranBulanan', 
            'bulanLabels', 
            'pelanggaranKategori', 
            'siswaPelanggaran',
            'pelanggaranTerbaru',
            'prestasiTerbaru'
        ));
    }
}