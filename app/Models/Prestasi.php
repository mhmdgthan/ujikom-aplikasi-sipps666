<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;
    
    protected $table = 'prestasi';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'siswa_id', 
        'jenis_prestasi_id', 
        'tahun_ajaran_id', 
        'poin', 
        'keterangan',
        'status_verifikasi',
        'tanggal_prestasi'
    ];

    protected $casts = [
        'tanggal_prestasi' => 'date',
        'created_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function guruPencatat()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat', 'id');
    }

    public function jenisPrestasi()
    {
        return $this->belongsTo(JenisPrestasi::class, 'jenis_prestasi_id', 'id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
}