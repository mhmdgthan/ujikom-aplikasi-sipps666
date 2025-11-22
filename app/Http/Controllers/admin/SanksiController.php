<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sanksi;
use App\Models\Siswa;
use App\Models\JenisSanksi;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index()
    {
        $sanksi = Sanksi::with(['pelanggaran.siswa.user', 'pelanggaran.siswa.kelas'])->latest()->get();
        $pelanggaran = \App\Models\Pelanggaran::with(['siswa.user', 'siswa.kelas'])->get();
        $jenisSanksi = JenisSanksi::all();
        return view('admin.sanksi.index', compact('sanksi', 'pelanggaran', 'jenisSanksi'));
    }

    public function show(Sanksi $sanksi)
    {
        $sanksi->load(['pelanggaran.siswa.user', 'pelanggaran.siswa.kelas']);
        return response()->json($sanksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_sanksi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:belum,proses,selesai'
        ]);

        Sanksi::create($request->all());
        return redirect()->back()->with('success', 'Data sanksi berhasil ditambahkan');
    }

    public function update(Request $request, Sanksi $sanksi)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_sanksi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:belum,proses,selesai'
        ]);

        $sanksi->update($request->all());
        return redirect()->back()->with('success', 'Data sanksi berhasil diperbarui');
    }

    public function destroy(Sanksi $sanksi)
    {
        $sanksi->delete();
        return redirect()->back()->with('success', 'Data sanksi berhasil dihapus');
    }
}