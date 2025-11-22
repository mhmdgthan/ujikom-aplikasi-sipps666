<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'      => 'required|unique:users,username',
            'password'      => 'required|min:5',
            'nama_lengkap'  => 'required|unique:users,nama_lengkap',
            'level'         => 'required',
            'can_verify'    => 'nullable|boolean',
            'is_active'     => 'nullable|boolean'
        ], [
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',
            'nama_lengkap.unique' => 'Nama lengkap sudah terdaftar, tidak dapat menambahkan data duplikat.'
        ]);

        User::create([
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'nama_lengkap'  => $request->nama_lengkap,
            'level'         => $request->level,
            'can_verify'    => $request->input('can_verify', 0),
            'is_active'     => $request->input('is_active', 1),
            'created_at'    => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Memperbarui data user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username'      => 'required|unique:users,username,' . $user->id,
            'nama_lengkap'  => 'required|unique:users,nama_lengkap,' . $user->id,
            'level'         => 'required',
            'password'      => 'nullable|min:5',
            'can_verify'    => 'nullable|boolean',
            'is_active'     => 'nullable|boolean'
        ], [
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',
            'nama_lengkap.unique' => 'Nama lengkap sudah terdaftar, tidak dapat mengubah ke data yang sudah ada.'
        ]);

        $request->merge(['user_id' => $id]);

        $data = [
            'username'     => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'level'        => $request->level,
            'can_verify'   => $request->input('can_verify', 0),
            'is_active'    => $request->input('is_active', 1),
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Menandai user aktif/tidak aktif (opsional toggle status).
     */
    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Status user diperbarui!');
    }
}
