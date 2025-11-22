<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    protected $table = 'sanksi';
    
    protected $fillable = [
        'pelanggaran_id',
        'jenis_sanksi',
        'deskripsi_sanksi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }
    
    public function pelaksanaanSanksi()
    {
        return $this->hasOne(PelaksanaanSanksi::class, 'sanksi_id');
    }
    
    // Relasi langsung ke siswa melalui pelanggaran
    public function siswa()
    {
        return $this->hasOneThrough(Siswa::class, Pelanggaran::class, 'id', 'id', 'pelanggaran_id', 'siswa_id');
    }

}