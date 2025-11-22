<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use Illuminate\Http\Request;

class KategoriPelanggaranController extends Controller
{
    public function index()
    {
        $kategoriPelanggaran = KategoriPelanggaran::paginate(10);
        return view('admin.kategori-pelanggaran.index', compact('kategoriPelanggaran'));
    }

    public function show(KategoriPelanggaran $kategoriPelanggaran)
    {
        return response()->json($kategoriPelanggaran);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_pelanggaran,nama_kategori',
            'kategori_induk' => 'required|in:KEPRIBADIAN,KERAJINAN,KERAPIAN'
        ], [
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        $data = $request->all();
        $data['kode_kategori'] = strtoupper(substr($request->kategori_induk, 0, 3)) . str_pad(KategoriPelanggaran::count() + 1, 3, '0', STR_PAD_LEFT);
        
        KategoriPelanggaran::create($data);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, KategoriPelanggaran $kategoriPelanggaran)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_pelanggaran,nama_kategori,' . $kategoriPelanggaran->id,
            'kategori_induk' => 'required|in:KEPRIBADIAN,KERAJINAN,KERAPIAN'
        ], [
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        $kategoriPelanggaran->update($request->only(['nama_kategori', 'kategori_induk']));
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(KategoriPelanggaran $kategoriPelanggaran)
    {
        $kategoriPelanggaran->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}