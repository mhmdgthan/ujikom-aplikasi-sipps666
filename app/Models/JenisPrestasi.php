<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPrestasi extends Model
{
    use HasFactory;
    protected $table = 'jenis_prestasi';
    public $timestamps = false;

    protected $fillable = ['nama_prestasi', 'poin', 'kategori', 'reward', 'deskripsi'];

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }
}
