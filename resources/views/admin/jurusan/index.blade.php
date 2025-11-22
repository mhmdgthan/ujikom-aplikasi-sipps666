@extends('layouts.main')

@section('title', 'Data Jurusan')
@section('page-title', 'Data Jurusan')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/jurusan.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-actions">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama jurusan..." onkeyup="searchTable()">
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahJurusanModal">
            <i class="fas fa-plus"></i>
            Tambah Jurusan
        </button>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="jurusanTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 350px;">Nama Jurusan</th>
                        <th class="text-center" style="width: 150px;">Singkatan</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusan as $index => $item)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($jurusan->currentPage() - 1) * $jurusan->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="jurusan-info">
                                <div class="jurusan-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #2d3748;">{{ $item->nama_jurusan }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span style="background: #e6fffa; color: #234e52; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                {{ $item->singkatan }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailJurusanModal"
                                    onclick="showJurusanDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit btnEdit" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama_jurusan }}"
                                    data-singkatan="{{ $item->singkatan }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editJurusanModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.jurusan.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Jurusan</div>
                                <div class="empty-state-text">Silakan tambahkan jurusan baru dengan klik tombol "Tambah Jurusan"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jurusan->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $jurusan->firstItem() }} - {{ $jurusan->lastItem() }} dari {{ $jurusan->total() }} data
            </div>
            <div class="pagination-container">
                <nav>
                    <ul class="custom-pagination">
                        @if ($jurusan->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $jurusan->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                            </li>
                        @endif
                        @php
                            $start = max($jurusan->currentPage() - 2, 1);
                            $end = min($start + 4, $jurusan->lastPage());
                            $start = max($end - 4, 1);
                        @endphp
                        @if($start > 1)
                            <li class="page-item"><a class="page-link" href="{{ $jurusan->url(1) }}">1</a></li>
                            @if($start > 2)<li class="page-item disabled"><span class="page-link">...</span></li>@endif
                        @endif
                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $jurusan->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $jurusan->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        @if($end < $jurusan->lastPage())
                            @if($end < $jurusan->lastPage() - 1)<li class="page-item disabled"><span class="page-link">...</span></li>@endif
                            <li class="page-item"><a class="page-link" href="{{ $jurusan->url($jurusan->lastPage()) }}">{{ $jurusan->lastPage() }}</a></li>
                        @endif
                        @if ($jurusan->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $jurusan->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        <style>
        .table-footer{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-top:1px solid #e2e8f0;background:#f8fafc;border-radius:0 0 12px 12px}
        .showing-info{font-size:14px;color:#64748b;font-weight:500}
        .pagination-container{display:flex;align-items:center}
        .custom-pagination{display:flex;list-style:none;padding:0;margin:0;gap:4px;align-items:center}
        .custom-pagination .page-item{display:inline-block}
        .custom-pagination .page-link{display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 12px;font-size:14px;font-weight:500;color:#475569;background:white;border:1px solid #e2e8f0;border-radius:8px;text-decoration:none;transition:all 0.2s ease;cursor:pointer}
        .custom-pagination .page-link:hover{background:#f1f5f9;border-color:#cbd5e0;color:#1e293b;transform:translateY(-1px)}
        .custom-pagination .page-item.active .page-link{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-color:#667eea;color:white;font-weight:600;box-shadow:0 4px 12px rgba(102,126,234,0.3)}
        .custom-pagination .page-item.disabled .page-link{color:#cbd5e0;background:#f8fafc;border-color:#e2e8f0;cursor:not-allowed;pointer-events:none}
        .custom-pagination .page-link i{font-size:12px}
        </style>
        @endif
    </div>
</div>

{{-- Modals --}}
<div class="modal fade" id="tambahJurusanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Jurusan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.jurusan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_jurusan" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Singkatan <span class="text-danger">*</span></label>
                            <input type="text" name="singkatan" class="form-control" placeholder="Contoh: RPL" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailJurusanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                <h5 class="modal-title">
                    <i class="fas fa-graduation-cap"></i>
                    Detail Jurusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="detail-group">
                            <div class="detail-label">Nama Jurusan</div>
                            <div class="detail-value" id="detailNamaJurusan">-</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-group">
                            <div class="detail-label">Singkatan</div>
                            <div class="detail-value" id="detailSingkatan">-</div>
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

<div class="modal fade" id="editJurusanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Jurusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editJurusanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_jurusan" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Singkatan <span class="text-danger">*</span></label>
                            <input type="text" name="singkatan" class="form-control" required>
                        </div>
                    </div>
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
    const editButtons = document.querySelectorAll('.btnEdit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('editJurusanForm');
            const id = this.dataset.id;
            form.action = `/admin/jurusan/${id}`;
            form.querySelector('[name="nama_jurusan"]').value = this.dataset.nama || '';
            form.querySelector('[name="singkatan"]').value = this.dataset.singkatan || '';
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

    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data Jurusan?',
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

function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('jurusanTable');
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

function showJurusanDetail(id) {
    fetch(`/admin/jurusan/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailNamaJurusan').textContent = data.nama_jurusan || '-';
            document.getElementById('detailSingkatan').textContent = data.singkatan || '-';
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
</script>
@endpush