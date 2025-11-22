<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
   public function index()
{
    $guru = Guru::with('user')
        ->whereNotNull('id')
        ->orderBy('created_at', 'desc')
        ->paginate(10)->appends(request()->query());
    
    $availableUsers = User::where('level', 'guru')
        ->whereNotIn('id', function($query) {
            $query->select('user_id')
                  ->from('guru')
                  ->whereNotNull('user_id');
        })
        ->orderBy('nama_lengkap', 'asc')
        ->get();
    
    return view('admin.guru.index', compact('guru', 'availableUsers'));
}

    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return response()->json($guru);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:guru,user_id',
            'nip' => 'required|unique:guru,nip',
            'nama_guru' => 'required|string|max:100|unique:guru,nama_guru',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'bidang_studi' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:guru,email',
            'no_telp' => 'nullable|string|max:20|unique:guru,no_telp',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'user_id.required' => 'Pilih user terlebih dahulu',
            'user_id.exists' => 'User tidak ditemukan',
            'user_id.unique' => 'User ini sudah terdaftar sebagai guru',
            'nip.unique' => 'NIP sudah terdaftar, tidak dapat menambahkan data duplikat',
            'nama_guru.unique' => 'Nama guru sudah terdaftar, tidak dapat menambahkan data duplikat',
            'email.unique' => 'Email sudah digunakan guru lain',
            'no_telp.unique' => 'No. telepon sudah digunakan guru lain',
        ]);

        DB::beginTransaction();
        try {
            Guru::create([
                'user_id' => $request->user_id,
                'nip' => $request->nip,
                'nama_guru' => $request->nama_guru,
                'jenis_kelamin' => $request->jenis_kelamin,
                'bidang_studi' => $request->bidang_studi,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data guru: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::where('id', $id)->firstOrFail();

        $request->validate([
            'user_id' => 'required|exists:users,id|unique:guru,user_id,' . $guru->id . ',id',
            'nip' => 'required|unique:guru,nip,' . $guru->id . ',id',
            'nama_guru' => 'required|string|max:100|unique:guru,nama_guru,' . $guru->id . ',id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'bidang_studi' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:guru,email,' . $guru->id . ',id',
            'no_telp' => 'nullable|string|max:20|unique:guru,no_telp,' . $guru->id . ',id',
            'status' => 'required|in:Aktif,Nonaktif',
        ], [
            'user_id.required' => 'Pilih user terlebih dahulu',
            'user_id.exists' => 'User tidak ditemukan',
            'user_id.unique' => 'User ini sudah terdaftar sebagai guru lain',
            'nip.unique' => 'NIP sudah terdaftar, tidak dapat mengubah ke data yang sudah ada',
            'nama_guru.unique' => 'Nama guru sudah terdaftar, tidak dapat mengubah ke data yang sudah ada',
            'email.unique' => 'Email sudah digunakan guru lain',
            'no_telp.unique' => 'No. telepon sudah digunakan guru lain',
        ]);

        DB::beginTransaction();
        try {
            $guru->update([
                'user_id' => $request->user_id,
                'nip' => $request->nip,
                'nama_guru' => $request->nama_guru,
                'jenis_kelamin' => $request->jenis_kelamin,
                'bidang_studi' => $request->bidang_studi,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $guru = Guru::findOrFail($id);
            $guru->delete();

            DB::commit();
            return redirect()->route('admin.guru.index')
                ->with('success', 'Data guru berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus data guru: ' . $e->getMessage());
        }
    }


    public function getAvailableUsers($currentUserId = null)
    {
        try {
            $query = User::where('level', 'guru');
            
            if ($currentUserId) {
                $query->where(function($q) use ($currentUserId) {
                    $q->whereNotIn('id', function($subquery) {
                        $subquery->select('user_id')
                                 ->from('guru')
                                 ->whereNotNull('user_id');
                    })
                    ->orWhere('id', $currentUserId);
                });
            } else {
                $query->whereNotIn('id', function($subquery) {
                    $subquery->select('user_id')
                             ->from('guru')
                             ->whereNotNull('user_id');
                });
            }
            
            $users = $query->orderBy('nama_lengkap', 'asc')->get();
            
            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data user'
            ], 500);
        }
    }
}