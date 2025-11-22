<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;
     protected $table = 'orangtua';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'siswa_id', 'hubungan', 'pekerjaan', 'alamat'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
