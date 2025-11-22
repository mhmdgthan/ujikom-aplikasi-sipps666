@extends('layouts.main')

@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/kelas.css') }}">
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama kelas atau jurusan..." onkeyup="searchTable()">
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
            <i class="fas fa-plus"></i>
            Tambah Kelas
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="kelasTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 250px;">Kelas</th>
                        <th class="text-center" style="width: 120px;">Tingkat</th>
                        <th style="width: 180px;">Jurusan</th>
                        <th class="text-center" style="width: 120px;">Kapasitas</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $index => $item)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($kelas->currentPage() - 1) * $kelas->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="kelas-info">
                                <div class="kelas-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="kelas-details">
                                    <div class="kelas-name">{{ $item->tingkat_kelas }} {{ $item->jurusan ? $item->jurusan->singkatan : '' }}</div>
                                    <div class="kelas-jurusan">{{ $item->jurusan ? $item->jurusan->nama_jurusan : '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge" style="background: #e6fffa; color: #234e52; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                {{ $item->tingkat_kelas }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->jurusan ? $item->jurusan->nama_jurusan : '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->jurusan ? $item->jurusan->singkatan : '-' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge-kapasitas">
                                <i class="fas fa-users"></i>
                                {{ $item->kapasitas }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailKelasModal"
                                    onclick="showKelasDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit btnEdit" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-tingkat="{{ $item->tingkat_kelas }}"
                                    data-jurusan="{{ $item->jurusan_id }}"
                                    data-kapasitas="{{ $item->kapasitas }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editKelasModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-chalkboard"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Kelas</div>
                                <div class="empty-state-text">Silakan tambahkan kelas baru dengan klik tombol "Tambah Kelas"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kelas->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $kelas->firstItem() }} - {{ $kelas->lastItem() }} dari {{ $kelas->total() }} data
            </div>
            <div class="pagination-container">
                <nav>
                    <ul class="custom-pagination">
                        {{-- Previous Button --}}
                        @if ($kelas->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $kelas->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($kelas->currentPage() - 2, 1);
                            $end = min($start + 4, $kelas->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $kelas->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $kelas->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $kelas->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($end < $kelas->lastPage())
                            @if($end < $kelas->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $kelas->url($kelas->lastPage()) }}">
                                    {{ $kelas->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Next Button --}}
                        @if ($kelas->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $kelas->nextPageUrl() }}">
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

{{-- Modal Tambah Kelas --}}
<div class="modal fade" id="tambahKelasModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Kelas Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
                            <select name="tingkat_kelas" class="form-select" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jurusan <span class="text-danger">*</span></label>
                            <select name="jurusan_id" class="form-select" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kapasitas Siswa <span class="text-danger">*</span></label>
                            <input type="number" name="kapasitas" class="form-control" placeholder="Contoh: 32" min="1" required>
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

{{-- Modal Detail Kelas --}}
<div class="modal fade" id="detailKelasModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                <h5 class="modal-title">
                    <i class="fas fa-chalkboard"></i>
                    Detail Kelas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Nama Kelas</div>
                            <div class="detail-value" id="detailNamaKelas">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Jurusan</div>
                            <div class="detail-value" id="detailJurusan">-</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Kapasitas</div>
                            <div class="detail-value" id="detailKapasitas">-</div>
                        </div>
                    </div>
                 
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Tingkat</div>
                            <div class="detail-value" id="detailTingkat">-</div>
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

{{-- Modal Edit Kelas --}}
<div class="modal fade" id="editKelasModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Kelas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editKelasForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
                            <select name="tingkat_kelas" class="form-select" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jurusan <span class="text-danger">*</span></label>
                            <select name="jurusan_id" class="form-select" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($jurusan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kapasitas Siswa <span class="text-danger">*</span></label>
                            <input type="number" name="kapasitas" class="form-control" min="1" required>
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
// Edit Modal Handler
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btnEdit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('editKelasForm');
            const id = this.dataset.id;
            form.action = `/admin/kelas/${id}`;

            // Set values dari data attributes
            form.querySelector('[name="tingkat_kelas"]').value = this.dataset.tingkat || '';
            form.querySelector('[name="jurusan_id"]').value = this.dataset.jurusan || '';
            form.querySelector('[name="kapasitas"]').value = this.dataset.kapasitas || '';
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

    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal!',
        html: '<ul style="text-align: left; margin: 0; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        confirmButtonColor: '#e53e3e',
    });
    @endif

    // Delete Confirmation
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data Kelas?',
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
    const table = document.getElementById('kelasTable');
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

// Show Kelas Detail Function
function showKelasDetail(id) {
    fetch(`/admin/kelas/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailNamaKelas').textContent = data.nama_kelas || '-';
            document.getElementById('detailJurusan').textContent = data.jurusan ? data.jurusan.nama_jurusan : '-';
            document.getElementById('detailKapasitas').textContent = data.kapasitas ? data.kapasitas + ' Siswa' : '-';
            document.getElementById('detailTingkat').textContent = data.tingkat_kelas || '-';
            


        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail kelas',
                confirmButtonColor: '#e53e3e'
            });
        });
}
</script>
@endpush