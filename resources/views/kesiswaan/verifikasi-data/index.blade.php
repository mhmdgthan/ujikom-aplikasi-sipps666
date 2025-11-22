@extends('layouts.kesiswaan')

@section('title', 'Verifikasi Data')
@section('page-title', 'Verifikasi Data')

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
    gap: 16px;
    flex-wrap: wrap;
}

.search-box, .filter-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-box input, .filter-box select {
    padding: 10px 12px 10px 40px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    min-width: 200px;
}

.search-box i, .filter-box i {
    position: absolute;
    left: 12px;
    color: #a0aec0;
    z-index: 1;
}

.stats-info {
    display: flex;
    gap: 12px;
}

.data-table-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: #f8fafc;
    padding: 16px;
    text-align: left;
    font-weight: 600;
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e2e8f0;
}

.data-table td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #f8fafc;
}

.siswa-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.siswa-avatar {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 14px;
}

.siswa-details {
    font-weight: 600;
    color: #2d3748;
}

.siswa-kelas {
    font-size: 11px;
    color: #a0aec0;
    font-weight: 400;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-status.pending {
    background: #fef3cd;
    color: #856404;
}

.badge-status.disetujui {
    background: #dcfce7;
    color: #16a34a;
}

.badge-status.ditolak {
    background: #fee2e2;
    color: #dc2626;
}

.action-buttons {
    display: flex;
    gap: 8px;
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

.btn-action.verify {
    background: #16a34a;
    color: white;
}

.btn-action.verify:hover {
    background: #15803d;
}

.btn-action.delete {
    background: #dc2626;
    color: white;
}

.btn-action.delete:hover {
    background: #b91c1c;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 16px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #cbd5e0;
}

.empty-state-title {
    font-weight: 600;
    font-size: 16px;
    color: #4a5568;
    margin-bottom: 4px;
}

.empty-state-text {
    font-size: 13px;
    color: #a0aec0;
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
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau jenis data..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="filter-box">
                <i class="fas fa-tags"></i>
                <select id="filterTipe" onchange="filterByTipe()">
                    <option value="">Semua Tipe</option>
                    <option value="pelanggaran">Pelanggaran</option>
                    <option value="prestasi">Prestasi</option>
                    <option value="sanksi">Sanksi</option>
                </select>
            </div>
        </div>
        <div class="stats-info">
            <span class="badge-status pending">
                <i class="fas fa-clock"></i>
                {{ $verifikasi->where('status', 'pending')->count() }} Pending
            </span>
        </div>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="verifikasiTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tipe Data</th>
                        <th>Siswa</th>
                        <th>Detail</th>
                        <th>Tanggal Input</th>
                        <th>Status</th>
                        <th>Diverifikasi Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($verifikasi as $index => $item)
                    <tr data-status="{{ strtolower($item->status) }}" data-tipe="{{ strtolower($item->tabel_terkait) }}">
                        <td>{{ ($verifikasi->currentPage() - 1) * $verifikasi->perPage() + $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-{{ $item->tabel_terkait == 'pelanggaran' ? 'danger' : ($item->tabel_terkait == 'prestasi' ? 'success' : 'warning') }}">
                                {{ ucfirst($item->tabel_terkait) }}
                            </span>
                        </td>
                        <td>
                            @if($item->data_terkait)
                                {{ $item->data_terkait->siswa->user->nama_lengkap ?? '-' }}
                                <br><small class="text-muted">{{ $item->data_terkait->siswa->nis ?? '-' }}</small>
                            @else
                                <span class="text-muted">Data tidak ditemukan</span>
                            @endif
                        </td>
                        <td>
                            @if($item->data_terkait)
                                @if($item->tabel_terkait == 'pelanggaran')
                                    {{ $item->data_terkait->jenisPelanggaran->nama_pelanggaran ?? '-' }}
                                    <br><small class="text-muted">Poin: {{ $item->data_terkait->poin ?? 0 }}</small>
                                @elseif($item->tabel_terkait == 'prestasi')
                                    {{ $item->data_terkait->jenisPrestasi->nama_prestasi ?? '-' }}
                                    <br><small class="text-muted">Poin: {{ $item->data_terkait->poin ?? 0 }}</small>
                                @elseif($item->tabel_terkait == 'sanksi')
                                    {{ $item->data_terkait->jenisSanksi->nama_sanksi ?? '-' }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <span class="badge-status {{ strtolower($item->status) }}">
                                @if($item->status == 'pending')
                                    <i class="fas fa-clock"></i>
                                @elseif($item->status == 'disetujui')
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            @if($item->status != 'pending')
                                <div style="font-weight: 600; color: #2d3748; font-size: 13px;">
                                    {{ $item->userVerifikator->nama_lengkap ?? 'Tidak diketahui' }}
                                </div>
                                <div style="font-size: 11px; color: #a0aec0;">
                                    {{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}
                                </div>
                            @else
                                <span style="color: #a0aec0; font-size: 13px;">Belum diverifikasi</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($item->status == 'pending')
                                    <form method="POST" action="{{ route('kesiswaan.verifikasi-data.approve', $item->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-action verify" title="Setujui" onclick="return confirm('Setujui data ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('kesiswaan.verifikasi-data.reject', $item->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-action delete" title="Tolak" onclick="return confirm('Tolak data ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('kesiswaan.verifikasi-data.destroy', $item->id) }}" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus" style="background: #fed7d7; color: #742a2a;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data yang perlu diverifikasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($verifikasi->count() > 0)
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan {{ $verifikasi->firstItem() }} - {{ $verifikasi->lastItem() }} dari {{ $verifikasi->total() }} data</span>
            </div>
            <div class="pagination-controls">
                @if($verifikasi->onFirstPage())
                    <span class="pagination-btn prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $verifikasi->previousPageUrl() }}" class="pagination-btn prev">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </a>
                @endif
                
                <div class="pagination-numbers">
                    @foreach($verifikasi->getUrlRange(1, $verifikasi->lastPage()) as $page => $url)
                        @if($page == $verifikasi->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                @if($verifikasi->hasMorePages())
                    <a href="{{ $verifikasi->nextPageUrl() }}" class="pagination-btn next">
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Search Function
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('verifikasiTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();
        
        const statusFilter = document.getElementById('filterStatus').value;
        const tipeFilter = document.getElementById('filterTipe').value;
        const rowStatus = row.dataset.status;
        const rowTipe = row.dataset.tipe;
        
        const matchesStatus = !statusFilter || rowStatus === statusFilter;
        const matchesTipe = !tipeFilter || rowTipe === tipeFilter;
        
        if (text.includes(filter) && matchesStatus && matchesTipe) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

function filterByStatus() {
    searchTable();
}

function filterByTipe() {
    searchTable();
}

document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data Verifikasi?',
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
</script>


@endpush