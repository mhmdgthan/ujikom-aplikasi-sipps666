@extends('layouts.guru')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        border-left: 4px solid var(--primary);
        transition: all 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .stat-title {
        font-size: 14px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .stat-description {
        font-size: 13px;
        color: #a0aec0;
    }

    .welcome-card {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 12px;
        padding: 32px;
        color: white;
        margin-bottom: 32px;
        text-align: center;
    }

    .welcome-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .welcome-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 24px;
    }

    .quick-actions {
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .quick-action-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .quick-action-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .recent-activity {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .activity-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f7fafc;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: #f7fafc;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 16px;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-size: 14px;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .activity-time {
        font-size: 12px;
        color: #a0aec0;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #a0aec0;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<!-- Welcome Card -->
<div class="welcome-card">
    <div class="welcome-title">Selamat Datang, {{ auth()->user()->guru->nama_guru ?? auth()->user()->nama_lengkap }}</div>
    <div class="welcome-subtitle">Kelola pelanggaran siswa dan data diri Anda dengan mudah</div>
    <div class="quick-actions">
        <a href="{{ route('guru.pelanggaran.index') }}" class="quick-action-btn">
            <i class="fas fa-plus"></i>
            Input Pelanggaran
        </a>
        @if($waliKelas ?? false)
        <a href="{{ route('guru.siswa-kelas.index') }}" class="quick-action-btn">
            <i class="fas fa-users"></i>
            Data Siswa Kelas
        </a>
        @endif
        <a href="{{ route('guru.data-diri.index') }}" class="quick-action-btn">
            <i class="fas fa-user"></i>
            Lihat Profil
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Pelanggaran Diinput</div>
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        <div class="stat-value">{{ $totalPelanggaran }}</div>
        <div class="stat-description">Total pelanggaran yang Anda input</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Menunggu Verifikasi</div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-value">{{ $pelanggaranPending }}</div>
        <div class="stat-description">Pelanggaran belum diverifikasi</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Sudah Disetujui</div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-value">{{ $pelanggaranDisetujui }}</div>
        <div class="stat-description">Pelanggaran telah disetujui</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Bulan Ini</div>
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
        <div class="stat-value">{{ $pelanggaranBulanIni }}</div>
        <div class="stat-description">Pelanggaran input bulan ini</div>
    </div>

    @if($waliKelas ?? false)
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Siswa di Kelas</div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ \App\Models\Siswa::where('kelas_id', $waliKelas->kelas_id)->count() }}</div>
        <div class="stat-description">Total siswa {{ $waliKelas->kelas->nama_kelas }}</div>
    </div>
    @endif
</div>

<!-- Recent Activity -->
<div class="recent-activity">
    <div class="activity-header">
        <div class="activity-title">Aktivitas Terbaru</div>
        <a href="{{ route('guru.pelanggaran.index') }}" class="quick-action-btn" style="background: var(--light); color: var(--primary); font-size: 12px; padding: 8px 16px;">
            <i class="fas fa-eye"></i>
            Lihat Semua
        </a>
    </div>

    @forelse($recentPelanggaran as $item)
    <div class="activity-item">
        <div class="activity-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="activity-content">
            <div class="activity-text">
                Input pelanggaran <strong>{{ $item->siswa?->user->nama_lengkap ?? '-' }}</strong> - {{ $item->jenisPelanggaran?->nama_pelanggaran ?? '-' }}
            </div>
            <div class="activity-time">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
        </div>
        <div class="badge-status {{ strtolower($item->status_verifikasi) }}" style="padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">
            @if($item->status_verifikasi == 'pending')
                <span style="background: #feebc8; color: #7c2d12;">Pending</span>
            @elseif($item->status_verifikasi == 'disetujui')
                <span style="background: #c6f6d5; color: #22543d;">Disetujui</span>
            @else
                <span style="background: #fed7d7; color: #742a2a;">Ditolak</span>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-clipboard-list"></i>
        <div>Belum ada aktivitas pelanggaran</div>
    </div>
    @endforelse
</div>
@endsection