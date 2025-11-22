<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;

    protected $table = 'wali_kelas';
    public $timestamps = false;

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'tahun_ajaran_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan',
    ];

    public function guru() 
    {
        return $this->belongsTo(User::class, 'guru_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
