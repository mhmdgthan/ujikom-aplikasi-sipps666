@extends('layouts.kesiswaan')

@section('title', 'Data Sanksi Siswa')
@section('page-title', 'Manajemen Sanksi Siswa')

@push('styles')
<style>
    /* Container Wrapper */
    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    /* Page Actions */
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

    .filter-box {
        position: relative;
        width: 180px;
    }

    .filter-box select {
        width: 100%;
        height: 40px;
        padding: 0 16px 0 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
        background: white;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23a0aec0' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    .filter-box select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 14px;
        pointer-events: none;
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
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    /* Data Table */
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

    /* Siswa Info */
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

    /* Badge Styles */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-status.aktif {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-status.selesai {
        background: #bee3f8;
        color: #2c5282;
    }

    .badge-status.batal {
        background: #fed7d7;
        color: #742a2a;
    }

    .badge-status.belum {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-status.proses {
        background: #bee3f8;
        color: #2c5282;
    }

    .badge-duration {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    /* Action Buttons */
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
        background: #fc8181;
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

    /* Empty State */
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

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
    }

    .modal-header.edit {
        background: linear-gradient(135deg, #f6ad55, #ed8936);
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

    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
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

    .btn-modal.cancel {
        background: #f7fafc;
        color: #4a5568;
    }

    .btn-modal.cancel:hover {
        background: #e2e8f0;
    }

    .btn-modal.submit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-modal.submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-modal.update {
        background: linear-gradient(135deg, #f6ad55, #ed8936);
        color: white;
    }

    .detail-group {
        margin-bottom: 16px;
    }

    .detail-label {
        font-size: 11px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 14px;
        color: #2d3748;
        font-weight: 500;
    }

    .text-danger {
        color: #e53e3e;
        font-size: 12px;
        margin-top: 4px;
    }

    /* Responsive */
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

        .search-box, .filter-box {
            width: 100%;
        }

        .showing-info {
            font-size: 12px;
        }
    }
</style>
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau jenis sanksi..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="belum">Belum</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahSanksiModal">
            <i class="fas fa-plus"></i>
            Tambah Sanksi
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="sanksiTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 250px;">Siswa</th>
                        <th style="width: 200px;">Jenis Pelanggaran</th>
                        <th style="width: 200px;">Jenis Sanksi</th>
                        <th class="text-center" style="width: 120px;">Durasi</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sanksi as $index => $item)
                    <tr data-status="{{ strtolower($item->status) }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($sanksi->currentPage() - 1) * $sanksi->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="siswa-info">
                                <div class="siswa-avatar">
                                    {{ strtoupper(substr($item->pelanggaran->siswa->user->nama_lengkap ?? 'N', 0, 1)) }}
                                </div>
                                <div class="siswa-details">
                                    <div class="siswa-name">{{ $item->pelanggaran->siswa->user->nama_lengkap ?? '-' }}</div>
                                    <div class="siswa-kelas">{{ $item->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->pelanggaran->tanggal->format('d/m/Y') ?? '-' }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->jenis_sanksi }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->tanggal_mulai->format('d/m/Y') }}</div>
                        </td>
                        <td class="text-center">
                            @if($item->tanggal_selesai)
                                <span class="badge-duration">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $item->tanggal_mulai->diffInDays($item->tanggal_selesai) }} hari
                                </span>
                            @else
                                <span style="color: #a0aec0; font-size: 11px;">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge-status {{ strtolower($item->status) }}">
                                @if(strtolower($item->status) == 'belum')
                                    <i class="fas fa-clock"></i>
                                @elseif(strtolower($item->status) == 'proses')
                                    <i class="fas fa-spinner"></i>
                                @else
                                    <i class="fas fa-check-circle"></i>
                                @endif
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    onclick="showDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editSanksiModal">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn-action delete" title="Hapus"
                                    onclick="deleteData({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-gavel"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Sanksi</div>
                                <div class="empty-state-text">Silakan tambahkan data sanksi dengan klik tombol "Tambah Sanksi"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sanksi->count() > 0)
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan {{ $sanksi->firstItem() }} - {{ $sanksi->lastItem() }} dari {{ $sanksi->total() }} data</span>
            </div>
            <div class="pagination-controls">
                @if($sanksi->onFirstPage())
                    <span class="pagination-btn prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $sanksi->previousPageUrl() }}" class="pagination-btn prev">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </a>
                @endif
                
                <div class="pagination-numbers">
                    @foreach($sanksi->getUrlRange(1, $sanksi->lastPage()) as $page => $url)
                        @if($page == $sanksi->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                @if($sanksi->hasMorePages())
                    <a href="{{ $sanksi->nextPageUrl() }}" class="pagination-btn next">
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

{{-- Modal Tambah Sanksi --}}
<div class="modal fade" id="tambahSanksiModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Sanksi Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kesiswaan.sanksi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pilih Pelanggaran <span class="text-danger">*</span></label>
                            <select name="pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                @foreach($pelanggaran as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->siswa->user->nama_lengkap ?? '-' }} - 
                                        {{ $p->jenisPelanggaran->nama_pelanggaran ?? '' }} 
                                        ({{ $p->tanggal->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Sanksi <span class="text-danger">*</span></label>
                            <select name="jenis_sanksi" class="form-select" required>
                                <option value="">-- Pilih Jenis Sanksi --</option>
                                @foreach($jenisSanksi as $js)
                                    <option value="{{ $js->nama_sanksi }}">
                                        {{ $js->nama_sanksi }} ({{ ucfirst($js->kategori) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control">
                            <div class="text-danger">Kosongkan jika sanksi tidak memiliki batas waktu</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Sanksi <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="belum">Belum Dilaksanakan</option>
                                <option value="proses">Sedang Berjalan</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Sanksi</label>
                            <textarea name="deskripsi_sanksi" class="form-control" rows="3" placeholder="Jelaskan detail sanksi yang diberikan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal submit">
                        <i class="fas fa-save"></i> Simpan Sanksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Sanksi --}}
<div class="modal fade" id="editSanksiModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Sanksi Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pilih Pelanggaran <span class="text-danger">*</span></label>
                            <select name="pelanggaran_id" id="edit_pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                @foreach($pelanggaran as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->siswa->user->nama_lengkap ?? '-' }} - 
                                        {{ $p->jenisPelanggaran->nama_pelanggaran ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Sanksi <span class="text-danger">*</span></label>
                            <select name="jenis_sanksi" id="edit_jenis_sanksi" class="form-select" required>
                                <option value="">-- Pilih Jenis Sanksi --</option>
                                @foreach($jenisSanksi as $js)
                                    <option value="{{ $js->nama_sanksi }}">
                                        {{ $js->nama_sanksi }} ({{ ucfirst($js->kategori) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control">
                            <div class="text-danger">Kosongkan jika sanksi tidak memiliki batas waktu</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Sanksi <span class="text-danger">*</span></label>
                            <select name="status" id="edit_status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="belum">Belum Dilaksanakan</option>
                                <option value="proses">Sedang Berjalan</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Sanksi</label>
                            <textarea name="deskripsi_sanksi" id="edit_deskripsi_sanksi" class="form-control" rows="3" placeholder="Jelaskan detail sanksi yang diberikan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal update">
                        <i class="fas fa-save"></i> Update Sanksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail Sanksi --}}
<div class="modal fade" id="detailSanksiModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="detailContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Search Function
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('sanksiTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();
        
        const statusFilter = document.getElementById('filterStatus').value;
        const rowStatus = row.dataset.status;
        
        const matchesStatus = !statusFilter || rowStatus === statusFilter;
        
        if (text.includes(filter) && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Filter by Status
function filterByStatus() {
    searchTable();
}

// SweetAlert Notifications
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

@if($errors->any())
Swal.fire({
    icon: 'error',
    title: 'Validation Error',
    html: '<ul style="text-align: left;">' +
        @foreach($errors->all() as $error)
            '<li>{{ $error }}</li>' +
        @endforeach
        '</ul>',
    showConfirmButton: true
});
@endif

// Delete Confirmation
function deleteData(id) {
    Swal.fire({
        title: 'Hapus Data Sanksi?',
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
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/kesiswaan/sanksi/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Edit Modal Handler
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const form = document.getElementById('editForm');
        
        // Generate URL menggunakan template literal dengan base URL Laravel
        const baseUrl = "{{ url('kesiswaan/sanksi') }}";
        form.action = `${baseUrl}/${id}`;
        
        // Fetch data sanksi untuk edit
        fetch(`${baseUrl}/${id}`)
            .then(response => response.json())
            .then(data => {
                console.log('Edit data:', data);
                form.querySelector('#edit_pelanggaran_id').value = data.pelanggaran_id || '';
                form.querySelector('#edit_jenis_sanksi').value = data.jenis_sanksi || '';
                form.querySelector('#edit_tanggal_mulai').value = data.tanggal_mulai || '';
                form.querySelector('#edit_tanggal_selesai').value = data.tanggal_selesai || '';
                form.querySelector('#edit_status').value = data.status || '';
                form.querySelector('#edit_deskripsi_sanksi').value = data.deskripsi_sanksi || '';
            })
            .catch(error => console.error('Error:', error));
    });
});

// Detail Modal Handler
function showDetail(id) {
    const baseUrl = "{{ url('kesiswaan/sanksi') }}";
    
    fetch(`${baseUrl}/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Detail data:', data);
            const content = document.getElementById('detailContent');
            
            const siswaNama = data.pelanggaran?.siswa?.user?.nama_lengkap || 'Nama tidak tersedia';
            const kelasNama = data.pelanggaran?.siswa?.kelas?.nama_kelas || 'Kelas tidak tersedia';
            const jenisPelanggaran = data.pelanggaran?.jenis_pelanggaran?.nama_pelanggaran || 'Jenis tidak tersedia';
            const jenisSanksi = data.jenis_sanksi || 'Jenis sanksi tidak tersedia';
            const tanggalMulai = data.tanggal_mulai ? new Date(data.tanggal_mulai).toLocaleDateString('id-ID') : 'Tanggal tidak tersedia';
            const tanggalSelesai = data.tanggal_selesai ? new Date(data.tanggal_selesai).toLocaleDateString('id-ID') : 'Tidak ada batas waktu';
            const status = data.status || 'belum';
            const deskripsi = data.deskripsi_sanksi || 'Tidak ada deskripsi';
            const durasi = data.tanggal_selesai ? 
                Math.ceil((new Date(data.tanggal_selesai) - new Date(data.tanggal_mulai)) / (1000 * 60 * 60 * 24)) + ' hari' : 
                'Tidak terbatas';
            
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Siswa</div>
                        <div class="detail-value">${siswaNama}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kelas</div>
                        <div class="detail-value">${kelasNama}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Jenis Pelanggaran</div>
                        <div class="detail-value">${jenisPelanggaran}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Jenis Sanksi</div>
                        <div class="detail-value">${jenisSanksi}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Mulai</div>
                        <div class="detail-value">${tanggalMulai}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Selesai</div>
                        <div class="detail-value">${tanggalSelesai}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Durasi Sanksi</div>
                        <div class="detail-value">${durasi}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status Sanksi</div>
                        <div class="detail-value">
                            <span class="badge-status ${status.toLowerCase()}">
                                ${status.charAt(0).toUpperCase() + status.slice(1)}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Deskripsi Sanksi</div>
                        <div class="detail-value">${deskripsi}</div>
                    </div>
                </div>
            `;
            
            const modal = new bootstrap.Modal(document.getElementById('detailSanksiModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail sanksi: ' + error.message,
                confirmButtonColor: '#e53e3e'
            });
        });
}
</script>
@endpush