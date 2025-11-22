@extends('layouts.main')

@section('title', 'Data Jenis Pelanggaran')
@section('page-title', 'Manajemen Jenis Pelanggaran')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/jenis-pelanggaran.css') }}">
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama pelanggaran atau sanksi_rekomendasi..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
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
            Tambah Jenis Pelanggaran
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="pelanggaranTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 250px;">Nama Pelanggaran</th>
                        <th class="text-center" style="width: 100px;">Poin</th>
                        <th class="text-center" style="width: 150px;">Kategori</th>
                        <th style="width: 180px;">Sanksi</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisPelanggaran as $index => $item)
                    <tr data-kategori="{{ strtolower($item->kategori) }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($jenisPelanggaran->currentPage() - 1) * $jenisPelanggaran->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="pelanggaran-info">
                                <div class="pelanggaran-avatar">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="pelanggaran-details">
                                    <div class="pelanggaran-name">{{ $item->nama_pelanggaran }}</div>
                                    <div class="pelanggaran-poin">
                                        <i class="fas fa-minus-circle"></i> {{ $item->poin }} Poin
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-poin">
                                <i class="fas fa-exclamation"></i>
                                {{ $item->poin }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-kategori {{ $item->kategoriPelanggaran?->nama_kategori ? strtolower($item->kategoriPelanggaran->nama_kategori) : 'default' }}">
                                {{ $item->kategoriPelanggaran?->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 500; color: #2d3748;">{{ $item->sanksi ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaranModal"
                                    onclick="showPelanggaranDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama_pelanggaran }}"
                                    data-poin="{{ $item->poin }}"
                                    data-kategori="{{ $item->kategori_pelanggaran_id }}"
                                    data-sanksi="{{ $item->sanksi }}"
                                    data-keterangan="{{ $item->keterangan }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPelanggaranModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.jenis-pelanggaran.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Jenis Pelanggaran</div>
                                <div class="empty-state-text">Silakan tambahkan data jenis pelanggaran baru dengan klik tombol "Tambah Jenis Pelanggaran"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

       @if($jenisPelanggaran->hasPages())
<div class="table-footer">
    <div class="showing-info">
        Menampilkan {{ $jenisPelanggaran->firstItem() }} - {{ $jenisPelanggaran->lastItem() }} dari {{ $jenisPelanggaran->total() }} data
    </div>
    <div class="pagination-container">
        <nav>
            <ul class="custom-pagination">
                {{-- Previous Button --}}
                @if ($jenisPelanggaran->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $jenisPelanggaran->previousPageUrl() }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @php
                    $start = max($jenisPelanggaran->currentPage() - 2, 1);
                    $end = min($start + 4, $jenisPelanggaran->lastPage());
                    $start = max($end - 4, 1);
                @endphp

                @if($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $jenisPelanggaran->url(1) }}">1</a>
                    </li>
                    @if($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    <li class="page-item {{ $i == $jenisPelanggaran->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $jenisPelanggaran->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if($end < $jenisPelanggaran->lastPage())
                    @if($end < $jenisPelanggaran->lastPage() - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $jenisPelanggaran->url($jenisPelanggaran->lastPage()) }}">
                            {{ $jenisPelanggaran->lastPage() }}
                        </a>
                    </li>
                @endif

                {{-- Next Button --}}
                @if ($jenisPelanggaran->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $jenisPelanggaran->nextPageUrl() }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
@endif


       <style>
/* Table Footer */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 0 0 12px 12px;
}

.showing-info {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

/* Custom Pagination */
.pagination-container {
    display: flex;
    align-items: center;
}

.custom-pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 4px;
    align-items: center;
}

.custom-pagination .page-item {
    display: inline-block;
}

.custom-pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 12px;
    font-size: 14px;
    font-weight: 500;
    color: #475569;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.custom-pagination .page-link:hover {
    background: #f1f5f9;
    border-color: #cbd5e0;
    color: #1e293b;
    transform: translateY(-1px);
}

.custom-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.custom-pagination .page-item.active .page-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
}

.custom-pagination .page-item.disabled .page-link {
    color: #cbd5e0;
    background: #f8fafc;
    border-color: #e2e8f0;
    cursor: not-allowed;
    pointer-events: none;
}

.custom-pagination .page-link i {
    font-size: 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .table-footer {
        flex-direction: column;
        gap: 16px;
        padding: 16px;
    }

    .showing-info {
        font-size: 13px;
    }

    .custom-pagination .page-link {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        font-size: 13px;
    }
}
</style>
    </div>
</div>

{{-- Modal Detail Jenis Pelanggaran --}}
<div class="modal fade" id="detailPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Detail Jenis Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Nama Pelanggaran</div>
                            <div class="detail-value" id="detailNamaPelanggaran">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Poin</div>
                            <div class="detail-value" id="detailPoinPelanggaran">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Kategori</div>
                            <div class="detail-value" id="detailKategoriPelanggaran">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Sanksi</div>
                            <div class="detail-value" id="detailSanksi">-</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="detail-group">
                            <div class="detail-label">Keterangan</div>
                            <div class="detail-value" id="detailKeterangan">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Jenis Pelanggaran --}}
<div class="modal fade" id="tambahPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus"></i>
                    Tambah Jenis Pelanggaran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.jenis-pelanggaran.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @include('admin.jenis-pelanggaran.partials.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Jenis Pelanggaran --}}
<div class="modal fade" id="editPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Jenis Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPelanggaranForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @include('admin.jenis-pelanggaran.partials.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal update">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Modal Handler
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('editPelanggaranForm');
            const id = this.dataset.id;
            form.action = `/admin/jenis-pelanggaran/${id}`;
            form.querySelector('[name="nama_pelanggaran"]').value = this.dataset.nama || '';
            form.querySelector('[name="poin"]').value = this.dataset.poin || '';
            form.querySelector('[name="kategori_pelanggaran_id"]').value = this.dataset.kategori || '';
            form.querySelector('[name="sanksi"]').value = this.dataset.sanksi || '';
            form.querySelector('[name="keterangan"]').value = this.dataset.keterangan || '';
        });
    });

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
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
    @endif

    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal!',
        html: '<ul style="text-align: left; margin: 0; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        showConfirmButton: false,
        timer: 4000,
        toast: true,
        position: 'top-end'
    });
    @endif

    // Delete Confirmation
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data Jenis Pelanggaran?',
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
});

// Search Function
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('pelanggaranTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();
        
        // Check if row should be visible based on current filter
        const kategoriFilter = document.getElementById('filterKategori').value;
        const rowKategori = row.dataset.kategori;
        const matchesKategori = !kategoriFilter || rowKategori === kategoriFilter;
        
        if (text.includes(filter) && matchesKategori) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Filter by Kategori Function
function filterByKategori() {
    const select = document.getElementById('filterKategori');
    const filter = select.value.toLowerCase();
    const table = document.getElementById('pelanggaranTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const kategori = row.dataset.kategori;
        
        // Check if row should be visible based on current search
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const text = row.textContent.toLowerCase();
        const matchesSearch = !searchInput || text.includes(searchInput);
        
        if ((!filter || kategori === filter) && matchesSearch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Show Pelanggaran Detail Function
function showPelanggaranDetail(id) {
    fetch(`/admin/jenis-pelanggaran/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailNamaPelanggaran').textContent = data.nama_pelanggaran || '-';
            document.getElementById('detailPoinPelanggaran').textContent = data.poin ? data.poin + ' Poin' : '-';
            document.getElementById('detailKategoriPelanggaran').textContent = data.kategori_pelanggaran?.nama_kategori || '-';
            document.getElementById('detailSanksi').textContent = data.sanksi || '-';
            document.getElementById('detailKeterangan').textContent = data.keterangan || '-';
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail jenis pelanggaran',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        });
}
</script>
@endpush