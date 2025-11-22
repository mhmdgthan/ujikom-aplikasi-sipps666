<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;

class SiswaProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::with(['kelas'])->where('user_id', $user->id)->firstOrFail();

        return view('siswa.profil.index', compact('siswa'));
    }
}
