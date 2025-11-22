<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'monitoring_pelanggaran';

    protected $fillable = [
        'pelanggaran_id', 'kepala_sekolah_id', 'status_monitoring',
        'catatan_monitoring', 'tanggal_monitoring', 'tindak_lanjut', 'hasil'
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }

    public function kepalaSekolah()
    {
        return $this->belongsTo(User::class, 'kepala_sekolah_id');
    }
}
