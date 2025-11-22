<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\JenisPrestasi;
use App\Models\KategoriPelanggaran;
use App\Models\JenisSanksi;

class AdditionalDummySeeder extends Seeder
{
    public function run()
    {
        // Jurusan dummy data
        for ($i = 1; $i <= 15; $i++) {
            Jurusan::firstOrCreate(
                ['singkatan' => 'JT' . $i],
                ['nama_jurusan' => 'Jurusan Test ' . $i]
            );
        }

        // Tahun Ajaran dummy data
        for ($i = 1; $i <= 12; $i++) {
            $year = 2020 + $i;
            TahunAjaran::firstOrCreate(
                ['kode_tahun' => $year . ($i % 2 == 0 ? '2' : '1')],
                [
                    'tahun_ajaran' => $year . '/' . ($year + 1),
                    'semester' => $i % 2 == 0 ? 'Genap' : 'Ganjil',
                    'status_aktif' => $i == 12,
                    'tanggal_mulai' => $year . '-01-01',
                    'tanggal_selesai' => ($year + 1) . '-12-31',
                ]
            );
        }

        // Jenis Prestasi dummy data
        $prestasi = [
            'Juara 1 Olimpiade Matematika',
            'Juara 2 Lomba Karya Tulis',
            'Juara 3 Kompetisi Sains',
            'Peserta Terbaik Debat',
            'Juara 1 Lomba Poster',
            'Juara 2 Festival Musik',
            'Juara 3 Lomba Tari',
            'Peserta Aktif Pramuka',
            'Juara 1 Lomba Fotografi',
            'Juara 2 Kompetisi Robotika',
            'Juara 3 Lomba Desain',
            'Peserta Terbaik Drama'
        ];

        foreach ($prestasi as $index => $nama) {
            JenisPrestasi::firstOrCreate(
                ['nama_prestasi' => $nama],
                [
                    'poin' => rand(10, 50),
                    'kategori' => ['akademik', 'non_akademik'][rand(0, 1)],
                    'reward' => 'Sertifikat dan Piagam',
                    'deskripsi' => 'Prestasi dalam bidang ' . strtolower($nama),
                ]
            );
        }

        // Kategori Pelanggaran dummy data
        $kategori = [
            'Terlambat Masuk Sekolah',
            'Tidak Mengerjakan Tugas',
            'Berpakaian Tidak Rapi',
            'Membawa HP ke Kelas',
            'Tidak Mengikuti Upacara',
            'Bolos Pelajaran',
            'Merokok di Area Sekolah',
            'Berkelahi dengan Teman',
            'Tidak Hormat pada Guru',
            'Merusak Fasilitas Sekolah',
            'Mencontek saat Ujian',
            'Membuat Keributan di Kelas'
        ];

        foreach ($kategori as $index => $nama) {
            KategoriPelanggaran::firstOrCreate(
                ['nama_kategori' => $nama],
                [
                    'kode_kategori' => 'KAT' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'kategori_induk' => ['KEPRIBADIAN', 'KERAJINAN', 'KERAPIAN'][rand(0, 2)],
                ]
            );
        }

        // Jenis Sanksi dummy data
        $sanksi = [
            'Teguran Lisan',
            'Teguran Tertulis',
            'Membersihkan Kelas',
            'Membersihkan Toilet',
            'Piket Sekolah 1 Minggu',
            'Tidak Boleh Ikut Ekstrakurikuler',
            'Panggil Orang Tua',
            'Skorsing 1 Hari',
            'Skorsing 3 Hari',
            'Skorsing 1 Minggu',
            'Pindah Kelas',
            'Dikeluarkan dari Sekolah'
        ];

        foreach ($sanksi as $index => $nama) {
            JenisSanksi::firstOrCreate(
                ['nama_sanksi' => $nama],
                [
                    'kategori' => $index < 4 ? 'RINGAN' : ($index < 8 ? 'SEDANG' : 'BERAT'),
                    'deskripsi' => 'Sanksi berupa ' . strtolower($nama),
                ]
            );
        }
    }
}