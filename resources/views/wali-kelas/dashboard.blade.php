@extends('layouts.wali-kelas')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Guru & Wali Kelas')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: currentColor;
        opacity: 0.05;
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .stat-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-card:nth-child(1) {
        color: #4299e1;
    }

    .stat-card:nth-child(1) .stat-card-icon {
        background: linear-gradient(135deg, #4299e1, #3182ce);
    }

    .stat-card:nth-child(2) {
        color: #48bb78;
    }

    .stat-card:nth-child(2) .stat-card-icon {
        background: linear-gradient(135deg, #48bb78, #38a169);
    }

    .stat-card:nth-child(3) {
        color: #ed8936;
    }

    .stat-card:nth-child(3) .stat-card-icon {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
    }

    .stat-card:nth-child(4) {
        color: #9f7aea;
    }

    .stat-card:nth-child(4) .stat-card-icon {
        background: linear-gradient(135deg, #9f7aea, #805ad5);
    }

    .stat-card-value {
        font-size: 36px;
        font-weight: 800;
        color: #2d3748;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-card-label {
        font-size: 13px;
        color: #718096;
        font-weight: 600;
    }

    .content-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .content-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .content-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .content-card-title i {
        color: #667eea;
    }

    .content-card-body {
        padding: 24px;
    }

    .kelas-info {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 24px;
        border-radius: 16px;
        margin-bottom: 28px;
        text-align: center;
    }

    .kelas-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .kelas-detail {
        font-size: 16px;
        opacity: 0.9;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        text-decoration: none;
        color: #4a5568;
        font-weight: 600;
        transition: all 0.2s;
    }

    .action-btn:hover {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
    }

    .action-btn i {
        font-size: 20px;
    }
</style>
@endpush

@section('content')
@php
    $user = auth()->user();
    $guru = \App\Models\Guru::where('user_id', $user->id)->first();
    $waliKelas = \App\Models\WaliKelas::where('guru_id', $user->id)
        ->whereNull('tanggal_selesai')
        ->with(['kelas.jurusan', 'tahunAjaran'])
        ->first();
    
    $totalSiswaKelas = 0;
    $totalPelanggaranKelas = 0;
    $totalPrestasiKelas = 0;
    
    if ($waliKelas) {
        $totalSiswaKelas = \App\Models\Siswa::where('kelas_id', $waliKelas->kelas_id)->count();
        $siswaIds = \App\Models\Siswa::where('kelas_id', $waliKelas->kelas_id)->pluck('id');
        $totalPelanggaranKelas = \App\Models\Pelanggaran::whereIn('siswa_id', $siswaIds)
            ->where('status_verifikasi', 'disetujui')->count();
        $totalPrestasiKelas = \App\Models\Prestasi::whereIn('siswa_id', $siswaIds)
            ->where('status_verifikasi', 'disetujui')->count();
    }
    
    $totalPelanggaranDicatat = \App\Models\Pelanggaran::where('guru_pencatat', $guru->id ?? 0)->count();
@endphp

@if($waliKelas)
<div class="kelas-info">
    <div class="kelas-title">{{ $waliKelas->kelas->nama_kelas ?? 'Kelas' }}</div>
    <div class="kelas-detail">
        {{ $waliKelas->kelas->jurusan->nama_jurusan ?? 'Jurusan' }} • 
        {{ $waliKelas->tahunAjaran->tahun_ajaran ?? 'Tahun Ajaran' }}
    </div>
</div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalSiswaKelas }}</div>
        <div class="stat-card-label">Siswa di Kelas</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalPelanggaranKelas }}</div>
        <div class="stat-card-label">Pelanggaran Kelas</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-trophy"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalPrestasiKelas }}</div>
        <div class="stat-card-label">Prestasi Kelas</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalPelanggaranDicatat }}</div>
        <div class="stat-card-label">Pelanggaran Dicatat</div>
    </div>
</div>

<div class="content-card">
    <div class="content-card-header">
        <div class="content-card-title">
            <i class="fas fa-bolt"></i>
            Aksi Cepat
        </div>
    </div>
    <div class="content-card-body">
        <div class="quick-actions">
            @if($waliKelas)
            <a href="{{ route('wali-kelas.data-siswa.index') }}" class="action-btn">
                <i class="fas fa-users"></i>
                <span>Lihat Data Siswa</span>
            </a>
            @endif
            
            <a href="{{ route('wali-kelas.data-diri.index') }}" class="action-btn">
                <i class="fas fa-user"></i>
                <span>Data Diri</span>
            </a>
            
            <a href="{{ route('guru.pelanggaran.index') }}" class="action-btn">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Input Pelanggaran</span>
            </a>
        </div>
    </div>
</div>

@if(!$waliKelas)
<div class="content-card">
    <div class="content-card-body" style="text-align: center; padding: 60px 24px;">
        <i class="fas fa-info-circle" style="font-size: 48px; color: #cbd5e0; margin-bottom: 16px;"></i>
        <h3 style="color: #2d3748; margin-bottom: 8px;">Anda Belum Ditugaskan Sebagai Wali Kelas</h3>
        <p style="color: #718096;">Hubungi admin untuk mendapatkan tugas sebagai wali kelas</p>
    </div>
</div>
@endif

@endsection