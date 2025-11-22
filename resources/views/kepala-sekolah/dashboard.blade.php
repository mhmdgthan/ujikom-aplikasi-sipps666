@extends('layouts.kepala-sekolah')

@section('title', 'Dashboard Kepala Sekolah')
@section('page-title', 'Dashboard Monitoring Sekolah')

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
        color: #fc8181;
    }

    .stat-card:nth-child(2) .stat-card-icon {
        background: linear-gradient(135deg, #fc8181, #e53e3e);
    }

    .stat-card:nth-child(3) {
        color: #48bb78;
    }

    .stat-card:nth-child(3) .stat-card-icon {
        background: linear-gradient(135deg, #48bb78, #38a169);
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

    .kelas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
    }

    .kelas-card {
        background: #f7fafc;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e2e8f0;
    }

    .kelas-name {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .kelas-stats {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
    }

    .kelas-stat {
        text-align: center;
    }

    .kelas-stat-value {
        font-weight: 700;
        font-size: 14px;
    }

    .kelas-stat-label {
        color: #718096;
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

    /* ================ RESPONSIVE ================ */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .stat-card {
            padding: 16px;
        }

        .stat-card-value {
            font-size: 28px;
        }

        .content-card-body {
            padding: 16px;
        }

        .kelas-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalSiswa }}</div>
        <div class="stat-card-label">Total Siswa</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalPelanggaran }}</div>
        <div class="stat-card-label">Total Pelanggaran</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-trophy"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalPrestasi }}</div>
        <div class="stat-card-label">Total Prestasi</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-comments"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalKonseling }}</div>
        <div class="stat-card-label">Total Konseling</div>
    </div>
</div>

<div class="content-card">
    <div class="content-card-header">
        <div class="content-card-title">
            <i class="fas fa-chart-bar"></i>
            Statistik Bulan Ini
        </div>
    </div>
    <div class="content-card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div style="text-align: center; padding: 20px; background: #fed7d7; border-radius: 12px;">
                    <div style="font-size: 24px; font-weight: 700; color: #742a2a; margin-bottom: 8px;">
                        {{ $pelanggaranBulanIni }}
                    </div>
                    <div style="font-size: 12px; color: #742a2a; font-weight: 600;">Pelanggaran Bulan Ini</div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="text-align: center; padding: 20px; background: #c6f6d5; border-radius: 12px;">
                    <div style="font-size: 24px; font-weight: 700; color: #22543d; margin-bottom: 8px;">
                        {{ $prestasiBulanIni }}
                    </div>
                    <div style="font-size: 12px; color: #22543d; font-weight: 600;">Prestasi Bulan Ini</div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="text-align: center; padding: 20px; background: #bee3f8; border-radius: 12px;">
                    <div style="font-size: 24px; font-weight: 700; color: #2c5282; margin-bottom: 8px;">
                        {{ $konselingBulanIni }}
                    </div>
                    <div style="font-size: 12px; color: #2c5282; font-weight: 600;">Konseling Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="content-card-header">
        <div class="content-card-title">
            <i class="fas fa-school"></i>
            Data Per Kelas
        </div>
    </div>
    <div class="content-card-body">
        <div class="kelas-grid">
            @foreach($dataPerKelas as $namaKelas => $siswaKelas)
            <div class="kelas-card">
                <div class="kelas-name">{{ $namaKelas ?: 'Belum Ada Kelas' }}</div>
                <div class="kelas-stats">
                    <div class="kelas-stat">
                        <div class="kelas-stat-value">{{ $siswaKelas->count() }}</div>
                        <div class="kelas-stat-label">Siswa</div>
                    </div>
                    <div class="kelas-stat">
                        <div class="kelas-stat-value">{{ $siswaKelas->sum(function($s) { return $s->pelanggaran->count(); }) }}</div>
                        <div class="kelas-stat-label">Pelanggaran</div>
                    </div>
                    <div class="kelas-stat">
                        <div class="kelas-stat-value">{{ $siswaKelas->sum(function($s) { return $s->prestasi->count(); }) }}</div>
                        <div class="kelas-stat-label">Prestasi</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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
            <a href="{{ route('kepala-sekolah.data-siswa.index') }}" class="action-btn">
                <i class="fas fa-users"></i>
                <span>Lihat Data Siswa</span>
            </a>
            
            <a href="{{ route('kepala-sekolah.laporan.index') }}" class="action-btn">
                <i class="fas fa-file-alt"></i>
                <span>Export Laporan</span>
            </a>
            
            <a href="{{ route('kepala-sekolah.data-diri.index') }}" class="action-btn">
                <i class="fas fa-user"></i>
                <span>Data Diri</span>
            </a>
        </div>
    </div>
</div>
@endsection