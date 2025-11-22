<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->paginate(10);
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusan,nama_jurusan',
            'singkatan' => 'required|string|max:20|unique:jurusan,singkatan'
        ]);

        Jurusan::create($request->all());

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil ditambahkan');
    }

    public function show(Jurusan $jurusan)
    {
        return response()->json($jurusan);
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusan,nama_jurusan,' . $jurusan->id,
            'singkatan' => 'required|string|max:20|unique:jurusan,singkatan,' . $jurusan->id
        ]);

        $jurusan->update($request->all());

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil diperbarui');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data jurusan berhasil dihapus');
    }
}