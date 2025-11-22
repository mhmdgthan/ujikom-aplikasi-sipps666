<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\VerifikasiData;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Sanksi;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class VerifikasiDataController extends Controller
{
    public function index()
    {
        $verifikasi = VerifikasiData::with(['userVerifikator'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Load related data
        foreach ($verifikasi as $item) {
            if ($item->tabel_terkait == 'pelanggaran') {
                $item->data_terkait = Pelanggaran::with(['siswa.user', 'jenisPelanggaran'])->find($item->id_terkait);
            } elseif ($item->tabel_terkait == 'prestasi') {
                $item->data_terkait = Prestasi::with(['siswa.user', 'jenisPrestasi'])->find($item->id_terkait);
            } elseif ($item->tabel_terkait == 'sanksi') {
                $item->data_terkait = Sanksi::with(['siswa.user', 'jenisSanksi'])->find($item->id_terkait);
            }
        }

        return view('kesiswaan.verifikasi-data.index', compact('verifikasi'));
    }

    public function approve($id)
    {
        $verifikasi = VerifikasiData::findOrFail($id);
        
        // Update status di tabel terkait
        if ($verifikasi->tabel_terkait == 'pelanggaran') {
            $pelanggaran = Pelanggaran::find($verifikasi->id_terkait);
            $pelanggaran->update(['status_verifikasi' => 'disetujui']);
            
            // Send notifications - disabled
            // NotificationService::notifyPelanggaranApproved($pelanggaran);
            // NotificationService::notifyOrangTuaPelanggaran($pelanggaran);
        } elseif ($verifikasi->tabel_terkait == 'prestasi') {
            Prestasi::where('id', $verifikasi->id_terkait)->update(['status_verifikasi' => 'disetujui']);
        } elseif ($verifikasi->tabel_terkait == 'sanksi') {
            Sanksi::where('id', $verifikasi->id_terkait)->update(['status_verifikasi' => 'disetujui']);
        }

        // Delete verifikasi data after approval
        $verifikasi->delete();

        return redirect()->back()->with('success', 'Data berhasil disetujui');
    }

    public function reject($id)
    {
        $verifikasi = VerifikasiData::findOrFail($id);
        
        // Update status di tabel terkait
        if ($verifikasi->tabel_terkait == 'pelanggaran') {
            Pelanggaran::where('id', $verifikasi->id_terkait)->update(['status_verifikasi' => 'ditolak']);
        } elseif ($verifikasi->tabel_terkait == 'prestasi') {
            Prestasi::where('id', $verifikasi->id_terkait)->update(['status_verifikasi' => 'ditolak']);
        } elseif ($verifikasi->tabel_terkait == 'sanksi') {
            Sanksi::where('id', $verifikasi->id_terkait)->update(['status_verifikasi' => 'ditolak']);
        }

        // Delete verifikasi data after rejection
        $verifikasi->delete();

        return redirect()->back()->with('success', 'Data berhasil ditolak');
    }
    
    public function detail($id)
    {
        $pelanggaran = Pelanggaran::with([
            'siswa.user',
            'siswa.kelas',
            'jenisPelanggaran.kategoriPelanggaran',
            'tahunAjaran',
            'guruPencatat.user',
            'guruVerifikator.user'
        ])->findOrFail($id);
        
        $response = $pelanggaran->toArray();
        
        if ($pelanggaran->guruPencatat) {
            $namaPencatat = $pelanggaran->guruPencatat->nama_guru ?? ($pelanggaran->guruPencatat->user ? $pelanggaran->guruPencatat->user->nama_lengkap : null);
            $response['guru_pencatat_nama'] = $namaPencatat ?? 'Tidak diketahui';
        } else {
            $response['guru_pencatat_nama'] = 'Tidak diketahui';
        }
        
        if ($pelanggaran->guruVerifikator) {
            $namaVerifikator = $pelanggaran->guruVerifikator->nama_guru ?? ($pelanggaran->guruVerifikator->user ? $pelanggaran->guruVerifikator->user->nama_lengkap : null);
            $response['guru_verifikator_nama'] = $namaVerifikator ?? 'Belum diverifikasi';
        } else {
            $response['guru_verifikator_nama'] = 'Belum diverifikasi';
        }
        
        if ($pelanggaran->jenisPelanggaran) {
            $kategori = $pelanggaran->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'Tidak diketahui';
            $response['kategori_poin'] = $kategori . ' (-' . $pelanggaran->poin . ' poin)';
        } else {
            $response['kategori_poin'] = 'Tidak diketahui';
        }
        
        return response()->json($response);
    }
    
    public function destroy($id)
    {
        $verifikasi = VerifikasiData::findOrFail($id);
        
        // Hapus data terkait berdasarkan tabel
        if ($verifikasi->tabel_terkait == 'pelanggaran') {
            Pelanggaran::where('id', $verifikasi->id_terkait)->delete();
        } elseif ($verifikasi->tabel_terkait == 'prestasi') {
            Prestasi::where('id', $verifikasi->id_terkait)->delete();
        } elseif ($verifikasi->tabel_terkait == 'sanksi') {
            Sanksi::where('id', $verifikasi->id_terkait)->delete();
        }
        
        // Hapus data verifikasi
        $verifikasi->delete();
        
        return redirect()->back()->with('success', 'Data verifikasi dan data terkait berhasil dihapus');
    }
}