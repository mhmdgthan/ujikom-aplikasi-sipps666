@extends('layouts.kesiswaan')

@section('title', 'Data Pelanggaran Siswa')
@section('page-title', 'Manajemen Pelanggaran Siswa')

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
        background: linear-gradient(135deg, #fc8181, #e53e3e);
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
    .badge-kategori {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-kategori.ringan {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-kategori.sedang {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-kategori.berat {
        background: #fed7d7;
        color: #742a2a;
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

    .badge-status.pending {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-status.disetujui {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-status.ditolak {
        background: #fed7d7;
        color: #742a2a;
    }

    .badge-poin {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        background: linear-gradient(135deg, #fc8181, #e53e3e);
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

    .btn-action.verify {
        background: #c6f6d5;
        color: #22543d;
    }

    .btn-action.verify:hover {
        background: #9ae6b4;
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

    .modal-header.verify {
        background: linear-gradient(135deg, #48bb78, #38a169);
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

    .btn-modal.approve {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .btn-modal.reject {
        background: linear-gradient(135deg, #fc8181, #e53e3e);
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

    .bukti-foto {
        width: 100%;
        max-width: 400px;
        height: auto;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
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
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau jenis pelanggaran..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu Verifikasi</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="filter-box">
                <i class="fas fa-tags"></i>
                <select id="filterKategori" onchange="filterByKategori()">
                    <option value="">Semua Kategori</option>
                    <option value="ringan">Ringan</option>
                    <option value="sedang">Sedang</option>
                    <option value="berat">Berat</option>
                </select>
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahPelanggaranModal">
            <i class="fas fa-plus"></i>
            Input Pelanggaran
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="pelanggaranTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 250px;">Siswa</th>
                        <th style="width: 280px;">Jenis Pelanggaran</th>
                        <th class="text-center" style="width: 120px;">Kategori</th>
                        <th class="text-center" style="width: 100px;">Poin</th>
                        <th class="text-center" style="width: 150px;">Status Verifikasi</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $index => $item)
                    <tr data-status="{{ strtolower($item->status_verifikasi) }}" data-kategori="{{ strtolower($item->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? '') }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($pelanggaran->currentPage() - 1) * $pelanggaran->perPage() + $loop->iteration }}
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
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->tahunAjaran->tahun_ajaran ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge-kategori {{ strtolower($item->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'ringan') }}">
                                @if(strtolower($item->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'ringan') == 'ringan')
                                    <i class="fas fa-info-circle"></i>
                                @elseif(strtolower($item->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'ringan') == 'sedang')
                                    <i class="fas fa-exclamation-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($item->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? 'Ringan') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-poin">
                                <i class="fas fa-minus"></i>
                                {{ $item->poin }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-status {{ strtolower($item->status_verifikasi) }}">
                                @if(strtolower($item->status_verifikasi) == 'pending')
                                    <i class="fas fa-clock"></i>
                                @elseif(strtolower($item->status_verifikasi) == 'disetujui')
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($item->status_verifikasi) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    onclick="showDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit" onclick="editPelanggaran({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#editPelanggaranModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('kesiswaan.pelanggaran.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Pelanggaran</div>
                                <div class="empty-state-text">Silakan input data pelanggaran siswa dengan klik tombol "Input Pelanggaran"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggaran->count() > 0)
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan {{ $pelanggaran->firstItem() }} - {{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</span>
            </div>
            <div class="pagination-controls">
                @if($pelanggaran->onFirstPage())
                    <span class="pagination-btn prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pagination-btn prev">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </a>
                @endif
                
                <div class="pagination-numbers">
                    @foreach($pelanggaran->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
                        @if($page == $pelanggaran->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                @if($pelanggaran->hasMorePages())
                    <a href="{{ $pelanggaran->nextPageUrl() }}" class="pagination-btn next">
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



{{-- Modal Detail Pelanggaran --}}
<div class="modal fade" id="detailPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Pelanggaran
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

{{-- Modal Tambah Pelanggaran --}}
<div class="modal fade" id="tambahPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Input Pelanggaran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kesiswaan.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? 'Nama tidak tersedia' }} - {{ $s->kelas->nama_kelas ?? 'Kelas tidak tersedia' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select name="jenis_pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Pelanggaran --</option>
                                @foreach($jenisPelanggaran as $jp)
                                <option value="{{ $jp->id }}">{{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pelanggaran <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan Pelanggaran <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan detail pelanggaran yang terjadi..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bukti Foto (Opsional)</label>
                            <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                            <div class="text-danger">Format: JPG, PNG, JPEG. Maksimal 2MB</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal submit">
                        <i class="fas fa-save"></i> Simpan Pelanggaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Pelanggaran --}}
<div class="modal fade" id="editPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select id="edit_siswa_id" name="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? 'Nama tidak tersedia' }} - {{ $s->kelas->nama_kelas ?? 'Kelas tidak tersedia' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select id="edit_jenis_pelanggaran_id" name="jenis_pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Pelanggaran --</option>
                                @foreach($jenisPelanggaran as $jp)
                                <option value="{{ $jp->id }}">{{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select id="edit_tahun_ajaran_id" name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pelanggaran <span class="text-danger">*</span></label>
                            <input type="date" id="edit_tanggal" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan Pelanggaran <span class="text-danger">*</span></label>
                            <textarea id="edit_keterangan" name="keterangan" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bukti Foto (Opsional)</label>
                            <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                            <div class="text-danger">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal update">
                        <i class="fas fa-save"></i> Update Pelanggaran
                    </button>
                </div>
            </form>
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
    const table = document.getElementById('pelanggaranTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();
        
        const statusFilter = document.getElementById('filterStatus').value;
        const kategoriFilter = document.getElementById('filterKategori').value;
        const rowStatus = row.dataset.status;
        const rowKategori = row.dataset.kategori;
        
        const matchesStatus = !statusFilter || rowStatus === statusFilter;
        const matchesKategori = !kategoriFilter || rowKategori === kategoriFilter;
        
        if (text.includes(filter) && matchesStatus && matchesKategori) {
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

// Filter by Kategori
function filterByKategori() {
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
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data Pelanggaran?',
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



function showDetail(id) {
    fetch(`{{ url('kesiswaan/verifikasi-data') }}/${id}/detail`)
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
                        <div class="detail-label">Jenis Pelanggaran</div>
                        <div class="detail-value">${data.jenis_pelanggaran ? data.jenis_pelanggaran.nama_pelanggaran : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kategori & Poin</div>
                        <div class="detail-value">${data.kategori_poin || '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Pelanggaran</div>
                        <div class="detail-value">${data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID') : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tahun Ajaran</div>
                        <div class="detail-value">${data.tahun_ajaran ? data.tahun_ajaran.tahun_ajaran : '-'}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status Verifikasi</div>
                        <div class="detail-value">
                            <span class="badge-status ${data.status_verifikasi ? data.status_verifikasi.toLowerCase() : 'pending'}">
                                ${data.status_verifikasi ? data.status_verifikasi.charAt(0).toUpperCase() + data.status_verifikasi.slice(1) : 'Pending'}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Deskripsi Pelanggaran</div>
                        <div class="detail-value">${data.keterangan || data.deskripsi || '-'}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Bukti Foto</div>
                        <div class="detail-value">
                            ${data.bukti_foto ? 
                                `<img src="${data.bukti_foto.startsWith('uploads/') ? '/' + data.bukti_foto : '/storage/' + data.bukti_foto}" class="bukti-foto clickable-photo" alt="Bukti Pelanggaran" style="max-width: 300px; border-radius: 8px; cursor: pointer;" onclick="previewFoto('${data.bukti_foto.startsWith('uploads/') ? '/' + data.bukti_foto : '/storage/' + data.bukti_foto}')" title="Klik untuk memperbesar">
                                <div class="mt-2"><small class="text-muted">Klik foto untuk memperbesar</small></div>` : 
                                'Bukti Pelanggaran masih kosong'
                            }
                        </div>
                    </div>
                </div>
            `;
            const modal = new bootstrap.Modal(document.getElementById('detailPelanggaranModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}

function editPelanggaran(id) {
    fetch(`{{ url('kesiswaan/pelanggaran') }}/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_siswa_id').value = data.siswa_id;
            document.getElementById('edit_jenis_pelanggaran_id').value = data.jenis_pelanggaran_id;
            document.getElementById('edit_tahun_ajaran_id').value = data.tahun_ajaran_id;
            document.getElementById('edit_tanggal').value = data.tanggal;
            document.getElementById('edit_keterangan').value = data.keterangan;
            document.getElementById('editForm').action = `{{ url('kesiswaan/pelanggaran') }}/${id}`;
        })
        .catch(error => console.error('Error:', error));
}

// Photo Preview Function
function previewFoto(imageSrc) {
    Swal.fire({
        title: 'Bukti Foto Pelanggaran',
        imageUrl: imageSrc,
        imageWidth: 500,
        imageHeight: 400,
        imageAlt: 'Bukti Foto Pelanggaran',
        showCloseButton: true,
        showConfirmButton: false,
        customClass: {
            image: 'preview-image'
        },
        didOpen: () => {
            const image = document.querySelector('.preview-image');
            if (image) {
                image.style.objectFit = 'contain';
                image.style.borderRadius = '8px';
                image.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
            }
        }
    });
}

// Add CSS for clickable photos
const style = document.createElement('style');
style.textContent = `
    .clickable-photo {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .clickable-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        opacity: 0.9;
    }
`;
document.head.appendChild(style);
</script>
@endpush