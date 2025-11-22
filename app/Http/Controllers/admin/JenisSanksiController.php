<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSanksi;
use Illuminate\Http\Request;

class JenisSanksiController extends Controller
{
    public function index()
    {
        $jenisSanksi = JenisSanksi::paginate(10);
        return view('admin.jenis-sanksi.index', compact('jenisSanksi'));
    }

    public function show(JenisSanksi $jenisSanksi)
    {
        return response()->json($jenisSanksi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sanksi' => 'required|unique:jenis_sanksi,nama_sanksi',
            'kategori' => 'required|in:RINGAN,SEDANG,BERAT',
            'deskripsi' => 'nullable|string'
        ], [
            'nama_sanksi.unique' => 'Nama sanksi sudah ada'
        ]);

        JenisSanksi::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, JenisSanksi $jenisSanksi)
    {
        $request->validate([
            'nama_sanksi' => 'required|unique:jenis_sanksi,nama_sanksi,' . $jenisSanksi->id,
            'kategori' => 'required|in:RINGAN,SEDANG,BERAT',
            'deskripsi' => 'nullable|string'
        ], [
            'nama_sanksi.unique' => 'Nama sanksi sudah ada'
        ]);

        $jenisSanksi->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(JenisSanksi $jenisSanksi)
    {
        $jenisSanksi->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}