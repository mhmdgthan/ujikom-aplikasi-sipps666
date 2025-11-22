<?php

namespace App\Models;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'level',
        'spesialisasi',
        'can_verify',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'can_verify' => 'boolean',
    ];

    public static function attemptLogin($username, $password)
    {
        $user = self::where('username', $username)->first();
        return ($user && Hash::check($password, $user->password)) ? $user : null;
    }

    // === Helper Role ===
    public function isAdmin()           { return $this->level === 'admin'; }
    public function isKepalaSekolah()  { return $this->level === 'kepala_sekolah'; }
    public function isKesiswaan()      { return $this->level === 'kesiswaan'; }
    public function isBK()             { return $this->level === 'bk'; }
    public function isGuru()           { return $this->level === 'guru'; } // ⭐ TAMBAH INI
    public function isWaliKelas()      { return $this->level === 'wali_kelas'; }
    public function isOrangTua()       { return $this->level === 'orang_tua'; }

    public function canVerify()
    {
        return (bool) $this->can_verify;
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id', 'id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'user_id', 'id');
    }
}