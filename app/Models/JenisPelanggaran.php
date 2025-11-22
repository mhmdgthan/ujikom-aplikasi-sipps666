<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    use HasFactory;
    protected $table = 'jenis_pelanggaran';

    protected $fillable = ['kategori_pelanggaran_id', 'nama_pelanggaran', 'poin', 'sanksi', 'keterangan', 'pasal'];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function kategoriPelanggaran()
    {
        return $this->belongsTo(KategoriPelanggaran::class, 'kategori_pelanggaran_id');
    }

    public function getKlasifikasiPelanggaran()
    {
        if ($this->poin >= 16) {
            return 'Berat (Pasal 10)';
        } elseif ($this->poin >= 6) {
            return 'Sedang (Pasal 9)';
        } elseif ($this->poin >= 1) {
            return 'Ringan (Pasal 8)';
        }
        
        return 'Tidak Terklasifikasi';
    }

    public function getSanksiDasar()
    {
        if ($this->poin >= 16) {
            return 'Skor 16-100 poin';
        } elseif ($this->poin >= 6) {
            return 'Skor 6-15 poin';
        } elseif ($this->poin >= 1) {
            return 'Skor 1-5 poin';
        }
        
        return 'Tidak ada sanksi';
    }
}
