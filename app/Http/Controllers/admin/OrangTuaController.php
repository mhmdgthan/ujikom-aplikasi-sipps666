<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangTua = OrangTua::with(['user', 'siswa.user', 'siswa.kelas'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $users = User::where('level', 'orang_tua')->get();
        $siswas = Siswa::with('user')->get();

        return view('admin.orang-tua.index', compact('orangTua', 'users', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'siswa_id' => 'required|exists:siswa,id',
            'hubungan' => 'required|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:255',
        ], [
            'user_id.required' => 'User orang tua wajib dipilih',
            'siswa_id.required' => 'Siswa wajib dipilih',
            'hubungan.required' => 'Hubungan keluarga wajib dipilih',
        ]);
        $exists = OrangTua::where('user_id', $request->user_id)
                         ->where('siswa_id', $request->siswa_id)
                         ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'duplicate' => 'Kombinasi user dan siswa sudah ada, silakan pilih yang berbeda'
            ])->withInput();
        }

        OrangTua::create($request->only([
            'user_id', 'siswa_id', 'hubungan', 'pekerjaan', 'alamat'
        ]));

        return redirect()->route('admin.orang-tua.index')
            ->with('success', 'Data orang tua berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'siswa_id' => 'required|exists:siswa,id',
            'hubungan' => 'required|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:255',
        ], [
            'user_id.required' => 'User orang tua wajib dipilih',
            'siswa_id.required' => 'Siswa wajib dipilih',
            'hubungan.required' => 'Hubungan keluarga wajib dipilih',
        ]);

        $exists = OrangTua::where('user_id', $request->user_id)
                         ->where('siswa_id', $request->siswa_id)
                         ->where('id', '!=', $id)
                         ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors([
                'duplicate' => 'Kombinasi user dan siswa sudah ada, silakan pilih yang berbeda'
            ])->withInput();
        }

        $orangTua = OrangTua::findOrFail($id);
        $orangTua->update($request->only([
            'user_id', 'siswa_id', 'hubungan', 'pekerjaan', 'alamat'
        ]));

        return redirect()->route('admin.orang-tua.index')
            ->with('success', 'Data orang tua berhasil diperbarui!');
    }

    public function show($id)
    {
        $orangTua = OrangTua::with(['user', 'siswa.user', 'siswa.kelas'])->findOrFail($id);
        return response()->json($orangTua);
    }

    public function destroy($id)
    {
        $orangTua = OrangTua::findOrFail($id);
        $orangTua->delete();

        return redirect()->route('admin.orang-tua.index')
            ->with('success', 'Data orang tua berhasil dihapus!');
    }
}
