<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPrestasi;
use Illuminate\Http\Request;

class JenisPrestasiController extends Controller
{
    public function index()
    {
        $jenisPrestasi = JenisPrestasi::latest()->paginate(10);
        return view('admin.jenis-prestasi.index', compact('jenisPrestasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255|unique:jenis_prestasi,nama_prestasi',
            'poin' => 'required|integer|min:1',
            'kategori' => 'required|string',
            'reward' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_prestasi.required' => 'Nama prestasi wajib diisi',
            'nama_prestasi.unique' => 'Nama prestasi sudah ada, silakan gunakan nama yang berbeda',
            'poin.required' => 'Poin wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
        ]);

        JenisPrestasi::create($request->all());
        return redirect()->back()->with('success', 'Data jenis prestasi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255|unique:jenis_prestasi,nama_prestasi,' . $id,
            'poin' => 'required|integer|min:1',
            'kategori' => 'required|string',
            'reward' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_prestasi.required' => 'Nama prestasi wajib diisi',
            'nama_prestasi.unique' => 'Nama prestasi sudah ada, silakan gunakan nama yang berbeda',
            'poin.required' => 'Poin wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
        ]);

        $data = JenisPrestasi::findOrFail($id);
        $data->update($request->all());
        return redirect()->back()->with('success', 'Data jenis prestasi berhasil diperbarui!');
    }

    public function show($id)
    {
        $jenisPrestasi = JenisPrestasi::findOrFail($id);
        return response()->json($jenisPrestasi);
    }

    public function destroy($id)
    {
        $data = JenisPrestasi::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data jenis prestasi berhasil dihapus!');
    }
}
