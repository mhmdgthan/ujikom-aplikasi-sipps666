<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiData extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_data';

    protected $fillable = [
        'tabel_terkait',
        'id_terkait',
        'user_verifikator',
        'status'
    ];

    public function userVerifikator()
    {
        return $this->belongsTo(User::class, 'user_verifikator');
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'id_terkait')->where('tabel_terkait', 'pelanggaran');
    }

    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'id_terkait')->where('tabel_terkait', 'prestasi');
    }

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class, 'id_terkait')->where('tabel_terkait', 'sanksi');
    }
}