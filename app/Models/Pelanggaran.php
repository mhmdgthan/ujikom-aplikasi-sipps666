<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;
    
    // Pastikan nama tabel benar
    protected $table = 'pelanggaran';

    // Mendefinisikan Primary Key sesuai ERD
    protected $primaryKey = 'id';
     public $timestamps = false;

    // Kolom-kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'siswa_id', 
        'jenis_pelanggaran_id', 
        'tahun_ajaran_id', 
        'poin', 
        'keterangan',
        'deskripsi',
        'bukti_foto', 
        'guru_pencatat', 
        'guru_verifikator', 
        'status_verifikasi', 
        'catatan_verifikasi', 
        'tanggal' 
    ];

    // Cast attributes to proper types
    protected $casts = [
        'tanggal' => 'date',
    ];



    /**
     * Relasi ke model Siswa (Satu Pelanggaran dimiliki satu Siswa)
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    /**
     * Relasi ke Guru Pencatat (Satu Pelanggaran dicatat oleh satu Guru)
     */
    public function guruPencatat()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat', 'id');
    }

    /**
     * Relasi ke Guru Verifikator (Satu Pelanggaran diverifikasi oleh satu Guru)
     */
    public function guruVerifikator()
    {
        return $this->belongsTo(Guru::class, 'guru_verifikator', 'id');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'jenis_pelanggaran_id', 'id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }

    public function monitoring()
    {
        // Asumsi model MonitoringPelanggaran ada
        return $this->hasOne(MonitoringPelanggaran::class, 'pelanggaran_id', 'id');
    }
    
    /**
     * Relasi ke Sanksi (Satu Pelanggaran bisa memiliki BANYAK Sanksi)
     */
    public function sanksi()
    {
        // 'pelanggaran_id' adalah foreign key di tabel sanksi
        return $this->hasMany(Sanksi::class, 'pelanggaran_id', 'id');
    }
}