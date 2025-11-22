@extends('layouts.main')

@section('title', 'Data Wali Kelas')
@section('page-title', 'Data Wali Kelas')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/wali-kelas.css') }}">
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama wali kelas atau kelas..." onkeyup="searchTable()">
            </div>
            <select class="filter-select" id="filterStatus" onchange="filterByStatus()">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahWaliKelasModal">
            <i class="fas fa-plus"></i>
            Tambah Wali Kelas
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="waliKelasTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 300px;">Wali Kelas</th>
                        <th class="text-center" style="width: 150px;">Kelas</th>
                        <th style="width: 200px;">Tahun Ajaran</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($waliKelas as $index => $item)
                    <tr data-status="{{ $item->tanggal_selesai ? 'selesai' : 'aktif' }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($waliKelas->currentPage() - 1) * $waliKelas->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="walikelas-info">
                                <div class="walikelas-avatar">
                                    {{ strtoupper(substr($item->guru ? $item->guru->nama_lengkap : '?', 0, 1)) }}
                                </div>
                                <div class="walikelas-details">
                                    <div class="walikelas-name">
                                        {{ $item->guru ? $item->guru->nama_lengkap : 'Guru Tidak Ditemukan' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-kelas">{{ $item->kelas ? $item->kelas->nama_kelas : '-' }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->tahunAjaran ? $item->tahunAjaran->tahun_ajaran : '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->tahunAjaran ? ucfirst($item->tahunAjaran->semester) : '-' }}</div>
                        </td>

                        <td class="text-center">
                            <span class="badge-status {{ $item->tanggal_selesai ? 'selesai' : 'aktif' }}">
                                <i class="fas fa-{{ $item->tanggal_selesai ? 'check-circle' : 'clock' }}"></i>
                                {{ $item->tanggal_selesai ? 'Selesai' : 'Aktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailWaliKelasModal"
                                    onclick="showWaliKelasDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-guru="{{ $item->guru_id }}"
                                    data-kelas="{{ $item->kelas_id }}"
                                    data-tahun="{{ $item->tahun_ajaran_id }}"
                                    data-mulai="{{ $item->tanggal_mulai }}"
                                    data-selesai="{{ $item->tanggal_selesai }}"
                                    data-catatan="{{ $item->catatan }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editWaliKelasModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                @if(!$item->tanggal_selesai)
                                <button type="button" class="btn-action finish btn-selesai-periode" 
                                        data-id="{{ $item->id }}" 
                                        title="Selesaikan Periode">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif

                                <form action="{{ route('admin.wali-kelas.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Wali Kelas</div>
                                <div class="empty-state-text">Silakan tambahkan wali kelas baru dengan klik tombol "Tambah Wali Kelas"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($waliKelas->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $waliKelas->firstItem() }} - {{ $waliKelas->lastItem() }} dari {{ $waliKelas->total() }} data
            </div>
            <div class="pagination-container">
                <nav>
                    <ul class="custom-pagination">
                        {{-- Previous Button --}}
                        @if ($waliKelas->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $waliKelas->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($waliKelas->currentPage() - 2, 1);
                            $end = min($start + 4, $waliKelas->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $waliKelas->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $waliKelas->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $waliKelas->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($end < $waliKelas->lastPage())
                            @if($end < $waliKelas->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $waliKelas->url($waliKelas->lastPage()) }}">
                                    {{ $waliKelas->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Next Button --}}
                        @if ($waliKelas->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $waliKelas->nextPageUrl() }}">
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

{{-- Modal Tambah Wali Kelas --}}
<div class="modal fade" id="tambahWaliKelasModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Wali Kelas Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.wali-kelas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @include('admin.wali-kelas.partials.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Wali Kelas --}}
<div class="modal fade" id="editWaliKelasModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Wali Kelas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editWaliKelasForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @include('admin.wali-kelas.partials.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal update">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail Wali Kelas --}}
<div class="modal fade" id="detailWaliKelasModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4299e1, #3182ce);">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Wali Kelas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="waliKelasDetailContent">
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
document.addEventListener('DOMContentLoaded', function() {
    // Edit Modal Handler
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('editWaliKelasForm');
            const id = this.dataset.id;
            form.action = `{{ route('admin.wali-kelas.index') }}/${id}`;
            form.querySelector('[name="guru_id"]').value = this.dataset.guru || '';
            form.querySelector('[name="kelas_id"]').value = this.dataset.kelas || '';
            form.querySelector('[name="tahun_ajaran_id"]').value = this.dataset.tahun || '';
            form.querySelector('[name="tanggal_mulai"]').value = this.dataset.mulai || '';
            form.querySelector('[name="tanggal_selesai"]').value = this.dataset.selesai || '';
            form.querySelector('[name="catatan"]').value = this.dataset.catatan || '';
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
        confirmButtonColor: '#e53e3e',
    });
    @endif

    // Selesaikan Periode Confirmation
    document.querySelectorAll('.btn-selesai-periode').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Selesaikan Periode?',
                text: "Wali kelas ini akan dianggap telah menyelesaikan tugasnya di periode ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4299e1',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Ya, Selesaikan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const formSelesai = document.createElement('form');
                    formSelesai.method = 'POST';
                    formSelesai.action = `{{ route('admin.wali-kelas.index') }}/${id}/selesai`;
                    formSelesai.innerHTML = `@csrf`;
                    document.body.appendChild(formSelesai);
                    formSelesai.submit();
                }
            });
        });
    });

    // Delete Confirmation
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data Wali Kelas?',
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

// Show Wali Kelas Detail
function showWaliKelasDetail(id) {
    fetch(`{{ route('admin.wali-kelas.index') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('waliKelasDetailContent');
            const tanggalMulai = new Date(data.tanggal_mulai).toLocaleDateString('id-ID');
            const tanggalSelesai = data.tanggal_selesai ? new Date(data.tanggal_selesai).toLocaleDateString('id-ID') : 'Belum selesai';
            
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Wali Kelas</div>
                        <div class="detail-value">${data.guru ? data.guru.nama_lengkap : 'Tidak tersedia'}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kelas</div>
                        <div class="detail-value">${data.kelas.nama_kelas}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tahun Ajaran</div>
                        <div class="detail-value">${data.tahun_ajaran.tahun_ajaran} - ${data.tahun_ajaran.semester.charAt(0).toUpperCase() + data.tahun_ajaran.semester.slice(1)}</div>
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
                        <div class="detail-label">Status</div>
                        <div class="detail-value">${data.tanggal_selesai ? 'Selesai' : 'Aktif'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Dibuat Pada</div>
                        <div class="detail-value">${new Date(data.created_at).toLocaleDateString('id-ID')}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Catatan</div>
                        <div class="detail-value">${data.catatan || 'Tidak ada catatan'}</div>
                    </div>
                </div>
            `;
        })
        .catch(error => console.error('Error:', error));
}

// Search Function
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('waliKelasTable');
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

// Filter by Status
function filterByStatus() {
    const filter = document.getElementById('filterStatus').value.toLowerCase();
    const table = document.getElementById('waliKelasTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const status = row.getAttribute('data-status');
        if (filter === '' || status === filter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}
</script>
@endpush