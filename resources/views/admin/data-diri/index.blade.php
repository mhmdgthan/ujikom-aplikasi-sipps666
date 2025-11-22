@extends('layouts.main')

@section('title', 'Data Diri Admin')
@section('page-title', 'Data Diri Admin')

@push('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
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

    .profile-badge {
        display: inline-block;
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
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
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .stat-card {
            padding: 16px;
        }
        
        .stat-value {
            font-size: 24px;
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

    .stat-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
        display: block;
    }

    .stat-label {
        font-size: 14px;
        opacity: 0.9;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->nama_lengkap ?? 'A', 0, 1)) }}
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ $user->nama_lengkap ?? 'Administrator' }}</div>
                <div class="profile-role">System Administrator</div>
                <div class="profile-badge">
                    <i class="fas fa-shield-alt"></i>
                    Super Admin
                </div>
            </div>
        </div>

        <!-- Informasi Statistik (Opsional) -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-value">1</span>
                <span class="stat-label">Akun Admin</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">Full</span>
                <span class="stat-label">Akses Sistem</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">24/7</span>
                <span class="stat-label">Dukungan</span>
            </div>
        </div>

        <div class="section-title">
            <div class="section-icon">
                <i class="fas fa-user-cog"></i>
            </div>
            Informasi Administrator
        </div>
        
        <div class="info-grid">
            <div class="info-group">
                <label class="info-label">Nama Lengkap</label>
                <div class="info-value {{ !$user->nama_lengkap ? 'empty' : '' }}">
                    {{ $user->nama_lengkap ?? 'Belum diisi' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Username</label>
                <div class="info-value {{ !$user->username ? 'empty' : '' }}">
                    {{ $user->username ?? 'Belum diisi' }}
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Level Akses</label>
                <div class="info-value">
                    <span style="color: #667eea; font-weight: 600;">
                        <i class="fas fa-shield-alt"></i>
                        {{ ucfirst($user->level) }}
                    </span>
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Status Akun</label>
                <div class="info-value">
                    <span style="color: #48bb78; font-weight: 600;">
                        <i class="fas fa-check-circle"></i>
                        Aktif
                    </span>
                </div>
            </div>
            
            <div class="info-group">
                <label class="info-label">Bergabung Sejak</label>
                <div class="info-value">
                    @php
                        $createdAt = $user->created_at;
                        if ($createdAt) {
                            if (is_string($createdAt)) {
                                $formattedDate = \Carbon\Carbon::parse($createdAt)->format('d F Y');
                            } else {
                                $formattedDate = $createdAt->format('d F Y');
                            }
                        } else {
                            $formattedDate = 'Tidak diketahui';
                        }
                    @endphp
                    {{ $formattedDate }}
                </div>
            </div>
        </div>
    </div>
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

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    confirmButtonColor: '#e53e3e',
});
@endif
</script>
@endpush