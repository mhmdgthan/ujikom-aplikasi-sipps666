@extends('layouts.main')

@section('title', 'Dashboard Administrator')
@section('page-title', 'Dashboard Administrator')
@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <div class="stat-value">{{ $jumlahSiswa }}</div>
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
            <div class="stat-value">{{ $jumlahKelas }}</div>
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
            <div class="stat-value">{{ $pelanggaranPending }}</div>
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
            <div class="stat-value">{{ $prestasiPending }}</div>
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

<!-- CHARTS SECTION -->
<div class="charts-grid">
    <!-- Monthly Violations Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">
                    <i class="fas fa-chart-line" style="color: #667eea;"></i>
                    Tren Pelanggaran Bulanan
                </div>
                <div class="chart-subtitle">Data pelanggaran 12 bulan terakhir</div>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Top Violators -->
    <div class="top-violators">
        <div class="chart-header">
            <div class="chart-title">
                <i class="fas fa-user-times" style="color: #e53e3e;"></i>
                Siswa Pelanggaran Terbanyak
            </div>
        </div>
        @forelse($siswaPelanggaran as $index => $siswa)
        <div class="violator-item">
            <div class="violator-info">
                <div class="violator-rank">{{ $index + 1 }}</div>
                <div class="violator-details">
                    <h5>{{ $siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</h5>
                    <p>Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                </div>
            </div>
            <div class="violator-count">{{ $siswa->total_pelanggaran }} kasus</div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-user-check"></i>
            <p class="empty-state-text">Tidak ada data pelanggaran</p>
        </div>
        @endforelse
    </div>
</div>

<style>
@media (max-width: 768px) {
    .charts-grid { grid-template-columns: 1fr !important; gap: 16px !important; }
    .chart-container { height: 250px !important; }
    .chart-title { font-size: 14px !important; }
    .chart-subtitle { font-size: 12px !important; }
    .tables-row { grid-template-columns: 1fr !important; gap: 16px !important; }
    .table-wrapper { overflow-x: auto; }
    .violator-details h5 { font-size: 13px !important; }
    .violator-details p { font-size: 11px !important; }
}
</style>

<!-- Category Chart -->
<div class="chart-card">
    <div class="chart-header">
        <div>
            <div class="chart-title">
                <i class="fas fa-chart-pie" style="color: #f6ad55;"></i>
                Pelanggaran Berdasarkan Kategori
            </div>
            <div class="chart-subtitle">Distribusi jenis pelanggaran</div>
        </div>
    </div>
    <div class="chart-container" style="height: 250px;">
        <canvas id="categoryChart"></canvas>
    </div>
</div>

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
                        @forelse($pelanggaranTerbaru as $item)
                        <tr>
                            <td>
                                @if($item->tanggal)
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $item->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</div>
                                <div style="font-size: 11px; color: #a0aec0;">
                                    {{ Str::limit($item->jenisPelanggaran->nama_pelanggaran ?? 'Jenis tidak tersedia', 25) }}
                                </div>
                            </td>
                            <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td><span class="badge badge-danger">-{{ $item->poin }}</span></td>
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
                            <th>Poin</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestasiTerbaru as $item)
                        <tr>
                            <td>
                                @if($item->tanggal_prestasi)
                                    {{ \Carbon\Carbon::parse($item->tanggal_prestasi)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $item->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</div>
                                <div style="font-size: 11px; color: #a0aec0;">
                                    {{ Str::limit($item->jenisPrestasi->nama_prestasi ?? 'Jenis tidak tersedia', 25) }}
                                </div>
                            </td>
                            <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td><span class="badge badge-success">+{{ $item->poin }}</span></td>
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

@push('scripts')
<script>
// Monthly Violations Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: @json($bulanLabels),
        datasets: [{
            label: 'Jumlah Pelanggaran',
            data: @json($pelanggaranBulanan),
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#667eea',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f1f5f9'
                },
                ticks: {
                    color: '#718096',
                    font: {
                        size: 11
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#718096',
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});

// Category Pie Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryData = @json($pelanggaranKategori);
const categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: categoryData.map(item => item.kategori_induk),
        datasets: [{
            data: categoryData.map(item => item.total),
            backgroundColor: [
                '#667eea',
                '#f6ad55',
                '#fc8181',
                '#48bb78',
                '#9f7aea'
            ],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    font: {
                        size: 12
                    },
                    color: '#4a5568'
                }
            }
        },
        cutout: '60%'
    }
});
</script>
@endpush