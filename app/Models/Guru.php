<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'bidang_studi',
        'email',
        'no_telp',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // Relasi ke WaliKelas (guru bisa jadi wali kelas)
    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class, 'guru_id', 'user_id');
    }
}