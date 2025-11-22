<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    use HasFactory;
    protected $table = 'bimbingan_konseling';
        public $timestamps = false;

    protected $fillable = [
        'siswa_id', 'tahun_ajaran_id', 'user_id', 'jenis_layanan', 'topik',
        'keluhan_masalah', 'tindakan_solusi', 'status',
        'tanggal_konseling', 'tanggal_tindak_lanjut', 'hasil_evaluasi'
    ];

    protected $casts = [
        'tanggal_konseling' => 'date',
        'tanggal_tindak_lanjut' => 'date',
        'created_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function konselor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
