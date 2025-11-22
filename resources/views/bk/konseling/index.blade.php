@extends('layouts.bk')

@section('title', 'Input Konseling')
@section('page-title', 'Input Bimbingan Konseling')

@push('styles')
<style>
    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .page-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-actions-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        width: 280px;
    }

    .search-box input {
        width: 100%;
        height: 40px;
        padding: 0 16px 0 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
    }

    .search-box input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 14px;
    }

    .btn-add {
        height: 40px;
        padding: 0 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .data-table-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .table-container {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
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

    .siswa-kelas {
        font-size: 11px;
        color: #a0aec0;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-status.berlangsung {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-status.selesai {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-layanan {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        background: #bee3f8;
        color: #2c5282;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 12px;
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    .btn-action.view {
        background: #bee3f8;
        color: #2c5282;
    }

    .btn-action.view:hover {
        background: #90cdf4;
    }

    .btn-action.edit {
        background: #feebc8;
        color: #7c2d12;
    }

    .btn-action.edit:hover {
        background: #fbd38d;
    }

    .btn-action.delete {
        background: #fed7d7;
        color: #742a2a;
    }

    .btn-action.delete:hover {
        background: #feb2b2;
    }

    .btn-action.complete {
        background: #c6f6d5;
        color: #22543d;
    }

    .btn-action.complete:hover {
        background: #9ae6b4;
    }

    .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
    }

    .modal-header.edit {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-body {
        padding: 24px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        display: block;
    }

    .form-control, .form-select {
        width: 100%;
        height: 40px;
        padding: 0 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
        background: white;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    textarea.form-control {
        height: auto;
        padding: 12px 14px;
        resize: vertical;
        min-height: 80px;
    }

    .btn-modal {
        height: 40px;
        padding: 0 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-modal:hover {
        transform: translateY(-1px);
    }

    .btn-modal.cancel {
        background: #f7fafc;
        color: #4a5568;
        border: 1px solid #e2e8f0;
    }

    .btn-modal.cancel:hover {
        background: #edf2f7;
    }

    .btn-modal.submit, .btn-modal.update {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-modal.submit:hover, .btn-modal.update:hover {
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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

    .detail-group {
        margin-bottom: 16px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        display: block;
    }

    .detail-value {
        font-size: 14px;
        color: #2d3748;
        font-weight: 500;
        padding: 8px 12px;
        background: #f7fafc;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }

    /* ================ RESPONSIVE ================ */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 16px;
        }

        .page-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .page-actions-left {
            width: 100%;
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .btn-add {
            width: 100%;
            justify-content: center;
        }

        .data-table {
            min-width: 600px;
        }

        .siswa-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 4px;
        }

        .btn-action {
            width: 100%;
            height: 28px;
        }
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0 0 12px 12px;
    }

    .pagination-info {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pagination-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .pagination-btn:hover:not(.disabled) {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #64748b;
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-numbers {
        display: flex;
        gap: 4px;
        margin: 0 8px;
    }

    .pagination-number {
        width: 32px;
        height: 32px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .pagination-number:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #64748b;
    }

    .pagination-number.active {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    @media (max-width: 768px) {
        .modal-dialog {
            margin: 10px;
            max-width: calc(100% - 20px);
        }
        
        .modal-content {
            max-height: calc(100vh - 20px);
            display: flex;
            flex-direction: column;
        }
        
        .modal-body {
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 200px);
            padding: 16px !important;
            -webkit-overflow-scrolling: touch;
        }
        
        .modal-header {
            padding: 16px !important;
            flex-shrink: 0;
        }
        
        .modal-footer {
            padding: 12px 16px !important;
            flex-shrink: 0;
        }
        
        .col-md-6 {
            margin-bottom: 12px;
        }
        
        .form-label {
            font-size: 12px !important;
            margin-bottom: 6px !important;
        }
        
        .form-control, .form-select {
            height: 36px !important;
            font-size: 12px !important;
            padding: 0 12px !important;
        }
        
        textarea.form-control {
            height: 70px !important;
            padding: 8px 12px !important;
        }
        
        .pagination-wrapper {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }
        
        .pagination-controls {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau topik..." onkeyup="searchTable()">
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahKonselingModal">
            <i class="fas fa-plus"></i>
            Input Konseling
        </button>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="konselingTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 250px;">Siswa</th>
                        <th style="width: 150px;">Jenis Layanan</th>
                        <th style="width: 200px;">Topik</th>
                        <th class="text-center" style="width: 120px;">Tanggal</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konseling as $index => $item)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($konseling->currentPage() - 1) * $konseling->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="siswa-info">
                                <div class="siswa-avatar">
                                    {{ strtoupper(substr($item->siswa->user->nama_lengkap ?? 'N', 0, 1)) }}
                                </div>
                                <div class="siswa-details">
                                    <div class="siswa-name">{{ $item->siswa->user->nama_lengkap ?? '-' }}</div>
                                    <div class="siswa-kelas">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-layanan">
                                <i class="fas fa-comments"></i>
                                {{ $item->jenis_layanan }}
                            </span>
                        </td>
                        <td>{{ $item->topik }}</td>
                        <td class="text-center">
                            {{ $item->tanggal_konseling->format('d/m/Y') }}
                        </td>
                        <td class="text-center">
                            <span class="badge-status {{ strtolower($item->status ?? 'berlangsung') }}">
                                <i class="fas fa-{{ $item->status == 'Selesai' ? 'check-circle' : 'clock' }}"></i>
                                {{ $item->status ?? 'Berlangsung' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    onclick="showDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($item->status != 'Selesai')
                                <form action="{{ route('bk.konseling.complete', $item->id) }}" method="POST" class="d-inline form-complete">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action complete" title="Selesaikan Konseling">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editKonselingModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('bk.konseling.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Konseling</div>
                                <div class="empty-state-text">Silakan input data konseling dengan klik tombol "Input Konseling"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($konseling->count() > 0)
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan {{ $konseling->firstItem() }} - {{ $konseling->lastItem() }} dari {{ $konseling->total() }} data</span>
            </div>
            <div class="pagination-controls">
                @if($konseling->onFirstPage())
                    <span class="pagination-btn prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $konseling->previousPageUrl() }}" class="pagination-btn prev">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </a>
                @endif
                
                <div class="pagination-numbers">
                    @foreach($konseling->getUrlRange(1, $konseling->lastPage()) as $page => $url)
                        @if($page == $konseling->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                @if($konseling->hasMorePages())
                    <a href="{{ $konseling->nextPageUrl() }}" class="pagination-btn next">
                        Next
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="pagination-btn next disabled">
                        Next
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah Konseling --}}
<div class="modal fade" id="tambahKonselingModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Input Konseling Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('bk.konseling.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? '-' }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select name="jenis_layanan" class="form-select" required>
                                <option value="">-- Pilih Jenis Layanan --</option>
                                <option value="Konseling Individual">Konseling Individual</option>
                                <option value="Konseling Kelompok">Konseling Kelompok</option>
                                <option value="Bimbingan Klasikal">Bimbingan Klasikal</option>
                                <option value="Konsultasi">Konsultasi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Konseling <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_konseling" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Topik <span class="text-danger">*</span></label>
                            <input type="text" name="topik" class="form-control" placeholder="Masukkan topik konseling..." required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tindakan/Solusi</label>
                            <textarea name="tindakan_solusi" class="form-control" rows="3" placeholder="Jelaskan tindakan atau solusi yang diberikan..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Berlangsung">Berlangsung</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Tindak Lanjut</label>
                            <input type="date" name="tanggal_tindak_lanjut" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Hasil Evaluasi</label>
                            <textarea name="hasil_evaluasi" class="form-control" rows="2" placeholder="Hasil evaluasi konseling..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal submit">Simpan Konseling</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Konseling --}}
<div class="modal fade" id="editKonselingModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Konseling
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editKonselingForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? '-' }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select name="jenis_layanan" class="form-select" required>
                                <option value="">-- Pilih Jenis Layanan --</option>
                                <option value="Konseling Individual">Konseling Individual</option>
                                <option value="Konseling Kelompok">Konseling Kelompok</option>
                                <option value="Bimbingan Klasikal">Bimbingan Klasikal</option>
                                <option value="Konsultasi">Konsultasi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Konseling <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_konseling" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Topik <span class="text-danger">*</span></label>
                            <input type="text" name="topik" class="form-control" placeholder="Masukkan topik konseling..." required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tindakan/Solusi</label>
                            <textarea name="tindakan_solusi" class="form-control" rows="3" placeholder="Jelaskan tindakan atau solusi yang diberikan..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Berlangsung">Berlangsung</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Tindak Lanjut</label>
                            <input type="date" name="tanggal_tindak_lanjut" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Hasil Evaluasi</label>
                            <textarea name="hasil_evaluasi" class="form-control" rows="2" placeholder="Hasil evaluasi konseling..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal update">Update Konseling</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail Konseling --}}
<div class="modal fade" id="detailKonselingModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Konseling
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="detailContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('konselingTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();
        
        if (text.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Edit Modal Handler
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const form = document.getElementById('editKonselingForm');
            form.action = `/bk/konseling/${id}`;
            
            // Fetch data untuk diisi di form edit
            fetch(`/bk/konseling/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    form.querySelector('[name="siswa_id"]').value = data.siswa_id || '';
                    form.querySelector('[name="tahun_ajaran_id"]').value = data.tahun_ajaran_id || '';
                    form.querySelector('[name="jenis_layanan"]').value = data.jenis_layanan || '';
                    form.querySelector('[name="tanggal_konseling"]').value = data.tanggal_konseling || '';
                    form.querySelector('[name="topik"]').value = data.topik || '';
                    form.querySelector('[name="tindakan_solusi"]').value = data.tindakan_solusi || '';
                    form.querySelector('[name="status"]').value = data.status || 'Berlangsung';
                    form.querySelector('[name="tanggal_tindak_lanjut"]').value = data.tanggal_tindak_lanjut || '';
                    form.querySelector('[name="hasil_evaluasi"]').value = data.hasil_evaluasi || '';
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Delete Confirmation
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data Konseling?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e53e3e',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Complete Confirmation
    document.querySelectorAll('.form-complete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Selesaikan Konseling?',
                text: "Konseling akan ditandai sebagai selesai",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#38a169',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Ya, Selesaikan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

// Show Detail Function
function showDetail(id) {
    fetch(`/bk/konseling/${id}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('detailContent');
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Siswa</div>
                        <div class="detail-value">${data.siswa && data.siswa.user ? data.siswa.user.nama_lengkap : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kelas</div>
                        <div class="detail-value">${data.siswa && data.siswa.kelas ? data.siswa.kelas.nama_kelas : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Jenis Layanan</div>
                        <div class="detail-value">${data.jenis_layanan || '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Konseling</div>
                        <div class="detail-value">${data.tanggal_konseling ? new Date(data.tanggal_konseling).toLocaleDateString('id-ID') : '-'}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Topik</div>
                        <div class="detail-value">${data.topik || '-'}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Tindakan/Solusi</div>
                        <div class="detail-value">${data.tindakan_solusi || '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span class="badge-status ${data.status ? data.status.toLowerCase() : 'berlangsung'}">
                                ${data.status || 'Berlangsung'}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Tindak Lanjut</div>
                        <div class="detail-value">${data.tanggal_tindak_lanjut ? new Date(data.tanggal_tindak_lanjut).toLocaleDateString('id-ID') : '-'}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Hasil Evaluasi</div>
                        <div class="detail-value">${data.hasil_evaluasi || '-'}</div>
                    </div>
                </div>
            `;
            const modal = new bootstrap.Modal(document.getElementById('detailKonselingModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000,
    toast: true,
    position: 'top-end'
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    confirmButtonColor: '#e53e3e',
});
@endif
</script>
@endpush