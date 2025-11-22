<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_telepon',
        'kelas_id',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'siswa_id');
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'siswa_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'siswa_id');
    }

    public function kesiswaan()
    {
        return $this->hasOne(Kesiswaan::class, 'siswa_id');
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class, 'siswa_id');
    }
    
    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    public function scopeLakiLaki($query)
    {
        return $query->where('jenis_kelamin', 'L');
    }

    public function scopePerempuan($query)
    {
        return $query->where('jenis_kelamin', 'P');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->whereHas('user', function($userQuery) use ($keyword) {
            $userQuery->where('nama_lengkap', 'like', "%{$keyword}%");
        })
        ->orWhere('nis', 'like', "%{$keyword}%")
        ->orWhere('nisn', 'like', "%{$keyword}%");
    }
    
    public function getTotalPoinPelanggaran($tahunAjaranId = null)
    {
        $query = $this->pelanggaran()
            ->where('status_verifikasi', 'disetujui');
        
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }
        
        return $query->sum('poin');
    }

    public function getTotalPoinPrestasi($tahunAjaranId = null)
    {
        $query = $this->prestasi()
            ->where('status_verifikasi', 'disetujui');
        
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }
        
        return $query->sum('poin');
    }

    public function getPoinBersih($tahunAjaranId = null)
    {
        return $this->getTotalPoinPelanggaran($tahunAjaranId) - $this->getTotalPoinPrestasi($tahunAjaranId);
    }

    public function getUmur()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    public function needsKonseling($tahunAjaranId = null)
    {
        return $this->getTotalPoinPelanggaran($tahunAjaranId) >= 75;
    }

    public function getKategoriRisiko($tahunAjaranId = null)
    {
        $poin = $this->getTotalPoinPelanggaran($tahunAjaranId);
        
        if ($poin >= 90) return 'Sangat Tinggi';
        if ($poin >= 41) return 'Tinggi';
        if ($poin >= 16) return 'Sedang';
        if ($poin >= 6) return 'Rendah';
        return 'Aman';
    }

    public function getKategoriRisikoBadge($tahunAjaranId = null)
    {
        $kategori = $this->getKategoriRisiko($tahunAjaranId);
        
        return [
            'Sangat Tinggi' => 'badge-danger',
            'Tinggi' => 'badge-warning',
            'Sedang' => 'badge-info',
            'Rendah' => 'badge-secondary',
            'Aman' => 'badge-success',
        ][$kategori] ?? 'badge-secondary';
    }

    public function getSanksiOtomatis($tahunAjaranId = null)
    {
        $totalPoin = $this->getTotalPoinPelanggaran($tahunAjaranId);
        
        if ($totalPoin >= 90) {
            return 'Dikembalikan ke orang tua (keluar dari SMK Bakti Nusantara 666)';
        } elseif ($totalPoin >= 41) {
            return 'Dibina orang tua selama 1 bulan';
        } elseif ($totalPoin >= 36) {
            return 'Diserahkan ke orang tua untuk dibina dalam jangka waktu dua minggu';
        } elseif ($totalPoin >= 31) {
            return 'Diskors 7 hari';
        } elseif ($totalPoin >= 26) {
            return 'Diskors 3 hari';
        } elseif ($totalPoin >= 21) {
            return 'Perjanjian orang tua + diatas materai';
        } elseif ($totalPoin >= 16) {
            return 'Panggilan orang tua + perjanjian siswa diatas materai';
        } elseif ($totalPoin >= 11) {
            return 'Peringatan tertulis dengan perjanjian';
        } elseif ($totalPoin >= 6) {
            return 'Peringatan lisan';
        } elseif ($totalPoin >= 1) {
            return 'Dicatat dan konseling';
        }
        
        return 'Tidak ada sanksi';
    }

    public function getKategoriSanksi($tahunAjaranId = null)
    {
        $totalPoin = $this->getTotalPoinPelanggaran($tahunAjaranId);
        
        if ($totalPoin >= 16) {
            return 'Berat';
        } elseif ($totalPoin >= 6) {
            return 'Sedang';
        } elseif ($totalPoin >= 1) {
            return 'Ringan';
        }
        
        return 'Tidak ada';
    }
}