@extends('layouts.kepala-sekolah')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa Sekolah')

@push('styles')
<style>
    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        text-align: center;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #667eea;
        display: block;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #718096;
        font-weight: 500;
    }

    .data-table-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .table-container {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .data-table thead {
        background: #f7fafc;
    }

    .data-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .data-table th.text-center {
        text-align: center;
    }

    .data-table td {
        padding: 14px 16px;
        font-size: 13px;
        color: #4a5568;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .data-table tbody tr {
        transition: background 0.2s;
    }

    .data-table tbody tr:hover {
        background: #f7fafc;
    }

    .siswa-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .siswa-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .siswa-details {
        display: flex;
        flex-direction: column;
    }

    .siswa-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 13px;
        margin-bottom: 2px;
    }

    .siswa-nis {
        font-size: 11px;
        color: #a0aec0;
    }

    .badge-poin {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
    }

    .badge-poin.pelanggaran {
        background: #fed7d7;
        color: #742a2a;
    }

    .badge-poin.prestasi {
        background: #c6f6d5;
        color: #22543d;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
        background: #f7fafc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #cbd5e0;
    }

    .empty-state-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .empty-state-text {
        font-size: 14px;
        color: #718096;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-value">{{ $totalSiswa }}</span>
            <span class="stat-label">Total Siswa</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $totalPelanggaran }}</span>
            <span class="stat-label">Total Pelanggaran</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $totalPrestasi }}</span>
            <span class="stat-label">Total Prestasi</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $totalKelas }}</span>
            <span class="stat-label">Total Kelas</span>
        </div>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 250px;">Siswa</th>
                        <th class="text-center" style="width: 120px;">Kelas</th>
                        <th class="text-center" style="width: 120px;">Jenis Kelamin</th>
                        <th class="text-center" style="width: 120px;">Pelanggaran</th>
                        <th class="text-center" style="width: 120px;">Poin Pelanggaran</th>
                        <th class="text-center" style="width: 120px;">Prestasi</th>
                        <th class="text-center" style="width: 120px;">Poin Prestasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="siswa-info">
                                <div class="siswa-avatar">
                                    {{ strtoupper(substr($s->user->nama_lengkap ?? 'S', 0, 1)) }}
                                </div>
                                <div class="siswa-details">
                                    <div class="siswa-name">{{ $s->user->nama_lengkap ?? '-' }}</div>
                                    <div class="siswa-nis">NIS: {{ $s->nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $s->kelas->nama_kelas ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td class="text-center">
                            <span class="badge-poin pelanggaran">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $s->pelanggaran->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-poin pelanggaran">
                                {{ $s->pelanggaran->sum('poin') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-poin prestasi">
                                <i class="fas fa-trophy"></i>
                                {{ $s->prestasi->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-poin prestasi">
                                {{ $s->prestasi->sum('poin') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Siswa</div>
                                <div class="empty-state-text">Sekolah ini belum memiliki data siswa</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection