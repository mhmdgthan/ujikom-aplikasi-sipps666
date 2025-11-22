@extends('layouts.wali-kelas')

@section('title', 'Preview Laporan')
@section('page-title', 'Preview Laporan ' . ucfirst($request->jenis_laporan))

@push('styles')
<style>
    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .report-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .report-title {
        font-size: 24px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .report-subtitle {
        font-size: 18px;
        color: #4a5568;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        padding: 20px;
        background: #f7fafc;
        border-radius: 8px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label {
        font-weight: 600;
        color: #4a5568;
        min-width: 120px;
    }

    .info-value {
        color: #2d3748;
    }

    .table-responsive {
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        font-weight: 600;
        text-align: center;
        border: none;
        padding: 12px 8px;
        font-size: 13px;
    }

    .table td {
        padding: 12px 8px;
        border-color: #e2e8f0;
        font-size: 13px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f7fafc;
    }

    .btn-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .btn-back, .btn-download, .btn-excel {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
    }

    .btn-back {
        background: #e2e8f0;
        color: #4a5568;
    }

    .btn-back:hover {
        background: #cbd5e0;
        color: #2d3748;
    }

    .btn-download {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
        color: white;
    }

    .btn-excel {
        background: linear-gradient(135deg, #38a169, #2f855a);
        color: white;
    }

    .btn-excel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 161, 105, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #718096;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 16px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .btn-actions {
            flex-direction: column;
        }
        
        .btn-back, .btn-download, .btn-excel {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="btn-actions">
        <a href="{{ route('wali-kelas.laporan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        <form action="{{ route('wali-kelas.laporan.generate') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="jenis_laporan" value="{{ $request->jenis_laporan }}">
            <input type="hidden" name="kelas_id" value="{{ $request->kelas_id }}">
            <input type="hidden" name="tanggal_mulai" value="{{ $request->tanggal_mulai }}">
            <input type="hidden" name="tanggal_selesai" value="{{ $request->tanggal_selesai }}">
            <input type="hidden" name="format" value="pdf">
            <button type="submit" class="btn-download">
                <i class="fas fa-download"></i>
                Download PDF
            </button>
        </form>
        <form action="{{ route('wali-kelas.laporan.generate') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="jenis_laporan" value="{{ $request->jenis_laporan }}">
            <input type="hidden" name="kelas_id" value="{{ $request->kelas_id }}">
            <input type="hidden" name="tanggal_mulai" value="{{ $request->tanggal_mulai }}">
            <input type="hidden" name="tanggal_selesai" value="{{ $request->tanggal_selesai }}">
            <input type="hidden" name="format" value="excel">
            <button type="submit" class="btn-excel">
                <i class="fas fa-file-excel"></i>
                Export Excel
            </button>
        </form>
    </div>

    <div class="report-header">
        <div class="report-title">SMK BAKTI NUSANTARA 666</div>
        <div class="report-subtitle">LAPORAN {{ strtoupper($request->jenis_laporan) }}</div>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Jenis Laporan:</span>
            <span class="info-value">{{ ucfirst($request->jenis_laporan) }}</span>
        </div>
        @if($request->kelas_id)
        <div class="info-item">
            <span class="info-label">Kelas:</span>
            <span class="info-value">{{ $data->first()->siswa->kelas->nama_kelas ?? ($data->first()->kelas->nama_kelas ?? 'Semua Kelas') }}</span>
        </div>
        @endif
        @if($request->tanggal_mulai && $request->tanggal_selesai)
        <div class="info-item">
            <span class="info-label">Periode:</span>
            <span class="info-value">{{ date('d/m/Y', strtotime($request->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($request->tanggal_selesai)) }}</span>
        </div>
        @endif
        <div class="info-item">
            <span class="info-label">Total Data:</span>
            <span class="info-value">{{ $data->count() }} data</span>
        </div>
        <div class="info-item">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value">{{ date('d F Y') }}</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    @if($request->jenis_laporan === 'pelanggaran')
                        <th width="25%">Nama Siswa</th>
                        <th width="15%">Kelas</th>
                        <th width="35%">Jenis Pelanggaran</th>
                        <th width="10%">Poin</th>
                        <th width="10%">Status</th>
                    @elseif($request->jenis_laporan === 'prestasi')
                        <th width="25%">Nama Siswa</th>
                        <th width="15%">Kelas</th>
                        <th width="35%">Jenis Prestasi</th>
                        <th width="15%">Poin</th>
                        <th width="10%">Status</th>
                    @else
                        <th width="15%">NIS</th>
                        <th width="30%">Nama Siswa</th>
                        <th width="15%">Kelas</th>
                        <th width="20%">Jenis Kelamin</th>
                        <th width="20%">Agama</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    @if($request->jenis_laporan === 'pelanggaran')
                        <td>{{ $item->siswa->user->nama_lengkap ?? '-' }}</td>
                        <td class="text-center">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $item->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                        <td class="text-center text-danger">-{{ $item->poin }}</td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ ucfirst($item->status_verifikasi) }}</span>
                        </td>
                    @elseif($request->jenis_laporan === 'prestasi')
                        <td>{{ $item->siswa->user->nama_lengkap ?? '-' }}</td>
                        <td class="text-center">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $item->jenisPrestasi->nama_prestasi }}</td>
                        <td class="text-center text-success">+{{ $item->poin }}</td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ ucfirst($item->status_verifikasi) }}</span>
                        </td>
                    @else
                        <td class="text-center">{{ $item->nis }}</td>
                        <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                        <td class="text-center">{{ $item->kelas->nama_kelas ?? '-' }}</td>
                        <td class="text-center">{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="text-center">{{ $item->agama }}</td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $request->jenis_laporan === 'siswa' ? '6' : ($request->jenis_laporan === 'pelanggaran' ? '6' : '6') }}">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <div>Tidak ada data yang ditemukan</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection