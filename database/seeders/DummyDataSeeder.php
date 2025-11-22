<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\WaliKelas;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // Create dummy users for testing pagination
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'username' => 'user' . $i,
                'password' => Hash::make('password'),
                'nama_lengkap' => 'User Test ' . $i,
                'level' => 'guru',
                'can_verify' => 0,
                'is_active' => 1,
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'username' => 'siswa' . $i,
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Siswa Test ' . $i,
                'level' => 'siswa',
                'can_verify' => 0,
                'is_active' => 1,
            ]);
        }

        // Create dummy guru
        $users = User::where('level', 'guru')->get();
        foreach ($users as $index => $user) {
            Guru::create([
                'user_id' => $user->id,
                'nip' => '123456789' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'nama_guru' => $user->nama_lengkap,
                'jenis_kelamin' => $index % 2 == 0 ? 'Laki-laki' : 'Perempuan',
                'bidang_studi' => 'Matematika',
                'email' => 'guru' . ($index + 1) . '@test.com',
                'no_telp' => '08123456789' . $index,
                'status' => 'Aktif',
            ]);
        }

        // Create dummy siswa
        $siswaUsers = User::where('level', 'siswa')->get();
        $kelasIds = Kelas::pluck('id')->toArray();
        
        if (!empty($kelasIds)) {
            foreach ($siswaUsers as $index => $user) {
                Siswa::create([
                    'user_id' => $user->id,
                    'nis' => '2024' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'nisn' => '1234567890' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2005-01-01',
                    'jenis_kelamin' => $index % 2 == 0 ? 'L' : 'P',
                    'agama' => 'Islam',
                    'alamat' => 'Jl. Test No. ' . ($index + 1),
                    'no_telepon' => '08123456789' . $index,
                    'kelas_id' => $kelasIds[array_rand($kelasIds)],
                ]);
            }
        }
    }
}