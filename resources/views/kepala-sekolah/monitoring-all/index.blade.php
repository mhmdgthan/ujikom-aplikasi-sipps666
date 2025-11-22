@extends('layouts.kepala-sekolah')

@section('title', 'Monitoring All Data')
@section('page-title', 'Monitoring All Data')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    /* Form Styles */
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 6px;
    }

    .form-control {
        height: 40px;
        padding: 0 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn {
        height: 40px;
        padding: 0 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5a67d8;
    }

    .btn-secondary {
        background: #718096;
        color: white;
    }

    .btn-secondary:hover {
        background: #4a5568;
    }

    .btn-success {
        background: #48bb78;
        color: white;
    }

    .btn-success:hover {
        background: #38a169;
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
        width: 200px;
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

    /* Data Table */
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

    .data-table tbody tr {
        transition: background 0.2s;
    }

    .data-table tbody tr:hover {
        background: #f7fafc;
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

    .badge-status.belum {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-status.proses {
        background: #bee3f8;
        color: #2c5282;
    }

    .badge-status.selesai {
        background: #c6f6d5;
        color: #22543d;
    }

    /* Action Buttons */
    .btn-action {
        width: 28px;
        height: 28px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        transition: all 0.2s;
        margin: 0 1px;
    }

    .btn-action.detail {
        background: #e6fffa;
        color: #319795;
    }

    .btn-action.detail:hover {
        background: #319795;
        color: white;
        transform: translateY(-1px);
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -12px;
    }

    .col-md-3, .col-md-6, .col-md-2, .col-md-4 {
        padding: 0 12px;
    }

    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }

    .col-md-2 {
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }

    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .g-3 {
        gap: 16px;
    }

    .align-items-end {
        align-items: flex-end;
    }

    .mb-4 {
        margin-bottom: 24px;
    }

    .me-2 {
        margin-right: 8px;
    }

    .stat-card {
        background: white;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }

    .stat-icon.siswa { background: linear-gradient(135deg, #48bb78, #38a169); }
    .stat-icon.guru { background: linear-gradient(135deg, #ed8936, #dd6b20); }
    .stat-icon.pelanggaran { background: linear-gradient(135deg, #f56565, #e53e3e); }
    .stat-icon.prestasi { background: linear-gradient(135deg, #48bb78, #38a169); }
    .stat-icon.sanksi { background: linear-gradient(135deg, #f56565, #e53e3e); }
    .stat-icon.kelas { background: linear-gradient(135deg, #4299e1, #3182ce); }
    .stat-icon.jurusan { background: linear-gradient(135deg, #9f7aea, #805ad5); }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 13px;
        color: #718096;
        font-weight: 500;
    }

    .table-footer {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0 0 12px 12px;
    }

    .showing-info {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }

    .pagination-wrapper .pagination {
        margin: 0;
    }

    .pagination-wrapper .page-link {
        color: #667eea;
        border: 1px solid #e2e8f0;
        padding: 8px 12px;
        margin: 0 2px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .pagination-wrapper .page-link:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    .pagination-wrapper .page-item.disabled .page-link {
        color: #a0aec0;
        background: #f7fafc;
        border-color: #e2e8f0;
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

        .data-table-card {
            overflow-x: auto;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .col-md-3, .col-md-6, .col-md-2, .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 16px;
        }

        .row {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .pagination-wrapper .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .pagination-wrapper .page-link {
            padding: 6px 10px;
            font-size: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon siswa">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-number">{{ $siswaCount }}</div>
            <div class="stat-label">Total Siswa</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon guru">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-number">{{ $guruCount }}</div>
            <div class="stat-label">Total Guru</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pelanggaran">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-number">{{ $pelanggaranCount }}</div>
            <div class="stat-label">Pelanggaran</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon prestasi">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-number">{{ $prestasiCount }}</div>
            <div class="stat-label">Prestasi</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon sanksi">
                <i class="fas fa-gavel"></i>
            </div>
            <div class="stat-number">{{ $sanksiCount }}</div>
            <div class="stat-label">Sanksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon kelas">
                <i class="fas fa-door-open"></i>
            </div>
            <div class="stat-number">{{ $kelasCount }}</div>
            <div class="stat-label">Kelas</div>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('kepala-sekolah.monitoring-all.index') }}" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggalSelesai }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Per Halaman</label>
                <select name="per_page" class="form-control">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('kepala-sekolah.monitoring-all.index') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-refresh"></i> Reset
                </a>
                <a href="#" onclick="exportPdf()" class="btn btn-success">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>
    </form>

    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari data..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select name="filter_type" onchange="this.form.submit()" form="filterForm">
                    <option value="">Semua Data</option>
                    <option value="siswa" {{ $filterType == 'siswa' ? 'selected' : '' }}>Data Siswa</option>
                    <option value="guru" {{ $filterType == 'guru' ? 'selected' : '' }}>Data Guru</option>
                    <option value="pelanggaran" {{ $filterType == 'pelanggaran' ? 'selected' : '' }}>Data Pelanggaran</option>
                    <option value="prestasi" {{ $filterType == 'prestasi' ? 'selected' : '' }}>Data Prestasi</option>
                    <option value="sanksi" {{ $filterType == 'sanksi' ? 'selected' : '' }}>Data Sanksi</option>
                    <option value="kelas" {{ $filterType == 'kelas' ? 'selected' : '' }}>Data Kelas</option>
                    <option value="jurusan" {{ $filterType == 'jurusan' ? 'selected' : '' }}>Data Jurusan</option>
                </select>
            </div>
            <form id="filterForm" method="GET" style="display: none;">
                <input type="hidden" name="tanggal_mulai" value="{{ $tanggalMulai }}">
                <input type="hidden" name="tanggal_selesai" value="{{ $tanggalSelesai }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <table class="data-table" id="monitoringTable">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Tipe Data</th>
                    <th>Nama/Judul</th>
                    <th>Detail</th>
                    <th style="width: 120px;">Tanggal</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paginator->items() as $index => $item)
                <tr data-type="{{ $item->type }}">
                    <td style="font-weight: 600; color: #718096;">{{ ($paginator->currentPage() - 1) * $paginator->perPage() + $index + 1 }}</td>
                    <td>
                        @if($item->type == 'siswa')
                            <span class="badge-kategori ringan"><i class="fas fa-user-graduate"></i> Siswa</span>
                        @elseif($item->type == 'guru')
                            <span class="badge-kategori sedang"><i class="fas fa-chalkboard-teacher"></i> Guru</span>
                        @elseif($item->type == 'pelanggaran')
                            <span class="badge-kategori berat"><i class="fas fa-exclamation-triangle"></i> Pelanggaran</span>
                        @elseif($item->type == 'prestasi')
                            <span class="badge-kategori ringan"><i class="fas fa-trophy"></i> Prestasi</span>
                        @elseif($item->type == 'sanksi')
                            <span class="badge-kategori berat"><i class="fas fa-gavel"></i> Sanksi</span>
                        @elseif($item->type == 'kelas')
                            <span class="badge-kategori sedang"><i class="fas fa-door-open"></i> Kelas</span>
                        @elseif($item->type == 'jurusan')
                            <span class="badge-kategori sedang"><i class="fas fa-graduation-cap"></i> Jurusan</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #2d3748;">{{ $item->nama }}</div>
                        <div style="font-size: 11px; color: #a0aec0;">{{ $item->detail }}</div>
                    </td>
                    <td>{{ $item->info }}</td>
                    <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                    <td><span class="badge-status disetujui">{{ $item->status }}</span></td>
                    <td>
                        <button class="btn-action detail" onclick="showDetail('{{ $item->type }}', {{ $item->id }})" title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #a0aec0;">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px;"></i><br>
                        Tidak ada data untuk ditampilkan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Table Footer -->
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} data
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    @if($paginator->hasPages())
    <div class="pagination-wrapper">
        {{ $paginator->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('monitoringTable');
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

function showDetail(type, id) {
    alert(`Detail ${type} dengan ID: ${id}`);
}

function exportPdf() {
    const tanggalMulai = document.querySelector('input[name="tanggal_mulai"]').value;
    const tanggalSelesai = document.querySelector('input[name="tanggal_selesai"]').value;
    const filterType = document.querySelector('select[name="filter_type"]').value;
    
    let url = '{{ route("kepala-sekolah.monitoring-all.export-pdf") }}?';
    if (tanggalMulai) url += 'tanggal_mulai=' + tanggalMulai + '&';
    if (tanggalSelesai) url += 'tanggal_selesai=' + tanggalSelesai + '&';
    if (filterType) url += 'filter_type=' + filterType;
    
    window.open(url, '_blank');
}
</script>
@endsection