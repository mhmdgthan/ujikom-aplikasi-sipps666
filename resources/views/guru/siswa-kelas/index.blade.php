@extends('layouts.guru')

@section('title', 'Data Siswa Kelas')
@section('page-title')
Data Siswa Kelas {{ $waliKelas->kelas->nama_kelas }}
@endsection

@push('styles')
<style>
    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .class-info {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 12px;
        padding: 24px;
        color: white;
        margin-bottom: 24px;
    }

    .class-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .class-details {
        font-size: 14px;
        opacity: 0.9;
    }

    .data-table-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
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

    .data-table td {
        padding: 14px 16px;
        font-size: 13px;
        color: #4a5568;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
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

    .table-footer {
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f1f5f9;
    }

    .showing-info {
        font-size: 13px;
        color: #718096;
    }
</style>
@endpush

@section('content')
<div class="class-info">
    <div class="class-title">{{ $waliKelas->kelas->nama_kelas }}</div>
    <div class="class-details">
        Tahun Ajaran: {{ $waliKelas->tahunAjaran->tahun_ajaran }} - {{ ucfirst($waliKelas->tahunAjaran->semester) }}
        <br>
        Jumlah Siswa: {{ $siswa->count() }} orang
    </div>
</div>

<div class="content-wrapper">
    <div class="data-table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 250px;">Nama Siswa</th>
                    <th style="width: 120px;">NIS</th>
                    <th style="width: 150px;">Jenis Kelamin</th>
                    <th style="width: 200px;">Orang Tua</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $index => $item)
                <tr>
                    <td style="font-weight: 600; color: #718096;">
                        {{ $index + 1 }}
                    </td>
                    <td>
                        <div class="siswa-info">
                            <div class="siswa-avatar">
                                {{ strtoupper(substr($item->user->nama_lengkap ?? 'N', 0, 1)) }}
                            </div>
                            <div>
                                <div class="siswa-name">{{ $item->user->nama_lengkap ?? '-' }}</div>
                                <div class="siswa-nis">{{ $item->nis }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $item->orangTua->nama_orang_tua ?? '-' }}</td>
                    <td>{{ $item->alamat ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="empty-state-title">Belum Ada Siswa</div>
                            <div class="empty-state-text">Kelas ini belum memiliki siswa</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($siswa->count() > 0)
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan <strong>{{ $siswa->count() }}</strong> siswa
            </div>
        </div>
        @endif
    </div>
</div>
@endsection