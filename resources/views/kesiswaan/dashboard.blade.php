@extends('layouts.kesiswaan')

@section('title', 'Dashboard Kesiswaan')
@section('page-title', 'Dashboard Kesiswaan')

@push('styles')
<style>
    /* Compact Dashboard Styles */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .stat-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .stat-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }

    .stat-card:nth-child(1) .stat-card-icon {
        background: linear-gradient(135deg, #4299e1, #3182ce);
    }

    .stat-card:nth-child(2) .stat-card-icon {
        background: linear-gradient(135deg, #48bb78, #38a169);
    }

    .stat-card:nth-child(3) .stat-card-icon {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
    }

    .stat-card:nth-child(4) .stat-card-icon {
        background: linear-gradient(135deg, #9f7aea, #805ad5);
    }

    .stat-card-body {
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #2d3748;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: #718096;
        font-weight: 600;
    }

    .stat-footer {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 700;
        padding: 3px 6px;
        border-radius: 4px;
    }

    .stat-trend.up {
        background: #c6f6d5;
        color: #22543d;
    }

    .stat-trend.down {
        background: #fed7d7;
        color: #742a2a;
    }

    .stat-footer-text {
        color: #a0aec0;
    }

    /* Compact Tables */
    .tables-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }

    .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .content-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .content-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .content-card-title i {
        font-size: 18px;
    }

    .content-card-body {
        padding: 0;
    }

    .table-wrapper {
        max-height: 320px;
        overflow-y: auto;
    }

    .table-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 3px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background: #f7fafc;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    table th {
        padding: 10px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    table td {
        padding: 10px 16px;
        font-size: 13px;
        color: #4a5568;
        border-bottom: 1px solid #f1f5f9;
    }

    table tbody tr {
        transition: background 0.2s ease;
    }

    table tbody tr:hover {
        background: #f7fafc;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-success {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-warning {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-danger {
        background: #fed7d7;
        color: #742a2a;
    }

    .badge-info {
        background: #bee3f8;
        color: #2c5282;
    }

    .empty-state {
        text-align: center;
        padding: 32px 20px;
        color: #a0aec0;
    }

    .empty-state i {
        font-size: 40px;
        margin-bottom: 8px;
        display: block;
        opacity: 0.5;
    }

    .empty-state-text {
        font-size: 13px;
        margin: 0;
    }

    /* Info Card Compact */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-card-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #48bb78, #38a169);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .info-card-text h4 {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin: 0 0 2px 0;
    }

    .info-card-text p {
        font-size: 12px;
        color: #718096;
        margin: 0;
    }

    .info-card-badge {
        padding: 6px 16px;
        background: #c6f6d5;
        color: #22543d;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .tables-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php
    $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', true)->first();
@endphp

<!-- STATS CARDS - COMPACT -->
<div class="stats-grid">
    <!-- Card 1: Total Siswa -->
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
        <div class="stat-card-body">
            <div class="stat-value">{{ \App\Models\Siswa::count() }}</div>
            <div class="stat-label">Total Siswa</div>
        </div>
        <div class="stat-footer">
            <span class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                12%
            </span>
            <span class="stat-footer-text">dari bulan lalu</span>
        </div>
    </div>

    <!-- Card 2: Total Kelas -->
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
        <div class="stat-card-body">
            <div class="stat-value">{{ \App\Models\Kelas::count() }}</div>
            <div class="stat-label">Total Kelas</div>
        </div>
        <div class="stat-footer">
            <span class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                5%
            </span>
            <span class="stat-footer-text">dari tahun lalu</span>
        </div>
    </div>

    <!-- Card 3: Pelanggaran Pending -->
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
        </div>
        <div class="stat-card-body">
            <div class="stat-value">{{ \App\Models\Pelanggaran::where('status_verifikasi', 'pending')->count() }}</div>
            <div class="stat-label">Pelanggaran Pending</div>
        </div>
        <div class="stat-footer">
            <span class="stat-trend down">
                <i class="fas fa-arrow-down"></i>
                8%
            </span>
            <span class="stat-footer-text">dari minggu lalu</span>
        </div>
    </div>

    <!-- Card 4: Prestasi Pending -->
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon">
                <i class="fas fa-trophy"></i>
            </div>
        </div>
        <div class="stat-card-body">
            <div class="stat-value">{{ \App\Models\Prestasi::where('status_verifikasi', 'pending')->count() }}</div>
            <div class="stat-label">Prestasi Pending</div>
        </div>
        <div class="stat-footer">
            <span class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                15%
            </span>
            <span class="stat-footer-text">dari minggu lalu</span>
        </div>
    </div>
</div>

<!-- TAHUN AJARAN INFO - COMPACT -->
@if($tahunAjaranAktif)
<div class="info-card" style="margin-bottom: 24px;">
    <div class="info-card-left">
        <div class="info-card-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="info-card-text">
            <h4>{{ $tahunAjaranAktif->nama_tahun_ajaran }}</h4>
            <p>
                <i class="fas fa-clock"></i>
                {{ \Carbon\Carbon::parse($tahunAjaranAktif->tanggal_mulai)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($tahunAjaranAktif->tanggal_selesai)->format('d M Y') }}
            </p>
        </div>
    </div>
    <div class="info-card-badge">
        <i class="fas fa-check-circle"></i> AKTIF
    </div>
</div>
@endif

<!-- TABLES ROW - SIDE BY SIDE -->
<div class="tables-row">
    <!-- Pelanggaran Terbaru -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="content-card-title">
                <i class="fas fa-exclamation-circle" style="color: #ed8936;"></i>
                Pelanggaran Terbaru
            </div>
        </div>
        <div class="content-card-body">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Poin</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->latest()->take(5)->get() as $item)
                        <tr>
                            <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div style="font-weight: 600;">{{ $item->siswa->user->nama_lengkap ?? '-' }}</div>
                                <div style="font-size: 11px; color: #a0aec0;">{{ Str::limit($item->jenisPelanggaran?->nama_pelanggaran ?? '-', 25) }}</div>
                            </td>
                            <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td><span class="badge badge-danger">{{ $item->poin }}</span></td>
                            <td>
                                @if($item->status_verifikasi == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($item->status_verifikasi == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p class="empty-state-text">Belum ada data pelanggaran</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Prestasi Terbaru -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="content-card-title">
                <i class="fas fa-star" style="color: #f6ad55;"></i>
                Prestasi Terbaru
            </div>
        </div>
        <div class="content-card-body">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Tingkat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Prestasi::with(['siswa.kelas', 'jenisPrestasi'])->latest()->take(5)->get() as $item)
                        <tr>
                            <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div style="font-weight: 600;">{{ $item->siswa->user->nama_lengkap ?? '-' }}</div>
                                <div style="font-size: 11px; color: #a0aec0;">{{ Str::limit($item->jenisPrestasi->nama_prestasi, 25) }}</div>
                            </td>
                            <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($item->tingkat) }}</span></td>
                            <td>
                                @if($item->status_verifikasi == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($item->status_verifikasi == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-trophy"></i>
                                    <p class="empty-state-text">Belum ada data prestasi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection