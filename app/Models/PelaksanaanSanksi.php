<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelaksanaanSanksi extends Model
{
    protected $table = 'pelaksanaan_sanksi';
    public $timestamps = false;
    
    protected $fillable = [
        'sanksi_id',
        'tanggal_pelaksanaan',
        'bukti_pelaksanaan',
        'catatan',
        'status'
    ];
    
    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'created_at' => 'datetime'
    ];
    
    // Relasi ke tabel sanksi
    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class, 'sanksi_id');
    }
}