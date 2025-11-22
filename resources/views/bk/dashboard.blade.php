@extends('layouts.bk')

@section('title', 'Dashboard BK')
@section('page-title', 'Dashboard Bimbingan Konseling')

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

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
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
    $totalKonseling = \App\Models\BimbinganKonseling::count();
    $konselingBulanIni = \App\Models\BimbinganKonseling::whereMonth('tanggal_konseling', now()->month)
        ->whereYear('tanggal_konseling', now()->year)->count();
    $konselingSelesai = \App\Models\BimbinganKonseling::where('status', 'Selesai')->count();
    $konselingBerlangsung = \App\Models\BimbinganKonseling::where('status', '!=', 'Selesai')->count();
@endphp

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-comments"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalKonseling }}</div>
        <div class="stat-card-label">Total Konseling</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $konselingBulanIni }}</div>
        <div class="stat-card-label">Konseling Bulan Ini</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $konselingSelesai }}</div>
        <div class="stat-card-label">Konseling Selesai</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $konselingBerlangsung }}</div>
        <div class="stat-card-label">Konseling Berlangsung</div>
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
            <a href="{{ route('bk.siswa-perlu-konseling.index') }}" class="action-btn">
                <i class="fas fa-user-clock"></i>
                <span>Siswa Perlu Konseling</span>
            </a>
            
            <a href="{{ route('bk.konseling.index') }}" class="action-btn">
                <i class="fas fa-plus"></i>
                <span>Input Konseling Baru</span>
            </a>
            
            <a href="{{ route('bk.data-diri.index') }}" class="action-btn">
                <i class="fas fa-user"></i>
                <span>Data Diri</span>
            </a>
            
            <a href="{{ route('bk.laporan.index') }}" class="action-btn">
                <i class="fas fa-file-alt"></i>
                <span>Generate Laporan</span>
            </a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="content-card-header">
        <div class="content-card-title">
            <i class="fas fa-chart-pie"></i>
            Statistik Jenis Layanan
        </div>
    </div>
    <div class="content-card-body">
        @php
            $jenisLayanan = \App\Models\BimbinganKonseling::selectRaw('jenis_layanan, COUNT(*) as total')
                ->groupBy('jenis_layanan')
                ->get();
        @endphp
        
        <div class="row g-3">
            @foreach($jenisLayanan as $jenis)
            <div class="col-md-3">
                <div style="text-align: center; padding: 20px; background: #f7fafc; border-radius: 12px;">
                    <div style="font-size: 24px; font-weight: 700; color: #667eea; margin-bottom: 8px;">
                        {{ $jenis->total }}
                    </div>
                    <div style="font-size: 12px; color: #718096; font-weight: 600;">
                        {{ $jenis->jenis_layanan }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection