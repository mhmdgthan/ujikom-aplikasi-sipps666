<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSanksi extends Model
{
    protected $table = 'jenis_sanksi';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_sanksi',
        'kategori',
        'deskripsi'
    ];
    
    protected $casts = [
        'created_at' => 'datetime'
    ];
    
    // Relasi ke tabel sanksi (jika ada)
    // public function sanksi()
    // {
    //     return $this->hasMany(Sanksi::class, 'jenis_sanksi', 'id');
    // }
}

