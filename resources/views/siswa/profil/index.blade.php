@extends('layouts.siswa')

@section('title', 'Profil Siswa')
@section('page-title', 'Profil Saya')

@push('styles')
<style>
    .content-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 16px;
    }

    @media (min-width: 768px) {
        .content-wrapper {
            padding: 24px;
        }
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    @media (min-width: 768px) {
        .profile-card {
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 24px;
        border-bottom: 2px solid #f1f5f9;
        flex-direction: column;
        text-align: center;
    }

    @media (min-width: 768px) {
        .profile-header {
            flex-direction: row;
            text-align: left;
            gap: 32px;
            margin-bottom: 40px;
        }
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
        border: 4px solid #667eea;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        flex-shrink: 0;
    }

    .profile-avatar-placeholder {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 40px;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        border: 4px solid #667eea;
    }

    @media (min-width: 768px) {
        .profile-avatar,
        .profile-avatar-placeholder {
            width: 150px;
            height: 150px;
            font-size: 60px;
            border-width: 6px;
        }
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 24px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    @media (min-width: 768px) {
        .profile-name {
            font-size: 32px;
        }
    }

    .profile-nis {
        font-size: 16px;
        color: #718096;
        margin-bottom: 16px;
    }

    @media (min-width: 768px) {
        .profile-nis {
            font-size: 18px;
        }
    }

    .profile-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }

    @media (min-width: 768px) {
        .profile-badges {
            justify-content: flex-start;
            gap: 12px;
        }
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    @media (min-width: 768px) {
        .profile-badge {
            padding: 8px 16px;
            font-size: 14px;
            gap: 8px;
        }
    }

    .profile-badge.secondary {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (min-width: 768px) {
        .section-title {
            font-size: 24px;
            gap: 12px;
            margin-bottom: 24px;
        }
    }

    .section-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .section-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
            border-radius: 12px;
        }
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }

    @media (min-width: 768px) {
        .info-grid {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }
    }

    .info-group {
        background: #f8fafc;
        padding: 16px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    @media (min-width: 768px) {
        .info-group {
            padding: 20px;
            border-radius: 12px;
        }
    }

    .info-group:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-size: 11px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: block;
    }

    @media (min-width: 768px) {
        .info-label {
            font-size: 12px;
            margin-bottom: 8px;
        }
    }

    .info-value {
        font-size: 14px;
        color: #2d3748;
        font-weight: 600;
        word-break: break-word;
    }

    @media (min-width: 768px) {
        .info-value {
            font-size: 16px;
        }
    }

    .info-value.empty {
        color: #a0aec0;
        font-style: italic;
        font-weight: 400;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="profile-card">
        <div class="profile-header">
            @if($siswa->foto)
                <img src="{{ $siswa->foto && str_starts_with($siswa->foto, 'siswa/') ? asset('storage/' . $siswa->foto) : asset('uploads/siswa/' . $siswa->foto) }}" 
                     class="profile-avatar" 
                     alt="Foto Siswa"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="profile-avatar-placeholder" style="display: none;">
                    {{ strtoupper(substr($siswa->user->nama_lengkap ?? 'S', 0, 1)) }}
                </div>
            @else
                <div class="profile-avatar-placeholder">
                    {{ strtoupper(substr($siswa->user->nama_lengkap ?? 'S', 0, 1)) }}
                </div>
            @endif
            <div class="profile-info">
                <div class="profile-name">{{ $siswa->user->nama_lengkap ?? 'Siswa' }}</div>
                <div class="profile-nis">{{ $siswa->nis ? 'NIS: ' . $siswa->nis : 'Siswa' }}</div>
                <div class="profile-badges">
                    <div class="profile-badge">
                        <i class="fas fa-graduation-cap"></i>
                        {{ $siswa->kelas->nama_kelas ?? 'Kelas' }}
                    </div>
                    <div class="profile-badge secondary">
                        <i class="fas fa-user-graduate"></i>
                        Siswa Aktif
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
                <div class="info-value {{ !$siswa->user->nama_lengkap ? 'empty' : '' }}">
                    {{ $siswa->user->nama_lengkap ?? 'Belum diisi' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">NIS / NISN</label>
                <div class="info-value {{ !$siswa->nis && !$siswa->nisn ? 'empty' : '' }}">
                    {{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Kelas</label>
                <div class="info-value {{ !$siswa->kelas ? 'empty' : '' }}">
                    {{ $siswa->kelas->nama_kelas ?? 'Belum diisi' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Tempat, Tanggal Lahir</label>
                <div class="info-value {{ !$siswa->tempat_lahir && !$siswa->tanggal_lahir ? 'empty' : '' }}">
                    {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Jenis Kelamin</label>
                <div class="info-value">
                    {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Agama</label>
                <div class="info-value {{ !$siswa->agama ? 'empty' : '' }}">
                    {{ $siswa->agama ?? 'Belum diisi' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Alamat</label>
                <div class="info-value {{ !$siswa->alamat ? 'empty' : '' }}">
                    {{ $siswa->alamat ?? 'Belum diisi' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">No. Telepon</label>
                <div class="info-value {{ !$siswa->no_telepon ? 'empty' : '' }}">
                    {{ $siswa->no_telepon ?? 'Belum diisi' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Handle image loading errors
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.profile-avatar');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('profile-avatar-placeholder')) {
                placeholder.style.display = 'flex';
            }
        });
    });
});
</script>
@endpush