<?php

namespace App\Http\Controllers\BK;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::all();
        return view('bk.laporan.index', compact('tahunAjaran'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'bulan' => 'nullable|integer|min:1|max:12',
            'jenis_layanan' => 'nullable|string',
        ]);

        $query = BimbinganKonseling::with(['siswa.kelas', 'tahunAjaran', 'konselor'])
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id);

        if ($request->bulan) {
            $query->whereMonth('tanggal_konseling', $request->bulan);
        }

        if ($request->jenis_layanan) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }

        $konseling = $query->orderBy('tanggal_konseling', 'desc')->get();
        $tahunAjaran = TahunAjaran::find($request->tahun_ajaran_id);

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('bk.laporan.pdf', compact('konseling', 'tahunAjaran', 'request'));
            return $pdf->download('laporan-bimbingan-konseling-' . date('Y-m-d') . '.pdf');
        }

        // Default ke preview jika tidak ada format atau format = preview
        return view('bk.laporan.preview', compact('konseling', 'tahunAjaran', 'request'));
    }
}