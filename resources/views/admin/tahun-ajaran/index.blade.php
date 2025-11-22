@extends('layouts.main')

@section('title', 'Data Tahun Ajaran')
@section('page-title', 'Manajemen Tahun Ajaran')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/tahun-ajaran.css') }}">
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari tahun ajaran atau semester..." onkeyup="searchTable()">
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahTahunModal">
            <i class="fas fa-plus"></i>
            Tambah Tahun Ajaran
        </button>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="tahunAjaranTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 220px;">Tahun Ajaran</th>
                        <th class="text-center" style="width: 120px;">Semester</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                        <th style="width: 180px;">Tanggal Mulai</th>
                        <th style="width: 180px;">Tanggal Selesai</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahunAjaran as $index => $item)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($tahunAjaran->currentPage() - 1) * $tahunAjaran->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="tahun-info">
                                <div class="tahun-avatar">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="tahun-details">
                                    <div class="tahun-name">{{ $item->tahun_ajaran }}</div>
                                    <div class="tahun-kode">{{ $item->kode_tahun }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-semester {{ strtolower($item->semester) }}">
                                <i class="fas fa-book-open"></i>
                                {{ ucfirst($item->semester) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($item->status_aktif)
                                <span class="badge-status aktif">
                                    <i class="fas fa-check-circle"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="badge-status nonaktif">
                                    <i class="fas fa-times-circle"></i>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('l') }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('l') }}</div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailTahunModal"
                                    onclick="showTahunDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-kode="{{ $item->kode_tahun }}"
                                    data-tahun="{{ $item->tahun_ajaran }}"
                                    data-semester="{{ $item->semester }}"
                                    data-aktif="{{ $item->status_aktif }}"
                                    data-mulai="{{ $item->tanggal_mulai }}"
                                    data-selesai="{{ $item->tanggal_selesai }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editTahunModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.tahun-ajaran.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Tahun Ajaran</div>
                                <div class="empty-state-text">Silakan tambahkan data tahun ajaran baru dengan klik tombol "Tambah Tahun Ajaran"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tahunAjaran->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $tahunAjaran->firstItem() }} - {{ $tahunAjaran->lastItem() }} dari {{ $tahunAjaran->total() }} data
            </div>
            <div class="pagination-container">
                <nav><ul class="custom-pagination">
                @if ($tahunAjaran->onFirstPage())<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>@else<li class="page-item"><a class="page-link" href="{{ $tahunAjaran->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>@endif
                @php $start=max($tahunAjaran->currentPage()-2,1);$end=min($start+4,$tahunAjaran->lastPage());$start=max($end-4,1); @endphp
                @if($start>1)<li class="page-item"><a class="page-link" href="{{ $tahunAjaran->url(1) }}">1</a></li>@if($start>2)<li class="page-item disabled"><span class="page-link">...</span></li>@endif @endif
                @for($i=$start;$i<=$end;$i++)<li class="page-item {{ $i==$tahunAjaran->currentPage()?'active':'' }}"><a class="page-link" href="{{ $tahunAjaran->url($i) }}">{{ $i }}</a></li>@endfor
                @if($end<$tahunAjaran->lastPage())@if($end<$tahunAjaran->lastPage()-1)<li class="page-item disabled"><span class="page-link">...</span></li>@endif<li class="page-item"><a class="page-link" href="{{ $tahunAjaran->url($tahunAjaran->lastPage()) }}">{{ $tahunAjaran->lastPage() }}</a></li>@endif
                @if($tahunAjaran->hasMorePages())<li class="page-item"><a class="page-link" href="{{ $tahunAjaran->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>@else<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>@endif
                </ul></nav>
            </div>
        </div>
        <style>.table-footer{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-top:1px solid #e2e8f0;background:#f8fafc;border-radius:0 0 12px 12px}.showing-info{font-size:14px;color:#64748b;font-weight:500}.pagination-container{display:flex;align-items:center}.custom-pagination{display:flex;list-style:none;padding:0;margin:0;gap:4px;align-items:center}.custom-pagination .page-item{display:inline-block}.custom-pagination .page-link{display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 12px;font-size:14px;font-weight:500;color:#475569;background:white;border:1px solid #e2e8f0;border-radius:8px;text-decoration:none;transition:all 0.2s ease;cursor:pointer}.custom-pagination .page-link:hover{background:#f1f5f9;border-color:#cbd5e0;color:#1e293b;transform:translateY(-1px)}.custom-pagination .page-item.active .page-link{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-color:#667eea;color:white;font-weight:600;box-shadow:0 4px 12px rgba(102,126,234,0.3)}.custom-pagination .page-item.disabled .page-link{color:#cbd5e0;background:#f8fafc;border-color:#e2e8f0;cursor:not-allowed;pointer-events:none}.custom-pagination .page-link i{font-size:12px}</style>
        @endif
    </div>
</div>

{{-- Modal Detail Tahun Ajaran --}}
<div class="modal fade" id="detailTahunModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3182ce, #2c5282);">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-alt"></i>
                    Detail Tahun Ajaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Kode Tahun</div>
                            <div class="detail-value" id="detailKodeTahun">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Tahun Ajaran</div>
                            <div class="detail-value" id="detailTahunAjaran">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Semester</div>
                            <div class="detail-value" id="detailSemester">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="detailStatus">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Mulai</div>
                            <div class="detail-value" id="detailTanggalMulai">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Selesai</div>
                            <div class="detail-value" id="detailTanggalSelesai">-</div>
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

{{-- Modal Tambah Tahun Ajaran --}}
<div class="modal fade" id="tambahTahunModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus"></i>
                    Tambah Tahun Ajaran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @include('admin.tahun-ajaran.partials.form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Tahun Ajaran --}}
<div class="modal fade" id="editTahunModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Tahun Ajaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTahunForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @include('admin.tahun-ajaran.partials.form')
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
            const form = document.getElementById('editTahunForm');
            const id = this.dataset.id;
            form.action = `/admin/tahun-ajaran/${id}`;
            form.querySelector('[name="tahun_ajaran"]').value = this.dataset.tahun || '';
            form.querySelector('[name="semester"]').value = this.dataset.semester || '';
            form.querySelector('[name="tanggal_mulai"]').value = this.dataset.mulai || '';
            form.querySelector('[name="tanggal_selesai"]').value = this.dataset.selesai || '';
            form.querySelector('[name="status_aktif"]').checked = this.dataset.aktif == 1 ? true : false;
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
                title: 'Hapus Data Tahun Ajaran?',
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
    const table = document.getElementById('tahunAjaranTable');
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

// Show Tahun Detail Function
function showTahunDetail(id) {
    fetch(`/admin/tahun-ajaran/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailKodeTahun').textContent = data.kode_tahun || '-';
            document.getElementById('detailTahunAjaran').textContent = data.tahun_ajaran || '-';
            document.getElementById('detailSemester').textContent = data.semester || '-';
            document.getElementById('detailStatus').textContent = data.status_aktif ? 'Aktif' : 'Nonaktif';
            
            // Format tanggal
            if (data.tanggal_mulai) {
                const mulai = new Date(data.tanggal_mulai);
                document.getElementById('detailTanggalMulai').textContent = mulai.toLocaleDateString('id-ID', {
                    year: 'numeric', month: 'long', day: 'numeric'
                });
            } else {
                document.getElementById('detailTanggalMulai').textContent = '-';
            }
            
            if (data.tanggal_selesai) {
                const selesai = new Date(data.tanggal_selesai);
                document.getElementById('detailTanggalSelesai').textContent = selesai.toLocaleDateString('id-ID', {
                    year: 'numeric', month: 'long', day: 'numeric'
                });
            } else {
                document.getElementById('detailTanggalSelesai').textContent = '-';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail tahun ajaran',
                confirmButtonColor: '#e53e3e'
            });
        });
}
</script>
@endpush