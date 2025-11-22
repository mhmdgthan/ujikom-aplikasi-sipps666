@extends('layouts.main')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/siswa.css') }}">
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIS, atau NISN..." onchange="this.form.submit()">
            </form>
            <form action="{{ route('admin.siswa.index') }}" method="GET">
                <select name="kelas_id" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
            <i class="fas fa-plus"></i>
            Tambah Siswa
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 300px;">Siswa</th>
                        <th style="width: 150px;">Kelas</th>
                        <th style="width: 250px;">Tempat, Tanggal Lahir</th>
                        <th class="text-center" style="width: 150px;">Jenis Kelamin</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $item)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($siswa->currentPage() - 1) * $siswa->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="student-info">
                                @if($item->foto)
                                    <img src="{{ $item->foto && str_starts_with($item->foto, 'siswa/') ? asset('storage/' . $item->foto) : asset('uploads/siswa/' . $item->foto) }}" alt="Foto" class="student-avatar clickable-photo" onclick="previewPhoto('{{ $item->foto && str_starts_with($item->foto, 'siswa/') ? asset('storage/' . $item->foto) : asset('uploads/siswa/' . $item->foto) }}', '{{ $item->user->nama_lengkap ?? 'Siswa' }}')" title="Klik untuk memperbesar">
                                @else
                                    <div class="student-avatar" style="background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px;">
                                        {{ substr($item->user->nama_lengkap ?? 'N', 0, 1) }}
                                    </div>
                                @endif
                                <div class="student-details">
                                    <div class="student-name">{{ $item->user->nama_lengkap ?? '-' }}</div>
                                    <div class="student-id">NIS: {{ $item->nis }} • NISN: {{ $item->nisn }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #2d3748;">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                        </td>
                        <td>
                            {{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <span class="badge-gender {{ $item->jenis_kelamin == 'L' ? 'male' : 'female' }}">
                                <i class="fas fa-{{ $item->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
                                {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailSiswaModal"
                                    onclick="showSiswaDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-user="{{ $item->user_id }}"
                                    data-nis="{{ $item->nis }}"
                                    data-nisn="{{ $item->nisn }}"
                                    data-nama="{{ $item->user->nama_lengkap ?? '' }}"
                                    data-tempat="{{ $item->tempat_lahir }}"
                                    data-tanggal="{{ $item->tanggal_lahir }}"
                                    data-kelas="{{ $item->kelas_id }}"
                                    data-jk="{{ $item->jenis_kelamin }}"
                                    data-agama="{{ $item->agama }}"
                                    data-no="{{ $item->no_telepon }}"
                                    data-alamat="{{ $item->alamat ?? '' }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editSiswaModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Siswa</div>
                                <div class="empty-state-text">Silakan tambahkan siswa baru dengan klik tombol "Tambah Siswa"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswa->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }} dari {{ $siswa->total() }} data
            </div>
            <div class="pagination-container">
                <nav>
                    <ul class="custom-pagination">
                        {{-- Previous Button --}}
                        @if ($siswa->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $siswa->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max($siswa->currentPage() - 2, 1);
                            $end = min($start + 4, $siswa->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $siswa->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $siswa->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $siswa->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($end < $siswa->lastPage())
                            @if($end < $siswa->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $siswa->url($siswa->lastPage()) }}">
                                    {{ $siswa->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Next Button --}}
                        @if ($siswa->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $siswa->nextPageUrl() }}">
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

        /* Clickable Photo Styles */
        .clickable-photo {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .clickable-photo:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            opacity: 0.9;
        }

        .detail-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e2e8f0;
            margin-bottom: 15px;
        }

        .detail-photo-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 48px;
            margin: 0 auto 15px;
            border: 3px solid #e2e8f0;
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

{{-- Modal Tambah Siswa --}}
<div class="modal fade" id="tambahSiswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i>
                    Tambah Siswa Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">User Siswa <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Pilih User Siswa --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }} ({{ $user->username }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIS <span class="text-danger">*</span></label>
                            <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN" required>
                        </div>



                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Contoh: Jakarta" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Agama <span class="text-danger">*</span></label>
                            <select name="agama" class="form-select" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" placeholder="Contoh: 081234567890">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Foto Siswa</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
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

{{-- Modal Detail Siswa --}}
<div class="modal fade" id="detailSiswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                <h5 class="modal-title">
                    <i class="fas fa-user-graduate"></i>
                    Detail Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div id="detailFoto"></div>
                        <div class="detail-group">
                            <div class="detail-label">NIS</div>
                            <div class="detail-value" id="detailNis">-</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">NISN</div>
                            <div class="detail-value" id="detailNisn">-</div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="detail-group">
                                    <div class="detail-label">Nama Lengkap</div>
                                    <div class="detail-value" id="detailNama">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <div class="detail-label">Kelas</div>
                                    <div class="detail-value" id="detailKelas">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Jenis Kelamin</div>
                                <div class="detail-value" id="detailJenisKelamin">-</div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <div class="detail-label">Tempat Lahir</div>
                                    <div class="detail-value" id="detailTempatLahir">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <div class="detail-label">Tanggal Lahir</div>
                                    <div class="detail-value" id="detailTanggalLahir">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <div class="detail-label">Agama</div>
                                    <div class="detail-value" id="detailAgama">-</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <div class="detail-label">No. Telepon</div>
                                    <div class="detail-value" id="detailNoTelepon">-</div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="detail-group">
                                    <div class="detail-label">Alamat</div>
                                    <div class="detail-value" id="detailAlamat">-</div>
                                </div>
                            </div>
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

{{-- Modal Edit Siswa --}}
<div class="modal fade" id="editSiswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSiswaForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">User Siswa <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Pilih User Siswa --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }} ({{ $user->username }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIS <span class="text-danger">*</span></label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control" required>
                        </div>



                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Agama <span class="text-danger">*</span></label>
                            <select name="agama" class="form-select" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Foto Siswa</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" required></textarea>
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
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = document.getElementById('editSiswaForm');
            const id = this.dataset.id;
            form.action = `/admin/siswa/${id}`;
            const userSelect = form.querySelector('[name="user_id"]');
            const userId = this.dataset.user || '';
            console.log('Setting user_id to:', userId); // Debug
            userSelect.value = userId;
            form.querySelector('[name="nis"]').value = this.dataset.nis || '';
            form.querySelector('[name="nisn"]').value = this.dataset.nisn || '';
            form.querySelector('[name="tempat_lahir"]').value = this.dataset.tempat || '';
            form.querySelector('[name="tanggal_lahir"]').value = this.dataset.tanggal || '';
            form.querySelector('[name="kelas_id"]').value = this.dataset.kelas || '';
            form.querySelector('[name="jenis_kelamin"]').value = this.dataset.jk || '';
            form.querySelector('[name="agama"]').value = this.dataset.agama || '';
            form.querySelector('[name="no_telepon"]').value = this.dataset.no || '';
            form.querySelector('[name="alamat"]').value = this.dataset.alamat || '';
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
                title: 'Hapus Data Siswa?',
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

// Photo Preview Function
function previewPhoto(imageUrl, studentName) {
    Swal.fire({
        title: `Foto ${studentName}`,
        imageUrl: imageUrl,
        imageWidth: 400,
        imageHeight: 400,
        imageAlt: `Foto ${studentName}`,
        showCloseButton: true,
        showConfirmButton: false,
        customClass: {
            image: 'preview-image'
        },
        didOpen: () => {
            // Add custom styling for the preview
            const image = document.querySelector('.preview-image');
            if (image) {
                image.style.objectFit = 'cover';
                image.style.borderRadius = '8px';
                image.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
            }
        }
    });
}

// Show Siswa Detail Function - REVISI
function showSiswaDetail(id) {
    fetch(`/admin/siswa/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Detail siswa data:', data); // Debug log
            
            // Photo with click to preview
            const fotoContainer = document.getElementById('detailFoto');
            if (data.foto) {
                const fotoUrl = data.foto && data.foto.startsWith('siswa/') ? '/storage/' + data.foto : '/uploads/siswa/' + data.foto;
                fotoContainer.innerHTML = `<img src="${fotoUrl}" alt="Foto Siswa" class="detail-photo clickable-photo" onclick="previewPhoto('${fotoUrl}', '${data.user ? data.user.nama_lengkap : 'Siswa'}')" title="Klik untuk memperbesar">`;
            } else {
                const initial = data.user && data.user.nama_lengkap ? 
                    data.user.nama_lengkap.charAt(0).toUpperCase() : 'N';
                fotoContainer.innerHTML = `<div class="detail-photo-placeholder">${initial}</div>`;
            }
            
            // Basic Info
            document.getElementById('detailNis').textContent = data.nis || '-';
            document.getElementById('detailNisn').textContent = data.nisn || '-';
            
            // Nama lengkap dari relasi user
            const namaLengkap = data.user ? data.user.nama_lengkap : 'Data tidak tersedia';
            document.getElementById('detailNama').textContent = namaLengkap;
            
            // Kelas
            document.getElementById('detailKelas').textContent = data.kelas ? data.kelas.nama_kelas : '-';
            
            // Jenis Kelamin
            document.getElementById('detailJenisKelamin').textContent = data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
            
            // Tempat Lahir
            document.getElementById('detailTempatLahir').textContent = data.tempat_lahir || '-';
            
            // Format tanggal lahir
            if (data.tanggal_lahir) {
                const date = new Date(data.tanggal_lahir);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('detailTanggalLahir').textContent = date.toLocaleDateString('id-ID', options);
            } else {
                document.getElementById('detailTanggalLahir').textContent = '-';
            }
            
            // Data lainnya
            document.getElementById('detailAgama').textContent = data.agama || '-';
            document.getElementById('detailNoTelepon').textContent = data.no_telepon || '-';
            document.getElementById('detailAlamat').textContent = data.alamat || '-';
        })
        .catch(error => {
            console.error('Error fetching siswa detail:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail siswa',
                confirmButtonColor: '#e53e3e'
            });
        });
}
</script>
@endpush