@extends('layouts.main')

@section('title', 'Data User')
@section('page-title', 'Data User')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/users.css') }}">
@endpush
@section('content')

<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama lengkap..." onkeyup="searchTable()">
            </div>
            <select class="filter-select" id="filterLevel" onchange="filterByLevel()">
                <option value="">Semua Level</option>
                <option value="kepala_sekolah">Kepala Sekolah</option>
                <option value="kesiswaan">Kesiswaan</option>
                <option value="bk">BK</option>
                <option value="guru">Guru</option>
                <option value="wali_kelas">Wali Kelas</option>
                <option value="orang_tua">Orang Tua</option>
                <option value="siswa">Siswa</option>

            </select>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
            <i class="fas fa-plus"></i>
            Tambah User
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="userTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 240px;">User</th>
                        <th style="width: 150px;">Level</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->nama_lengkap }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-level {{ 
                                $user->level == 'kepala_sekolah' ? 'kepala' : 
                                ($user->level == 'kesiswaan' ? 'kesiswaan' : 
                                ($user->level == 'bk' ? 'bk' : 
                                ($user->level == 'wali_kelas' ? 'wali' : 'ortu'))) 
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $user->level)) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-verify {{ $user->can_verify ? 'yes' : 'no' }}">
                                <i class="fas fa-{{ $user->can_verify ? 'check-circle' : 'times-circle' }}"></i>
                                {{ $user->can_verify ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $user->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailUserModal"
                                    onclick="showUserDetail({{ $user->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $user->id }}"
                                    data-username="{{ $user->username }}"
                                    data-nama="{{ $user->nama_lengkap }}"
                                    data-level="{{ $user->level }}"
                                    data-verify="{{ $user->can_verify }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data User</div>
                                <div class="empty-state-text">Silakan tambahkan user baru dengan klik tombol "Tambah User"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
            </div>
            <div class="pagination-container">
                <nav>
                    <ul class="custom-pagination">
                        {{-- Previous Button --}}
                        @if ($users->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($users->currentPage() - 2, 1);
                            $end = min($start + 4, $users->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($end < $users->lastPage())
                            @if($end < $users->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->url($users->lastPage()) }}">
                                    {{ $users->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Next Button --}}
                        @if ($users->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}">
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

{{-- Modal Tambah User --}}
<div class="modal fade" id="tambahUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i>
                    Tambah User Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username" required value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Masukkan nama lengkap" required value="{{ old('nama_lengkap') }}">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Level <span class="text-danger">*</span></label>
                            <select name="level" class="form-select" required>
                                <option value="">-- Pilih Level --</option>
                                <option value="kepala_sekolah">Kepala Sekolah</option>
                                <option value="kesiswaan">Kesiswaan</option>
                                <option value="bk">BK</option>
                                <option value="guru">Guru</option>
                                <option value="wali_kelas">Wali Kelas</option>
                                <option value="orang_tua">Orang Tua</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="can_verify" value="1" id="canVerifyTambah">
                                <label class="form-check-label" for="canVerifyTambah">
                                    Dapat Memverifikasi
                                </label>
                            </div>
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

{{-- Modal Edit User --}}
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ old('user_id') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Level <span class="text-danger">*</span></label>
                            <select name="level" class="form-select" required>
                                <option value="">-- Pilih Level --</option>
                                <option value="admin">Administrator</option>
                                <option value="kepala_sekolah">Kepala Sekolah</option>
                                <option value="kesiswaan">Kesiswaan</option>
                                <option value="bk">BK</option>
                                <option value="guru">Guru</option>
                                <option value="wali_kelas">Wali Kelas</option>
                                <option value="orang_tua">Orang Tua</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="can_verify" value="1" id="canVerifyEdit">
                                <label class="form-check-label" for="canVerifyEdit">
                                    Dapat Memverifikasi
                                </label>
                            </div>
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

{{-- Modal Detail User --}}
<div class="modal fade" id="detailUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4299e1, #3182ce);">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="userDetailContent">
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
// Edit Modal Handler
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('editUserForm');
            const id = this.dataset.id;
            form.action = `/admin/users/${id}`;
            form.querySelector('[name="user_id"]').value = id;
            form.querySelector('[name="username"]').value = this.dataset.username || '';
            form.querySelector('[name="nama_lengkap"]').value = this.dataset.nama || '';
            form.querySelector('[name="level"]').value = this.dataset.level || '';
            form.querySelector('[name="can_verify"]').checked = this.dataset.verify == 1;
            form.querySelector('[name="password"]').value = ''; // Kosongkan password
        });
    });

    // Fill edit form with old values if validation error
    @if($errors->any() && old('_method') == 'PUT')
    const editForm = document.getElementById('editUserForm');
    editForm.action = `/admin/users/{{ old('user_id', '') }}`;
    editForm.querySelector('[name="username"]').value = '{{ old('username') }}';
    editForm.querySelector('[name="nama_lengkap"]').value = '{{ old('nama_lengkap') }}';
    editForm.querySelector('[name="level"]').value = '{{ old('level') }}';
    editForm.querySelector('[name="can_verify"]').checked = {{ old('can_verify') ? 'true' : 'false' }};
    @endif

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
        html: '@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach',
        showConfirmButton: false,
        timer: 4000,
        toast: true,
        position: 'top-end'
    }).then(() => {
        // Show modal again after closing SweetAlert
        @if(old('_method') == 'PUT')
            $('#editUserModal').modal('show');
        @else
            $('#tambahUserModal').modal('show');
        @endif
    });
    @endif

    // Delete Confirmation
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data User?',
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

// Show User Detail
function showUserDetail(id) {
    fetch(`{{ route('admin.users.index') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('userDetailContent');
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Username</div>
                        <div class="detail-value">${data.username}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Lengkap</div>
                        <div class="detail-value">${data.nama_lengkap}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Level</div>
                        <div class="detail-value">${data.level.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Dapat Verifikasi</div>
                        <div class="detail-value">${data.can_verify ? 'Ya' : 'Tidak'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status Aktif</div>
                        <div class="detail-value">${data.is_active ? 'Aktif' : 'Tidak Aktif'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Dibuat</div>
                        <div class="detail-value">${new Date(data.created_at).toLocaleDateString('id-ID')}</div>
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
    const table = document.getElementById('userTable');
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

// Filter by Level
function filterByLevel() {
    const filter = document.getElementById('filterLevel').value.toLowerCase();
    const table = document.getElementById('userTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const level = row.getElementsByTagName('td')[2];
        if (level) {
            const levelText = level.textContent.toLowerCase();
            if (filter === '' || levelText.includes(filter.replace('_', ' '))) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
}
</script>
@endpush