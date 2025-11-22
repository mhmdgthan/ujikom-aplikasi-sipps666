@extends('layouts.wali-kelas')

@section('title', 'Data Diri')
@section('page-title', 'Data Diri Guru/Wali Kelas')

@push('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    @media (max-width: 768px) {
        .profile-card {
            padding: 20px;
        }
        
        .profile-header {
            flex-direction: column;
            text-align: center;
            gap: 16px;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            font-size: 32px;
        }
        
        .profile-name {
            font-size: 22px;
        }
        
        .profile-stats {
            justify-content: center;
            gap: 16px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .section-title {
            font-size: 18px;
        }
        
        .section-icon {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .profile-role {
        font-size: 16px;
        color: #718096;
        margin-bottom: 16px;
    }

    .profile-stats {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
        display: block;
    }

    .stat-label {
        font-size: 12px;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
    }

    .info-group {
        margin-bottom: 20px;
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .info-value {
        font-size: 16px;
        color: #2d3748;
        font-weight: 500;
        padding: 12px 16px;
        background: #f7fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .info-value.empty {
        color: #a0aec0;
        font-style: italic;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        margin-right: 8px;
    }

    .role-badge.guru {
        background: #bee3f8;
        color: #2c5282;
    }

    .role-badge.wali-kelas {
        background: #c6f6d5;
        color: #22543d;
    }
</style>
@endpush

@section('content')
<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(substr($guru->nama_guru ?? $user->nama_lengkap ?? 'G', 0, 1)) }}
        </div>
        <div class="profile-info">
            <div class="profile-name">{{ $guru->nama_guru ?? $user->nama_lengkap ?? 'Nama Lengkap' }}</div>
            <div class="profile-role">
                <span class="role-badge guru">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Guru
                </span>
                @if($waliKelas)
                <span class="role-badge wali-kelas">
                    <i class="fas fa-users"></i>
                    Wali Kelas {{ $waliKelas->kelas->nama_kelas ?? '' }}
                </span>
                @endif
            </div>
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $totalPelanggaran }}</span>
                    <span class="stat-label">Pelanggaran Dicatat</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $totalPrestasi }}</span>
                    <span class="stat-label">Prestasi Dicatat</span>
                </div>
                @if($waliKelas)
                <div class="stat-item">
                    <span class="stat-value">{{ $totalSiswaKelas }}</span>
                    <span class="stat-label">Siswa di Kelas</span>
                </div>
                @endif
                <div class="stat-item">
                    <span class="stat-value">{{ $pelanggaranBulanIni }}</span>
                    <span class="stat-label">Bulan Ini</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section-title">
        <div class="section-icon">
            <i class="fas fa-user"></i>
        </div>
        Informasi Personal
    </div>
    
    <div class="info-grid">
        <div class="info-group">
            <label class="info-label">Nama Lengkap</label>
            <div class="info-value {{ !($guru->nama_guru ?? $user->nama_lengkap) ? 'empty' : '' }}">
                {{ $guru->nama_guru ?? $user->nama_lengkap ?? 'Belum diisi' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">NIP</label>
            <div class="info-value {{ !$guru->nip ? 'empty' : '' }}">
                {{ $guru->nip ?? 'Belum diisi' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Jenis Kelamin</label>
            <div class="info-value {{ !$guru->jenis_kelamin ? 'empty' : '' }}">
                {{ $guru->jenis_kelamin ?? 'Belum diisi' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Bidang Studi</label>
            <div class="info-value {{ !$guru->bidang_studi ? 'empty' : '' }}">
                {{ $guru->bidang_studi ?? 'Belum diisi' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Email</label>
            <div class="info-value {{ !$guru->email ? 'empty' : '' }}">
                {{ $guru->email ?? 'Belum diisi' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">No. Telepon</label>
            <div class="info-value {{ !$guru->no_telp ? 'empty' : '' }}">
                {{ $guru->no_telp ?? 'Belum diisi' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Username</label>
            <div class="info-value">
                {{ $user->username }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Status</label>
            <div class="info-value">
                <span class="badge-success">
                    <i class="fas fa-check-circle"></i>
                    {{ $guru->status ?? 'Aktif' }}
                </span>
            </div>
        </div>
    </div>

    @if($waliKelas)
    <div class="section-title" style="margin-top: 32px;">
        <div class="section-icon">
            <i class="fas fa-users"></i>
        </div>
        Informasi Wali Kelas
    </div>
    
    <div class="info-grid">
        <div class="info-group">
            <label class="info-label">Kelas yang Diampu</label>
            <div class="info-value">
                {{ $waliKelas->kelas->nama_kelas ?? 'Tidak ada' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Jurusan</label>
            <div class="info-value">
                {{ $waliKelas->kelas->jurusan->nama_jurusan ?? 'Tidak ada' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Tahun Ajaran</label>
            <div class="info-value">
                {{ $waliKelas->tahunAjaran->tahun_ajaran ?? 'Tidak ada' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Tanggal Mulai</label>
            <div class="info-value">
                {{ $waliKelas->tanggal_mulai ? date('d F Y', strtotime($waliKelas->tanggal_mulai)) : 'Tidak ada' }}
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Jumlah Siswa</label>
            <div class="info-value">
                {{ $totalSiswaKelas }} Siswa
            </div>
        </div>
        
        <div class="info-group">
            <label class="info-label">Catatan</label>
            <div class="info-value {{ !$waliKelas->catatan ? 'empty' : '' }}">
                {{ $waliKelas->catatan ?? 'Tidak ada catatan' }}
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000,
    toast: true,
    position: 'top-end'
});
@endif
</script>
@endpush