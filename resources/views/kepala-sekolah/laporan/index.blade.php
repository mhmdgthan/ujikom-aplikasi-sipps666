@extends('layouts.kepala-sekolah')

@section('title', 'Laporan')
@section('page-title', 'Laporan Sekolah')

@push('styles')
<style>
    .report-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        border: 1px solid #f1f5f9;
    }

    .report-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .report-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .report-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 4px;
    }

    .report-desc {
        font-size: 14px;
        color: #718096;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-generate {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .btn-generate:hover {
        transform: translateY(-1px);
    }

    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
    }

    @media (max-width: 768px) {
        .reports-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="reports-grid">
    <!-- Laporan Siswa -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon" style="background: linear-gradient(135deg, #4299e1, #3182ce);">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="report-title">Laporan Data Siswa</div>
                <div class="report-desc">Laporan lengkap data siswa per kelas</div>
            </div>
        </div>
        <form action="{{ route('kepala-sekolah.laporan.generate') }}" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="jenis_laporan" value="siswa">
            
            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" class="form-control">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn-generate">
                <i class="fas fa-download"></i> Generate Laporan
            </button>
        </form>
    </div>

    <!-- Laporan Pelanggaran -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon" style="background: linear-gradient(135deg, #f56565, #e53e3e);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <div class="report-title">Laporan Pelanggaran</div>
                <div class="report-desc">Laporan pelanggaran siswa berdasarkan periode</div>
            </div>
        </div>
        <form action="{{ route('kepala-sekolah.laporan.generate') }}" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="jenis_laporan" value="pelanggaran">
            
            <div class="form-group">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" required>
            </div>
            
            <button type="submit" class="btn-generate">
                <i class="fas fa-download"></i> Generate Laporan
            </button>
        </form>
    </div>

    <!-- Laporan Prestasi -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon" style="background: linear-gradient(135deg, #48bb78, #38a169);">
                <i class="fas fa-trophy"></i>
            </div>
            <div>
                <div class="report-title">Laporan Prestasi</div>
                <div class="report-desc">Laporan prestasi siswa berdasarkan periode</div>
            </div>
        </div>
        <form action="{{ route('kepala-sekolah.laporan.generate') }}" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="jenis_laporan" value="prestasi">
            
            <div class="form-group">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" required>
            </div>
            
            <button type="submit" class="btn-generate">
                <i class="fas fa-download"></i> Generate Laporan
            </button>
        </form>
    </div>

    <!-- Laporan Konseling -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon" style="background: linear-gradient(135deg, #ed8936, #dd6b20);">
                <i class="fas fa-comments"></i>
            </div>
            <div>
                <div class="report-title">Laporan Konseling</div>
                <div class="report-desc">Laporan bimbingan konseling siswa</div>
            </div>
        </div>
        <form action="{{ route('kepala-sekolah.laporan.generate') }}" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="jenis_laporan" value="konseling">
            
            <div class="form-group">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" required>
            </div>
            
            <button type="submit" class="btn-generate">
                <i class="fas fa-download"></i> Generate Laporan
            </button>
        </form>
    </div>

    <!-- Laporan Rekap -->
    <div class="report-card">
        <div class="report-header">
            <div class="report-icon" style="background: linear-gradient(135deg, #9f7aea, #805ad5);">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div>
                <div class="report-title">Laporan Rekap Sekolah</div>
                <div class="report-desc">Rekap lengkap data sekolah</div>
            </div>
        </div>
        <form action="{{ route('kepala-sekolah.laporan.generate') }}" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="jenis_laporan" value="rekap">
            
            <div class="form-group">
                <label class="form-label">Tahun Ajaran</label>
                <select name="tahun_ajaran_id" class="form-control">
                    <option value="">Pilih Tahun Ajaran</option>
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn-generate">
                <i class="fas fa-download"></i> Generate Laporan
            </button>
        </form>
    </div>
</div>
@endsection