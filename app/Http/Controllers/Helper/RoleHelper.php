<?php

namespace App\Http\Controllers\Helper;

use App\Models\WaliKelas;
use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    /**
     * Cek apakah user adalah wali kelas dari kelas tertentu
     */
    public static function isWaliKelasOf($kelasId)
    {
        if (!Auth::guard('web')->check()) {
            return false;
        }

        $user = Auth::guard('web')->user();
        
        // Cek apakah user ini adalah wali kelas dari kelas tersebut
        return WaliKelas::where('guru_id', $user->id)
            ->where('kelas_id', $kelasId)
            ->whereNull('tanggal_selesai') // Masih aktif
            ->exists();
    }

    /**
     * Dapatkan kelas yang diampu sebagai wali kelas
     */
    public static function getKelasAsWaliKelas()
    {
        if (!Auth::guard('web')->check()) {
            return collect();
        }

        $user = Auth::guard('web')->user();
        
        return WaliKelas::with('kelas')
            ->where('guru_id', $user->id)
            ->whereNull('tanggal_selesai')
            ->get()
            ->pluck('kelas');
    }

    /**
     * Cek apakah user bisa akses data siswa tertentu
     */
    public static function canAccessSiswa($siswaId)
    {
        if (!Auth::guard('web')->check()) {
            return false;
        }

        $user = Auth::guard('web')->user();
        
        // Admin dan kesiswaan bisa akses semua
        if (in_array($user->level, ['admin', 'kesiswaan', 'kepala_sekolah', 'bk'])) {
            return true;
        }

        // Guru biasa bisa akses semua (untuk input pelanggaran)
        if ($user->level == 'guru') {
            return true;
        }

        // Wali kelas hanya bisa akses siswa di kelasnya
        if ($user->level == 'wali_kelas') {
            $siswa = \App\Models\Siswa::find($siswaId);
            if ($siswa) {
                return self::isWaliKelasOf($siswa->kelas_id);
            }
        }

        return false;
    }
}