<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderBy('tanggal_mulai', 'desc')->paginate(10);
        return view('admin.tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function show($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return response()->json($tahunAjaran);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:50',
            'semester' => 'required|in:Ganjil,Genap',
            'status_aktif' => 'nullable|boolean',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'semester.required' => 'Semester wajib dipilih',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);
        $exists = TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran)
                            ->where('semester', $request->semester)
                            ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'duplicate' => 'Kombinasi tahun ajaran dan semester sudah ada, silakan gunakan yang berbeda'
            ])->withInput();
        }
        $semesterCode = $request->semester === 'Ganjil' ? '1' : '2';
        $validated['kode_tahun'] = str_replace('/', '', $request->tahun_ajaran) . $semesterCode;
        $validated['status_aktif'] = $request->has('status_aktif');

        TahunAjaran::create($validated);
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Data tahun ajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tahun = TahunAjaran::findOrFail($id);
        return response()->json($tahun);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:50',
            'semester' => 'required|in:Ganjil,Genap',
            'status_aktif' => 'nullable|boolean',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'semester.required' => 'Semester wajib dipilih',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);

        $exists = TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran)
                            ->where('semester', $request->semester)
                            ->where('id', '!=', $id)
                            ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'duplicate' => 'Kombinasi tahun ajaran dan semester sudah ada, silakan gunakan yang berbeda'
            ])->withInput();
        }

        $semesterCode = $request->semester === 'Ganjil' ? '1' : '2';
        $validated['kode_tahun'] = str_replace('/', '', $request->tahun_ajaran) . $semesterCode;
        $validated['status_aktif'] = $request->has('status_aktif');

        $tahun = TahunAjaran::findOrFail($id);
        $tahun->update($validated);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Data tahun ajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        TahunAjaran::findOrFail($id)->delete();
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Data tahun ajaran berhasil dihapus.');
    }
}
