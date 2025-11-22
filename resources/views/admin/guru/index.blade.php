@extends('layouts.main')

@section('title', 'Data Guru')
@section('page-title', 'Manajemen Data Guru')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/guru.css') }}">
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama guru atau NIP..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahGuruModal">
            <i class="fas fa-plus"></i>
            Tambah Guru
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="guruTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 350px;">Nama Guru & Username</th>
                        <th style="width: 180px;">NIP</th>
                        <th style="width: 220px;">Bidang Studi</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru as $index => $item)
                    <tr data-status="{{ strtolower($item->status) }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($guru->currentPage() - 1) * $guru->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="guru-info">
                                <div class="guru-avatar">
                                    {{ strtoupper(substr($item->nama_guru, 0, 1)) }}
                                </div>
                                <div class="guru-details">
                                    <div class="guru-name">{{ $item->nama_guru }}</div>
                                    @if($item->user)
                                        <div class="guru-username">
                                            <i class="fas fa-user"></i>
                                            {{ $item->user->username }}
                                        </div>
                                    @else
                                        <div class="guru-nip">Tidak ada akun</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->nip }}</td>
                        <td>
                            <div style="font-weight: 500; color: #2d3748;">{{ $item->bidang_studi }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge-status {{ strtolower($item->status) }}">
                                <i class="fas fa-{{ $item->status == 'Aktif' ? 'check-circle' : 'times-circle' }}"></i>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailGuruModal"
                                    onclick="showGuruDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-user="{{ $item->user_id }}"
                                    data-id="{{ $item->id }}"
                                    data-nip="{{ $item->nip }}"
                                    data-nama="{{ $item->nama_guru }}"
                                    data-gender="{{ $item->jenis_kelamin }}"
                                    data-bidang="{{ $item->bidang_studi }}"
                                    data-email="{{ $item->email }}"
                                    data-telp="{{ $item->no_telp }}"
                                    data-status="{{ $item->status }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editGuruModal">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.guru.destroy', ['guru' => $item->id]) }}" method="POST" class="d-inline form-delete">
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
                                <div class="empty-state-title">Belum Ada Data Guru</div>
                                <div class="empty-state-text">Silakan tambahkan data guru baru dengan klik tombol "Tambah Guru"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($guru->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $guru->firstItem() }} - {{ $guru->lastItem() }} dari {{ $guru->total() }} data
            </div>
            <div class="pagination-container">
                <nav>
                    <ul class="custom-pagination">
                        {{-- Previous Button --}}
                        @if ($guru->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $guru->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($guru->currentPage() - 2, 1);
                            $end = min($start + 4, $guru->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $guru->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $guru->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $guru->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($end < $guru->lastPage())
                            @if($end < $guru->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $guru->url($guru->lastPage()) }}">
                                    {{ $guru->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Next Button --}}
                        @if ($guru->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $guru->nextPageUrl() }}">
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

{{-- Modal Tambah Guru --}}
<div class="modal fade" id="tambahGuruModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i>
                    Tambah Guru Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.guru.store') }}" method="POST" id="formTambahGuru">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Pilih User Guru <span class="text-danger">*</span></label>
                            <select name="user_id" id="userSelectAdd" class="form-select" required>
                                <option value="">-- Pilih User Level Guru --</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->id }}" 
                                        data-nama="{{ $user->nama_lengkap }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }} ({{ $user->username }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="user-info-box" id="userInfoAdd">
                                <div class="user-info-item">
                                    <i class="fas fa-user"></i>
                                    <strong>Username:</strong> <span id="userUsernameAdd">-</span>
                                </div>
                                <div class="user-info-item">
                                    <i class="fas fa-id-card"></i>
                                    <strong>Nama Lengkap:</strong> <span id="userNamaAdd">-</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="nama_guru" id="namaGuruAdd" value="{{ old('nama_guru') }}">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" required value="{{ old('nip') }}">
                            @error('nip')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bidang Studi <span class="text-danger">*</span></label>
                            <input type="text" name="bidang_studi" class="form-control" placeholder="Contoh: Matematika" required value="{{ old('bidang_studi') }}">
                            @error('bidang_studi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="guru@example.com" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_telp') }}">
                            @error('no_telp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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

{{-- Modal Edit Guru --}}
<div class="modal fade" id="editGuruModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Guru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editGuruForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">User Guru <span class="text-danger">*</span></label>
                            <select name="user_id" id="userSelectEdit" class="form-select" required>
                                <option value="">-- Pilih User Level Guru --</option>
                            </select>
                            <div class="user-info-box" id="userInfoEdit">
                                <div class="user-info-item">
                                    <i class="fas fa-user"></i>
                                    <strong>Username:</strong> <span id="userUsernameEdit">-</span>
                                </div>
                                <div class="user-info-item">
                                    <i class="fas fa-id-card"></i>
                                    <strong>Nama Lengkap:</strong> <span id="userNamaEdit">-</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="nama_guru" id="namaGuruEdit">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bidang Studi <span class="text-danger">*</span></label>
                            <input type="text" name="bidang_studi" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telp" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
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

{{-- Modal Detail Guru --}}
<div class="modal fade" id="detailGuruModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4299e1, #3182ce);">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Guru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="guruDetailContent">
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
    // Handle User Select - Modal Tambah
    const userSelectAdd = document.getElementById('userSelectAdd');
    const userInfoAdd = document.getElementById('userInfoAdd');
    const namaGuruAdd = document.getElementById('namaGuruAdd');

    if (userSelectAdd) {
        userSelectAdd.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                const nama = selectedOption.dataset.nama;
                const username = selectedOption.textContent.match(/\(([^)]+)\)/)[1];
                
                // Update info box
                document.getElementById('userUsernameAdd').textContent = username;
                document.getElementById('userNamaAdd').textContent = nama;
                userInfoAdd.classList.add('show');
                
                // Auto fill nama guru
                namaGuruAdd.value = nama;
            } else {
                userInfoAdd.classList.remove('show');
                namaGuruAdd.value = '';
            }
        });
    }

    // Handle User Select - Modal Edit
    const userSelectEdit = document.getElementById('userSelectEdit');
    const userInfoEdit = document.getElementById('userInfoEdit');
    const namaGuruEdit = document.getElementById('namaGuruEdit');

    if (userSelectEdit) {
        userSelectEdit.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                const nama = selectedOption.dataset.nama;
                const username = selectedOption.textContent.match(/\(([^)]+)\)/)[1];
                
                // Update info box
                document.getElementById('userUsernameEdit').textContent = username;
                document.getElementById('userNamaEdit').textContent = nama;
                userInfoEdit.classList.add('show');
                
                // Auto fill nama guru
                namaGuruEdit.value = nama;
            } else {
                userInfoEdit.classList.remove('show');
                namaGuruEdit.value = '';
            }
        });
    }

    // Edit Modal Handler
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('editGuruForm');
            const id = this.dataset.id;
            const userId = this.dataset.user;
            
            // Set form action dengan route yang benar
            form.action = `{{ url('admin/guru') }}/${id}`;
            
            // Populate user select dengan available users + current user
            populateEditUserSelect(userId).then(() => {
                // Set values
                form.querySelector('[name="user_id"]').value = userId || '';
                form.querySelector('[name="nip"]').value = this.dataset.nip || '';
                form.querySelector('[name="nama_guru"]').value = this.dataset.nama || '';
                form.querySelector('[name="jenis_kelamin"]').value = this.dataset.gender || '';
                form.querySelector('[name="bidang_studi"]').value = this.dataset.bidang || '';
                form.querySelector('[name="email"]').value = this.dataset.email || '';
                form.querySelector('[name="no_telp"]').value = this.dataset.telp || '';
                form.querySelector('[name="status"]').value = this.dataset.status || '';
                
                // Trigger change to show user info
                if (userId) {
                    userSelectEdit.dispatchEvent(new Event('change'));
                }
            });
        });
    });

    // Function to populate edit user select
    async function populateEditUserSelect(currentUserId) {
        try {
            const response = await fetch(`{{ route('admin.guru.index') }}/get-available-users/${currentUserId}`);
            const data = await response.json();
            
            userSelectEdit.innerHTML = '<option value="">-- Pilih User Level Guru --</option>';
            
            data.users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = `${user.nama_lengkap} (${user.username})`;
                option.dataset.nama = user.nama_lengkap;
                userSelectEdit.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading users:', error);
        }
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
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        position: 'top-end'
    });
    @endif

    // Delete Confirmation
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Data Guru?',
                text: "Data guru akan dihapus permanen!",
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

    // Auto-show modal on validation errors
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
        @if(old('_method') === 'PUT')
            const editModal = new bootstrap.Modal(document.getElementById('editGuruModal'));
            editModal.show();
        @else
            const addModal = new bootstrap.Modal(document.getElementById('tambahGuruModal'));
            addModal.show();
            
            // Trigger user select if old value exists
            @if(old('user_id'))
                setTimeout(() => {
                    userSelectAdd.value = "{{ old('user_id') }}";
                    userSelectAdd.dispatchEvent(new Event('change'));
                }, 100);
            @endif
        @endif
    });
    @endif
});

// Search Function
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('guruTable');
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

// Show Guru Detail
function showGuruDetail(id) {
    fetch(`{{ url('admin/guru') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('guruDetailContent');
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Guru</div>
                        <div class="detail-value">${data.nama_guru}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">NIP</div>
                        <div class="detail-value">${data.nip}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Jenis Kelamin</div>
                        <div class="detail-value">${data.jenis_kelamin}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Bidang Studi</div>
                        <div class="detail-value">${data.bidang_studi}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">${data.email || '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">No. Telepon</div>
                        <div class="detail-value">${data.no_telp || '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">${data.status}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Username</div>
                        <div class="detail-value">${data.user ? data.user.username : 'Tidak ada akun'}</div>
                    </div>
                </div>

            `;
        })
        .catch(error => console.error('Error:', error));
}

// Filter by Status
function filterByStatus() {
    const filter = document.getElementById('filterStatus').value.toLowerCase();
    const table = document.getElementById('guruTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const status = row.dataset.status;
        
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const text = row.textContent.toLowerCase();
        const matchesSearch = !searchInput || text.includes(searchInput);
        
        if ((!filter || status === filter) && matchesSearch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}
</script>
@endpush