<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $table = 'tahun_ajaran';
     public $timestamps = false;

    protected $fillable = [
        'kode_tahun', 'tahun_ajaran', 'semester', 'status_aktif',
        'tanggal_mulai', 'tanggal_selesai'
    ];

    // [PENTING] Tambahkan casting ini: Agar Laravel memperlakukan TINYINT(1) sebagai boolean
    protected $casts = [
        'status_aktif' => 'boolean', 
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }
}