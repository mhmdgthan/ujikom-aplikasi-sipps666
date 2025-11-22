<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pelanggaran';
    
    protected $fillable = [
        'nama_kategori',
        'kode_kategori',
        'kategori_induk'
    ];

    public function jenisPelanggaran()
    {
        return $this->hasMany(JenisPelanggaran::class, 'kategori_pelanggaran_id');
    }
}