<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\KategoriPelanggaran;
use App\Models\JenisSanksi;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenisPelanggaran = JenisPelanggaran::with('kategoriPelanggaran')->latest()->paginate(10);
        $kategoriPelanggaran = KategoriPelanggaran::all();
        $jenisSanksi = JenisSanksi::all();
        return view('admin.jenis-pelanggaran.index', compact('jenisPelanggaran', 'kategoriPelanggaran', 'jenisSanksi'));
    }

    public function show($id)
    {
        $jenisPelanggaran = JenisPelanggaran::with('kategoriPelanggaran')->findOrFail($id);
        return response()->json($jenisPelanggaran);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_pelanggaran_id' => 'required|exists:kategori_pelanggaran,id',
            'nama_pelanggaran' => 'required|string|max:255|unique:jenis_pelanggaran,nama_pelanggaran',
            'poin' => 'required|integer|min:1',
            'sanksi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ], [
            'kategori_pelanggaran_id.required' => 'Kategori pelanggaran wajib dipilih',
            'nama_pelanggaran.required' => 'Nama pelanggaran wajib diisi',
            'nama_pelanggaran.unique' => 'Nama pelanggaran sudah ada, silakan gunakan nama yang berbeda',
            'poin.required' => 'Poin wajib diisi',
        ]);

        JenisPelanggaran::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_pelanggaran_id' => 'required|exists:kategori_pelanggaran,id',
            'nama_pelanggaran' => 'required|string|max:255|unique:jenis_pelanggaran,nama_pelanggaran,' . $id,
            'poin' => 'required|integer|min:1',
            'sanksi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ], [
            'kategori_pelanggaran_id.required' => 'Kategori pelanggaran wajib dipilih',
            'nama_pelanggaran.required' => 'Nama pelanggaran wajib diisi',
            'nama_pelanggaran.unique' => 'Nama pelanggaran sudah ada, silakan gunakan nama yang berbeda',
            'poin.required' => 'Poin wajib diisi',
        ]);

        $data = JenisPelanggaran::findOrFail($id);
        $data->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = JenisPelanggaran::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
