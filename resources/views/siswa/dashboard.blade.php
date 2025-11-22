@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

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

    @media (min-width: 768px) {
        .profile-card {
            padding: 32px;
        }
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
            margin-bottom: 32px;
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
        margin-bottom: 16px;
    }

    @media (min-width: 768px) {
        .profile-role {
            font-size: 16px;
        }
    }

    .profile-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    @media (min-width: 768px) {
        .profile-stats {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }
    }

    .stat-item {
        text-align: center;
        padding: 12px;
        background: #f7fafc;
        border-radius: 8px;
    }

    @media (min-width: 768px) {
        .stat-item {
            background: transparent;
            padding: 0;
        }
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        color: #667eea;
        display: block;
    }

    @media (min-width: 768px) {
        .stat-value {
            font-size: 24px;
        }
    }

    .stat-label {
        font-size: 11px;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (min-width: 768px) {
        .stat-label {
            font-size: 12px;
        }
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

    .recent-activities {
        margin-top: 20px;
    }

    .data-table-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        border: 1px solid #e2e8f0;
    }

    @media (min-width: 768px) {
        .data-table-card {
            padding: 24px;
        }
    }

    .card-title-header {
        font-size: 16px;
        font-weight: 600;
        color: #4a5568;
        padding-bottom: 12px;
        margin-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (min-width: 768px) {
        .card-title-header {
            font-size: 18px;
            margin-bottom: 20px;
        }
    }

    .card-title-header.pelanggaran {
        color: #e53e3e;
    }

    .card-title-header.prestasi {
        color: #38a169;
    }

    .card-title-header.konseling {
        color: #667eea;
    }

    .card-title-header.sanksi {
        color: #f6ad55;
    }

    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .data-table {
        width: 100%;
        min-width: 600px;
        border-collapse: collapse;
    }

    .data-table th, .data-table td {
        padding: 12px;
        font-size: 13px;
        color: #4a5568;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        white-space: nowrap;
    }

    @media (min-width: 768px) {
        .data-table th, .data-table td {
            padding: 14px 16px;
        }
    }

    .data-table th {
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        background-color: #f7fafc;
        color: #718096;
        position: sticky;
        top: 0;
    }

    .data-table tbody tr:hover {
        background-color: #f7fafc;
    }

    .data-table .poin-pelanggaran {
        font-weight: 700;
        color: #e53e3e;
        text-align: center;
    }

    .data-table .poin-prestasi {
        font-weight: 700;
        color: #38a169;
        text-align: center;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    @media (min-width: 768px) {
        .empty-state {
            padding: 60px 20px;
        }
    }

    .empty-state-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 12px;
        background: #f7fafc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #cbd5e0;
    }

    @media (min-width: 768px) {
        .empty-state-icon {
            width: 80px;
            height: 80px;
            font-size: 32px;
            margin-bottom: 16px;
        }
    }

    .empty-state-title {
        font-weight: 600;
        font-size: 14px;
        color: #4a5568;
        margin-bottom: 4px;
    }

    @media (min-width: 768px) {
        .empty-state-title {
            font-size: 16px;
        }
    }

    .empty-state-text {
        font-size: 12px;
        color: #a0aec0;
    }

    @media (min-width: 768px) {
        .empty-state-text {
            font-size: 13px;
        }
    }

    .activity-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 12px;
    }

    @media (min-width: 768px) {
        .activity-card {
            padding: 20px;
            margin-bottom: 16px;
        }
    }

    .activity-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        flex-shrink: 0;
    }

    @media (min-width: 768px) {
        .activity-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }

    .activity-icon.pelanggaran {
        background: linear-gradient(135deg, #f56565, #e53e3e);
    }

    .activity-icon.prestasi {
        background: linear-gradient(135deg, #48bb78, #38a169);
    }

    .activity-icon.konseling {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .activity-icon.sanksi {
        background: linear-gradient(135deg, #f6ad55, #ed8936);
    }

    .activity-title {
        font-weight: 600;
        color: #2d3748;
        font-size: 13px;
    }

    @media (min-width: 768px) {
        .activity-title {
            font-size: 14px;
        }
    }

    .activity-date {
        font-size: 11px;
        color: #a0aec0;
    }

    @media (min-width: 768px) {
        .activity-date {
            font-size: 12px;
        }
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagination-info {
        font-size: 13px;
        color: #718096;
        margin-right: 16px;
    }

    .pagination {
        display: flex;
        gap: 4px;
    }

    .page-link {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #4a5568;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        min-width: 40px;
        text-align: center;
    }

    .page-link:hover {
        background: #f7fafc;
        border-color: #cbd5e0;
    }

    .page-link.active {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    .page-link.disabled {
        color: #a0aec0;
        cursor: not-allowed;
        background: #f7fafc;
    }

    @media (max-width: 640px) {
        .pagination-container {
            flex-direction: column;
            gap: 12px;
        }
        
        .pagination-info {
            margin-right: 0;
            text-align: center;
        }
        
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(substr($siswa->user->nama_lengkap ?? 'S', 0, 1)) }}
        </div>
        <div class="profile-info">
            <div class="profile-name">{{ $siswa->user->nama_lengkap ?? 'Nama Siswa' }}</div>
            <div class="profile-role">{{ $siswa->kelas->nama_kelas ?? 'Siswa' }}</div>
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $totalPelanggaran }}</span>
                    <span class="stat-label">Pelanggaran</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $totalPrestasi }}</span>
                    <span class="stat-label">Prestasi</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $totalKonseling }}</span>
                    <span class="stat-label">Konseling</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $totalSanksi ?? 0 }}</span>
                    <span class="stat-label">Sanksi</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $poinPelanggaran }}</span>
                    <span class="stat-label">Poin Pelanggaran</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $poinPrestasi }}</span>
                    <span class="stat-label">Poin Prestasi</span>
                </div>
            </div>
        </div>
    </div>

    <div class="recent-activities">
        <div class="section-title">
            <div class="section-icon">
                <i class="fas fa-history"></i>
            </div>
            Aktivitas Terbaru
        </div>

        @forelse($recentActivities as $activity)
        <div class="activity-card">
            <div class="activity-header">
                <div class="activity-icon {{ $activity['type'] }}">
                    @if($activity['type'] == 'pelanggaran')
                        <i class="fas fa-exclamation-triangle"></i>
                    @elseif($activity['type'] == 'prestasi')
                        <i class="fas fa-trophy"></i>
                    @elseif($activity['type'] == 'sanksi')
                        <i class="fas fa-gavel"></i>
                    @else
                        <i class="fas fa-comments"></i>
                    @endif
                </div>
                <div>
                    <div class="activity-title">{{ $activity['title'] }}</div>
                    <div class="activity-date">{{ $activity['date'] }}</div>
                </div>
            </div>
            <p style="margin: 0; color: #718096; font-size: 13px;">{{ $activity['description'] }}</p>
        </div>
        @empty
        <div class="text-center py-4">
            <i class="fas fa-history fa-2x text-muted mb-3"></i>
            <p class="text-muted">Belum ada aktivitas terbaru</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Data Pelanggaran -->
<div class="data-table-card">
    <div class="card-title-header pelanggaran">
        <i class="fas fa-exclamation-triangle"></i>
        Data Pelanggaran
    </div>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Tanggal</th>
                    <th class="text-center">Poin</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggaran as $index => $p)
                <tr>
                    <td>{{ ($pelanggaran->currentPage() - 1) * $pelanggaran->perPage() + $index + 1 }}</td>
                    <td>{{ $p->jenisPelanggaran?->nama_pelanggaran ?? 'Pelanggaran Dihapus' }}</td>
                    <td>{{ $p->tanggal?->format('d M Y') ?? '-' }}</td>
                    <td class="poin-pelanggaran">{{ $p->poin ?? 0 }}</td>
                    <td>{{ $p->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="empty-state-title">Tidak Ada Pelanggaran</div>
                            <div class="empty-state-text">Anda tidak memiliki catatan pelanggaran.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pelanggaran->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $pelanggaran->firstItem() }} - {{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data
        </div>
        <div class="pagination">
            {{ $pelanggaran->appends(request()->except('pelanggaran_page'))->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Data Prestasi -->
<div class="data-table-card">
    <div class="card-title-header prestasi">
        <i class="fas fa-trophy"></i>
        Data Prestasi
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Prestasi</th>
                    <th>Tanggal</th>
                    <th class="text-center">Poin</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestasi as $index => $p)
                <tr>
                    <td>{{ ($prestasi->currentPage() - 1) * $prestasi->perPage() + $index + 1 }}</td>
                    <td>{{ $p->jenisPrestasi?->nama_prestasi ?? '-' }}</td>
                    <td>{{ $p->tanggal?->format('d M Y') ?? '-' }}</td>
                    <td class="poin-prestasi">{{ $p->poin ?? 0 }}</td>
                    <td>{{ $p->nama_prestasi ?? $p->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-medal"></i></div>
                            <div class="empty-state-title">Tidak Ada Prestasi</div>
                            <div class="empty-state-text">Anda belum memiliki catatan prestasi.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($prestasi->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $prestasi->firstItem() }} - {{ $prestasi->lastItem() }} dari {{ $prestasi->total() }} data
        </div>
        <div class="pagination">
            {{ $prestasi->appends(request()->except('prestasi_page'))->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Data Sanksi -->
<div class="data-table-card">
    <div class="card-title-header sanksi">
        <i class="fas fa-gavel"></i>
        Data Sanksi
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Sanksi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanksi ?? [] as $index => $s)
                <tr>
                    <td>{{ isset($sanksi) ? ($sanksi->currentPage() - 1) * $sanksi->perPage() + $index + 1 : $index + 1 }}</td>
                    <td>{{ $s->sanksi?->jenis_sanksi ?? '-' }}</td>
                    <td>{{ $s->tanggal_pelaksanaan?->format('d M Y') ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $s->status === 'Selesai' ? 'bg-success' : 'bg-warning' }}" style="font-size: 11px; padding: 4px 8px;">
                            {{ $s->status ?? 'Berlangsung' }}
                        </span>
                    </td>
                    <td>{{ $s->catatan ?? $s->sanksi?->deskripsi_sanksi ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="empty-state-title">Tidak Ada Sanksi</div>
                            <div class="empty-state-text">Anda tidak memiliki catatan sanksi.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($sanksi) && $sanksi->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $sanksi->firstItem() }} - {{ $sanksi->lastItem() }} dari {{ $sanksi->total() }} data
        </div>
        <div class="pagination">
            {{ $sanksi->appends(request()->except('sanksi_page'))->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Data Konseling -->
<div class="data-table-card">
    <div class="card-title-header konseling">
        <i class="fas fa-comments"></i>
        Data Bimbingan Konseling
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Layanan</th>
                    <th>Topik</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Konselor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konseling as $index => $k)
                <tr>
                    <td>{{ ($konseling->currentPage() - 1) * $konseling->perPage() + $index + 1 }}</td>
                    <td>{{ $k->jenis_layanan ?? '-' }}</td>
                    <td>{{ $k->topik ?? '-' }}</td>
                    <td>{{ $k->tanggal_konseling?->format('d M Y') ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $k->status === 'Selesai' ? 'bg-success' : 'bg-warning' }}" style="font-size: 11px; padding: 4px 8px;">
                            {{ $k->status ?? 'Berlangsung' }}
                        </span>
                    </td>
                    <td>{{ $k->konselor->nama_lengkap ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-comments"></i></div>
                            <div class="empty-state-title">Tidak Ada Data Konseling</div>
                            <div class="empty-state-text">Anda belum memiliki catatan bimbingan konseling.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($konseling->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $konseling->firstItem() }} - {{ $konseling->lastItem() }} dari {{ $konseling->total() }} data
        </div>
        <div class="pagination">
            {{ $konseling->appends(request()->except('konseling_page'))->links() }}
        </div>
    </div>
    @endif
</div>
@endsection