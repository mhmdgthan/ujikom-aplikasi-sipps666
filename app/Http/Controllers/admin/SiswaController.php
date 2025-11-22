<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'user']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function($userQuery) use ($request) {
                    $userQuery->where('nama_lengkap', 'like', "%{$request->search}%");
                })
                  ->orWhere('nis', 'like', "%{$request->search}%")
                  ->orWhere('nisn', 'like', "%{$request->search}%");
            });
        }

        $siswa = $query->latest()->paginate(10)->appends(request()->query());
        $kelas = Kelas::all();
        $users = User::where('level', 'siswa')->get();

        return view('admin.siswa.index', compact('siswa', 'kelas', 'users'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $users = User::where('level', 'siswa')->whereDoesntHave('siswa')->get();
        return view('admin.siswa.create', compact('kelas', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nis' => 'required|unique:siswa,nis',
            'nisn' => 'required|unique:siswa,nisn',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'nullable|max:15',
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'user_id.required' => 'User wajib dipilih',
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah digunakan',
            'nisn.required' => 'NISN wajib diisi',
            'nisn.unique' => 'NISN sudah digunakan',
            'kelas_id.required' => 'Kelas wajib dipilih',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('siswa', $fotoName, 'public');
            $data['foto'] = $path;
            
            // Copy file ke public/storage untuk Windows
            $sourcePath = storage_path('app/public/' . $path);
            $destPath = public_path('storage/' . $path);
            if (!file_exists(dirname($destPath))) {
                mkdir(dirname($destPath), 0755, true);
            }
            copy($sourcePath, $destPath);
        }

        Siswa::create($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $siswa = Siswa::with(['kelas', 'user'])->findOrFail($id);
        return response()->json($siswa);
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        $users = User::where('level', 'siswa')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelas', 'users'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nis' => 'required|unique:siswa,nis,' . $id,
            'nisn' => 'required|unique:siswa,nisn,' . $id,
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'nullable|max:15',
            'kelas_id' => 'required|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah digunakan',
            'nisn.required' => 'NISN wajib diisi',
            'nisn.unique' => 'NISN sudah digunakan',
            'kelas_id.required' => 'Kelas wajib dipilih',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
                // Hapus juga dari public/storage
                $oldPublicPath = public_path('storage/' . $siswa->foto);
                if (file_exists($oldPublicPath)) {
                    unlink($oldPublicPath);
                }
            }

            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('siswa', $fotoName, 'public');
            $data['foto'] = $path;
            
            // Copy file ke public/storage untuk Windows
            $sourcePath = storage_path('app/public/' . $path);
            $destPath = public_path('storage/' . $path);
            if (!file_exists(dirname($destPath))) {
                mkdir(dirname($destPath), 0755, true);
            }
            copy($sourcePath, $destPath);
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus foto jika ada
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
            // Hapus juga dari public/storage
            $publicPath = public_path('storage/' . $siswa->foto);
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }

        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    public function resetPassword($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $siswa->user->update(['password' => Hash::make($siswa->nis)]);

        return redirect()->back()
            ->with('success', 'Password berhasil direset ke NIS!');
    }
}