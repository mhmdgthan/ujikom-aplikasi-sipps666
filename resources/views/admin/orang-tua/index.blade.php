@extends('layouts.main')

@section('title', 'Data Orang Tua')
@section('page-title', 'Data Orang Tua')

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
        border-color: var(--primary);
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
        min-width: 800px;
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

    /* Orang Tua Info */
    .orangtua-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .orangtua-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .orangtua-details {
        display: flex;
        flex-direction: column;
    }

    .orangtua-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 13px;
        margin-bottom: 2px;
    }

    .orangtua-username {
        font-size: 11px;
        color: #a0aec0;
    }

    /* Badge Styles */
    .badge-hubungan {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-hubungan.ayah {
        background: #bee3f8;
        color: #2c5282;
    }

    .badge-hubungan.ibu {
        background: #fed7e2;
        color: #702459;
    }

    .badge-hubungan.wali {
        background: #feebc8;
        color: #7c2d12;
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

    .btn-action.view {
        background: #bee3f8;
        color: #2c5282;
    }

    .btn-action.view:hover {
        background: #90cdf4;
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

    /* Pagination */
    .table-footer {
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .showing-info {
        font-size: 13px;
        color: #718096;
    }

    .showing-info strong {
        color: #2d3748;
        font-weight: 700;
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
        border-color: var(--primary);
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

    .text-danger {
        color: #e53e3e;
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
        }

        .search-box {
            width: 100%;
        }

        .showing-info {
            font-size: 12px;
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
                <input type="text" id="searchInput" placeholder="Cari nama orang tua atau siswa..." onkeyup="searchTable()">
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahOrangTuaModal">
            <i class="fas fa-plus"></i>
            Tambah Orang Tua
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="orangTuaTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 300px;">Orang Tua (User)</th>
                        <th style="width: 250px;">Nama Siswa</th>
                        <th class="text-center" style="width: 150px;">Hubungan</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orangTua as $index => $item)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($orangTua->currentPage() - 1) * $orangTua->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="orangtua-info">
                                <div class="orangtua-avatar">
                                    {{ strtoupper(substr($item->user->nama_lengkap ?? $item->user->username, 0, 1)) }}
                                </div>
                                <div class="orangtua-details">
                                    <div class="orangtua-name">{{ $item->user->nama_lengkap ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->siswa->user->nama_lengkap ?? '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge-hubungan {{ strtolower($item->hubungan) }}">
                                <i class="fas fa-user{{ $item->hubungan == 'Ibu' ? '-friends' : ($item->hubungan == 'Ayah' ? '-tie' : '-shield') }}"></i>
                                {{ $item->hubungan }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailOrangTuaModal"
                                    onclick="showOrangTuaDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-user="{{ $item->user_id }}"
                                    data-siswa="{{ $item->siswa_id }}"
                                    data-hubungan="{{ $item->hubungan }}"
                                    data-pekerjaan="{{ $item->pekerjaan }}"
                                    data-alamat="{{ $item->alamat }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editOrangTuaModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.orang-tua.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Orang Tua</div>
                                <div class="empty-state-text">Silakan tambahkan data orang tua baru dengan klik tombol "Tambah Orang Tua"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
        @if($orangTua->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $orangTua->firstItem() }} - {{ $orangTua->lastItem() }} dari {{ $orangTua->total() }} data
            </div>
            <div class="pagination-container">
                <nav><ul class="custom-pagination">
                @if ($orangTua->onFirstPage())<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>@else<li class="page-item"><a class="page-link" href="{{ $orangTua->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>@endif
                @php $start=max($orangTua->currentPage()-2,1);$end=min($start+4,$orangTua->lastPage());$start=max($end-4,1); @endphp
                @if($start>1)<li class="page-item"><a class="page-link" href="{{ $orangTua->url(1) }}">1</a></li>@if($start>2)<li class="page-item disabled"><span class="page-link">...</span></li>@endif @endif
                @for($i=$start;$i<=$end;$i++)<li class="page-item {{ $i==$orangTua->currentPage()?'active':'' }}"><a class="page-link" href="{{ $orangTua->url($i) }}">{{ $i }}</a></li>@endfor
                @if($end<$orangTua->lastPage())@if($end<$orangTua->lastPage()-1)<li class="page-item disabled"><span class="page-link">...</span></li>@endif<li class="page-item"><a class="page-link" href="{{ $orangTua->url($orangTua->lastPage()) }}">{{ $orangTua->lastPage() }}</a></li>@endif
                @if($orangTua->hasMorePages())<li class="page-item"><a class="page-link" href="{{ $orangTua->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>@else<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>@endif
                </ul></nav>
            </div>
        </div>
        <style>.table-footer{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-top:1px solid #e2e8f0;background:#f8fafc;border-radius:0 0 12px 12px}.showing-info{font-size:14px;color:#64748b;font-weight:500}.pagination-container{display:flex;align-items:center}.custom-pagination{display:flex;list-style:none;padding:0;margin:0;gap:4px;align-items:center}.custom-pagination .page-item{display:inline-block}.custom-pagination .page-link{display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 12px;font-size:14px;font-weight:500;color:#475569;background:white;border:1px solid #e2e8f0;border-radius:8px;text-decoration:none;transition:all 0.2s ease;cursor:pointer}.custom-pagination .page-link:hover{background:#f1f5f9;border-color:#cbd5e0;color:#1e293b;transform:translateY(-1px)}.custom-pagination .page-item.active .page-link{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-color:#667eea;color:white;font-weight:600;box-shadow:0 4px 12px rgba(102,126,234,0.3)}.custom-pagination .page-item.disabled .page-link{color:#cbd5e0;background:#f8fafc;border-color:#e2e8f0;cursor:not-allowed;pointer-events:none}.custom-pagination .page-link i{font-size:12px}</style>
        @endif
    </div>
</div>

{{-- Modal Detail Orang Tua --}}
<div class="modal fade" id="detailOrangTuaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                <h5 class="modal-title">
                    <i class="fas fa-users"></i>
                    Detail Orang Tua
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Nama Orang Tua</div>
                            <div class="detail-value" id="detailNamaOrangTua">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Username</div>
                            <div class="detail-value" id="detailUsername">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Nama Siswa</div>
                            <div class="detail-value" id="detailNamaSiswa">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Kelas</div>
                            <div class="detail-value" id="detailKelasSiswa">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Hubungan</div>
                            <div class="detail-value" id="detailHubungan">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Pekerjaan</div>
                            <div class="detail-value" id="detailPekerjaan">-</div>
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
            <div class="modal-footer">
                <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Orang Tua --}}
<div class="modal fade" id="tambahOrangTuaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus"></i>
                    Tambah Orang Tua Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.orang-tua.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @include('admin.orang-tua.partials.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Orang Tua --}}
<div class="modal fade" id="editOrangTuaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Orang Tua
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editOrangTuaForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @include('admin.orang-tua.partials.form')
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
            const form = document.getElementById('editOrangTuaForm');
            const id = this.dataset.id;
            form.action = `/admin/orang-tua/${id}`;
            form.querySelector('[name="user_id"]').value = this.dataset.user || '';
            form.querySelector('[name="siswa_id"]').value = this.dataset.siswa || '';
            form.querySelector('[name="hubungan"]').value = this.dataset.hubungan || '';
            form.querySelector('[name="pekerjaan"]').value = this.dataset.pekerjaan || '';
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
                title: 'Hapus Data Orang Tua?',
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
    const table = document.getElementById('orangTuaTable');
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

// Show Orang Tua Detail Function
function showOrangTuaDetail(id) {
    fetch(`/admin/orang-tua/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailNamaOrangTua').textContent = data.user ? data.user.nama_lengkap || '-' : '-';
            document.getElementById('detailUsername').textContent = data.user ? '@' + (data.user.username || '-') : '-';
            document.getElementById('detailNamaSiswa').textContent = data.siswa && data.siswa.user ? data.siswa.user.nama_lengkap || '-' : '-';
            document.getElementById('detailKelasSiswa').textContent = data.siswa && data.siswa.kelas ? data.siswa.kelas.nama_kelas || '-' : '-';
            document.getElementById('detailHubungan').textContent = data.hubungan || '-';
            document.getElementById('detailPekerjaan').textContent = data.pekerjaan || '-';
            document.getElementById('detailAlamat').textContent = data.alamat || '-';
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail orang tua',
                confirmButtonColor: '#e53e3e'
            });
        });
}
</script>
@endpush