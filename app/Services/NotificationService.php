<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    // Notifikasi untuk Admin/Kesiswaan: Ada pelanggaran baru dari guru/wali kelas
    public static function notifyNewPelanggaran($pelanggaran)
    {
        $siswa = $pelanggaran->siswa;
        $jenisPelanggaran = $pelanggaran->jenisPelanggaran;
        
        // Notifikasi untuk Admin dan Kesiswaan
        $adminKesiswaanUsers = User::whereIn('level', ['admin', 'kesiswaan'])->get();
        
        foreach ($adminKesiswaanUsers as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pelanggaran Baru Perlu Verifikasi',
                'message' => "Siswa {$siswa->user->nama_lengkap} melakukan {$jenisPelanggaran->nama_pelanggaran}",
                'type' => 'pelanggaran_baru',
                'data' => [
                    'pelanggaran_id' => $pelanggaran->id,
                    'siswa_nama' => $siswa->user->nama_lengkap,
                    'jenis_pelanggaran' => $jenisPelanggaran->nama_pelanggaran
                ]
            ]);
        }
    }
    
    // Notifikasi untuk Guru/Wali Kelas: Input berhasil disetujui
    public static function notifyPelanggaranApproved($pelanggaran)
    {
        $guruUser = User::find($pelanggaran->guru_pencatat);
        
        if ($guruUser) {
            Notification::create([
                'user_id' => $guruUser->id,
                'title' => 'Input Pelanggaran Disetujui',
                'message' => "Pelanggaran siswa {$pelanggaran->siswa->user->nama_lengkap} telah disetujui",
                'type' => 'pelanggaran_approved',
                'data' => [
                    'pelanggaran_id' => $pelanggaran->id,
                    'siswa_nama' => $pelanggaran->siswa->user->nama_lengkap
                ]
            ]);
        }
    }
    
    // Notifikasi untuk Orang Tua: Anak melakukan pelanggaran
    public static function notifyOrangTuaPelanggaran($pelanggaran)
    {
        $siswa = $pelanggaran->siswa;
        $orangTua = $siswa->orangTua;
        
        if ($orangTua && $orangTua->user) {
            Notification::create([
                'user_id' => $orangTua->user->id,
                'title' => 'Anak Anda Melakukan Pelanggaran',
                'message' => "{$siswa->user->nama_lengkap} melakukan {$pelanggaran->jenisPelanggaran->nama_pelanggaran}",
                'type' => 'anak_pelanggaran',
                'data' => [
                    'pelanggaran_id' => $pelanggaran->id,
                    'siswa_nama' => $siswa->user->nama_lengkap,
                    'jenis_pelanggaran' => $pelanggaran->jenisPelanggaran->nama_pelanggaran
                ]
            ]);
        }
    }
    
    // Get unread notifications count for user
    public static function getUnreadCount($userId)
    {
        return Notification::forUser($userId)->unread()->count();
    }
    
    // Get recent notifications for user
    public static function getRecentNotifications($userId, $limit = 5)
    {
        return Notification::forUser($userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}