<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $table = 'kelas';
    public $timestamps = false;

    protected $fillable = [
        'tingkat_kelas', 
        'jurusan_id', 
        'kapasitas'
    ];
    
    protected $appends = ['nama_kelas'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    // Relasi ke WaliKelas melalui tabel wali_kelas
    public function waliKelas()
    {
        return $this->hasOne(WaliKelas::class, 'kelas_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function getNamaKelasAttribute()
    {
        return $this->tingkat_kelas . ' ' . ($this->jurusan ? $this->jurusan->singkatan : '');
    }
}