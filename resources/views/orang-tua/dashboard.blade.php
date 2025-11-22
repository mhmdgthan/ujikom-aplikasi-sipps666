@extends('layouts.orang-tua')

@section('title', 'Dashboard Orang Tua')
@section('page-title', 'Dashboard Orang Tua')

@push('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        border: 1px solid #e2e8f0;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
        flex-direction: column;
        text-align: center;
    }

    @media (min-width: 768px) {
        .profile-header {
            flex-direction: row;
            text-align: left;
            gap: 24px;
        }
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 32px;
        font-weight: 700;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .profile-avatar {
            width: 120px;
            height: 120px;
            font-size: 48px;
        }
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 4px;
    }

    @media (min-width: 768px) {
        .profile-name {
            font-size: 28px;
            margin-bottom: 8px;
        }
    }

    .profile-role {
        font-size: 14px;
        color: #718096;
        margin-bottom: 12px;
    }

    @media (min-width: 768px) {
        .profile-role {
            font-size: 16px;
            margin-bottom: 16px;
        }
    }

    .profile-badge {
        display: inline-block;
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    @media (min-width: 768px) {
        .profile-badge {
            padding: 6px 16px;
            font-size: 14px;
        }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 16px;
        border-radius: 12px;
        text-align: center;
    }

    @media (min-width: 768px) {
        .stat-card {
            padding: 20px;
        }
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 4px;
        display: block;
    }

    @media (min-width: 768px) {
        .stat-value {
            font-size: 32px;
            margin-bottom: 8px;
        }
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.9;
    }

    @media (min-width: 768px) {
        .stat-label {
            font-size: 14px;
        }
    }

    .children-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-top: 20px;
    }

    @media (min-width: 768px) {
        .children-grid {
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 24px;
        }
    }

    .child-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.2s;
    }

    @media (min-width: 768px) {
        .child-card {
            padding: 24px;
        }
    }

    .child-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .child-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    @media (min-width: 768px) {
        .child-header {
            gap: 16px;
            margin-bottom: 20px;
            padding-bottom: 16px;
        }
    }

    .child-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        flex-shrink: 0;
    }

    .child-avatar-placeholder {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #48bb78, #38a169);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        font-weight: 700;
        border: 3px solid #e2e8f0;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .child-avatar,
        .child-avatar-placeholder {
            width: 80px;
            height: 80px;
            font-size: 24px;
        }
    }

    .child-info {
        flex: 1;
    }

    .child-name {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 4px;
    }

    @media (min-width: 768px) {
        .child-name {
            font-size: 18px;
        }
    }

    .child-details {
        font-size: 12px;
        color: #718096;
        margin-bottom: 2px;
    }

    @media (min-width: 768px) {
        .child-details {
            font-size: 14px;
        }
    }

    .child-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 12px;
    }

    @media (min-width: 768px) {
        .child-stats {
            gap: 12px;
            margin-bottom: 16px;
        }
    }

    .child-stat {
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        transition: all 0.2s;
    }

    @media (min-width: 768px) {
        .child-stat {
            padding: 16px;
        }
    }

    .child-stat:hover {
        transform: translateY(-1px);
    }

    .child-stat.pelanggaran {
        background: #fed7d7;
        color: #742a2a;
        border: 1px solid #feb2b2;
    }

    .child-stat.prestasi {
        background: #c6f6d5;
        color: #22543d;
        border: 1px solid #9ae6b4;
    }

    .child-stat-value {
        font-size: 18px;
        font-weight: 700;
        display: block;
        margin-bottom: 4px;
    }

    @media (min-width: 768px) {
        .child-stat-value {
            font-size: 24px;
        }
    }

    .child-stat-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    @media (min-width: 768px) {
        .child-stat-label {
            font-size: 12px;
        }
    }

    .child-additional-info {
        background: #f7fafc;
        border-radius: 8px;
        padding: 12px;
        margin-top: 12px;
    }

    @media (min-width: 768px) {
        .child-additional-info {
            padding: 16px;
            margin-top: 16px;
        }
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px solid #edf2f7;
        font-size: 12px;
    }

    @media (min-width: 768px) {
        .info-row {
            padding: 8px 0;
            font-size: 13px;
        }
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #718096;
        font-weight: 500;
    }

    .info-value {
        color: #2d3748;
        font-weight: 600;
        text-align: right;
        max-width: 50%;
        word-break: break-word;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (min-width: 768px) {
        .section-title {
            font-size: 20px;
            gap: 12px;
            margin-bottom: 20px;
        }
    }

    .section-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .section-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
            border-radius: 10px;
        }
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
        grid-column: 1 / -1;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .empty-state-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #718096;
    }

    .empty-state-text {
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->nama_lengkap ?? 'O', 0, 1)) }}
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ $user->nama_lengkap ?? 'Orang Tua' }}</div>
                <div class="profile-role">Orang Tua/Wali</div>
                <div class="profile-badge">
                    <i class="fas fa-user-friends"></i>
                    Orang Tua
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-value">{{ $totalAnak ?? 0 }}</span>
                <span class="stat-label">Jumlah Anak</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $totalPelanggaran ?? 0 }}</span>
                <span class="stat-label">Total Pelanggaran</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $totalPrestasi ?? 0 }}</span>
                <span class="stat-label">Total Prestasi</span>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #e53e3e, #c53030);">
                <span class="stat-value">{{ $totalPoinPelanggaran ?? 0 }}</span>
                <span class="stat-label">Poin Pelanggaran</span>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #38a169, #2f855a);">
                <span class="stat-value">{{ $totalPoinPrestasi ?? 0 }}</span>
                <span class="stat-label">Poin Prestasi</span>
            </div>
        </div>

        <!-- Data Anak Section -->
        <div class="section-title">
            <div class="section-icon">
                <i class="fas fa-child"></i>
            </div>
            Data Anak
        </div>

        <div class="children-grid">
            @forelse($anak as $child)
            <div class="child-card">
                <div class="child-header">
                    @if($child->foto)
                        <img src="{{ $child->foto && str_starts_with($child->foto, 'siswa/') ? asset('storage/' . $child->foto) : asset('uploads/siswa/' . $child->foto) }}" 
                             alt="Foto {{ $child->user->nama_lengkap }}" 
                             class="child-avatar"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="child-avatar-placeholder" style="display: none;">
                            {{ strtoupper(substr($child->user->nama_lengkap ?? 'S', 0, 1)) }}
                        </div>
                    @else
                        <div class="child-avatar-placeholder">
                            {{ strtoupper(substr($child->user->nama_lengkap ?? 'S', 0, 1)) }}
                        </div>
                    @endif
                    <div class="child-info">
                        <div class="child-name">{{ $child->user->nama_lengkap ?? '-' }}</div>
                        <div class="child-details">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $child->kelas->nama_kelas ?? 'Belum ada kelas' }}
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="child-stats">
                    <div class="child-stat pelanggaran">
                        <span class="child-stat-value">{{ $child->pelanggaran->count() }}</span>
                        <span class="child-stat-label">Pelanggaran</span>
                    </div>
                    <div class="child-stat prestasi">
                        <span class="child-stat-value">{{ $child->prestasi->count() }}</span>
                        <span class="child-stat-label">Prestasi</span>
                    </div>
                </div>
                
                <!-- Poin -->
                <div class="child-stats">
                    <div class="child-stat pelanggaran">
                        <span class="child-stat-value">{{ $child->pelanggaran->sum('poin') }}</span>
                        <span class="child-stat-label">Poin Pelanggaran</span>
                    </div>
                    <div class="child-stat prestasi">
                        <span class="child-stat-value">{{ $child->prestasi->sum('poin') }}</span>
                        <span class="child-stat-label">Poin Prestasi</span>
                    </div>
                </div>

                <!-- Informasi Lengkap -->
                <div class="child-additional-info">
                    <div class="info-row">
                        <span class="info-label">NIS:</span>
                        <span class="info-value">{{ $child->nis ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NISN:</span>
                        <span class="info-value">{{ $child->nisn ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jenis Kelamin:</span>
                        <span class="info-value">
                            @if($child->jenis_kelamin == 'L')
                                Laki-laki
                            @elseif($child->jenis_kelamin == 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tempat Lahir:</span>
                        <span class="info-value">{{ $child->tempat_lahir ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Lahir:</span>
                        <span class="info-value">
                            @if($child->tanggal_lahir)
                                {{ \Carbon\Carbon::parse($child->tanggal_lahir)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Agama:</span>
                        <span class="info-value">{{ $child->agama ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <div class="empty-state-title">Belum Ada Data Anak</div>
                <div class="empty-state-text">Data anak belum tersedia atau belum terdaftar</div>
            </div>
            @endforelse
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

// Handle image loading errors
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.child-avatar');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('child-avatar-placeholder')) {
                placeholder.style.display = 'flex';
            }
        });
    });
});
</script>
@endpush