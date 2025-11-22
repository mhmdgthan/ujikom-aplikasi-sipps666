<?php

namespace App\Services;

use App\Models\Siswa;
use App\Models\Sanksi;
use App\Models\PelaksanaanSanksi;

class SanksiService
{
    public static function assignSanksiOtomatis($siswaId, $tahunAjaranId = null)
    {
        $siswa = Siswa::find($siswaId);
        if (!$siswa) return false;

        $totalPoin = $siswa->getTotalPoinPelanggaran($tahunAjaranId);
        $sanksiText = $siswa->getSanksiOtomatis($tahunAjaranId);
        
        if ($sanksiText === 'Tidak ada sanksi') {
            return false;
        }

        // Check if sanksi already exists
        $existingSanksi = Sanksi::where('nama_sanksi', $sanksiText)->first();
        
        if (!$existingSanksi) {
            $existingSanksi = Sanksi::create([
                'nama_sanksi' => $sanksiText,
                'deskripsi' => "Sanksi otomatis berdasarkan akumulasi poin pelanggaran: {$totalPoin} poin",
                'kategori' => $siswa->getKategoriSanksi($tahunAjaranId)
            ]);
        }

        // Create pelaksanaan sanksi if not exists
        $existingPelaksanaan = PelaksanaanSanksi::where('siswa_id', $siswaId)
            ->where('sanksi_id', $existingSanksi->id)
            ->where('status', '!=', 'selesai')
            ->first();

        if (!$existingPelaksanaan) {
            PelaksanaanSanksi::create([
                'siswa_id' => $siswaId,
                'sanksi_id' => $existingSanksi->id,
                'tanggal_mulai' => now(),
                'status' => 'aktif',
                'keterangan' => "Sanksi otomatis berdasarkan {$totalPoin} poin pelanggaran"
            ]);
        }

        return true;
    }
}