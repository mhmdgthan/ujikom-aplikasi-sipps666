@extends('layouts.kesiswaan')

@section('title', 'Pelaksanaan Sanksi')
@section('page-title', 'Pelaksanaan Sanksi')

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

.btn-add {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

/* Tambahan style untuk modal pelaksanaan sanksi */
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
    border-color: #667eea;
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

.bukti-foto {
    width: 100%;
    max-width: 400px;
    height: auto;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
}

.text-danger {
    color: #e53e3e;
    font-size: 12px;
    margin-top: 4px;
}
.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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

.badge-status.selesai {
    background: #dcfce7;
    color: #16a34a;
}

.badge-status.dibatalkan {
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

.btn-action.view {
    background: #bee3f8;
    color: #2c5282;
}

.btn-action.edit {
    background: #feebc8;
    color: #7c2d12;
}

.btn-action.delete {
    background: #fed7d7;
    color: #742a2a;
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
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau jenis sanksi..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahPelaksanaanModal">
            <i class="fas fa-plus"></i>
            Tambah Pelaksanaan
        </button>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="pelaksanaanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Sanksi</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelaksanaanSanksi as $index => $item)
                    <tr data-status="{{ strtolower($item->status) }}">
                        <td>{{ ($pelaksanaanSanksi->currentPage() - 1) * $pelaksanaanSanksi->perPage() + $loop->iteration }}</td>
                        <td>
                            <div class="siswa-info">
                                <div class="siswa-avatar">
                                    {{ strtoupper(substr($item->sanksi->pelanggaran->siswa->user->nama_lengkap ?? 'S', 0, 1)) }}
                                </div>
                                <div class="siswa-details">
                                    {{ $item->sanksi->pelanggaran->siswa->user->nama_lengkap ?? '-' }}
                                    <div class="siswa-kelas">{{ $item->sanksi->pelanggaran->siswa->nis ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->sanksi->jenis_sanksi ?? '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->sanksi->deskripsi_sanksi ?? '-' }}</div>
                        </td>
                        <td>{{ $item->tanggal_pelaksanaan ? $item->tanggal_pelaksanaan->format('d M Y') : '-' }}</td>
                        <td>
                            <span class="badge-status {{ strtolower($item->status) }}">
                                @if($item->status == 'pending')
                                    <i class="fas fa-clock"></i>
                                @elseif($item->status == 'selesai')
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail" onclick="showDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit" onclick="editPelaksanaan({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#editPelaksanaanModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('kesiswaan.pelaksanaan-sanksi.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-gavel"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Pelaksanaan Sanksi</div>
                                <div class="empty-state-text">Silakan tambah data pelaksanaan sanksi dengan klik tombol "Tambah Pelaksanaan"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pelaksanaanSanksi->count() > 0)
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan {{ $pelaksanaanSanksi->firstItem() }} - {{ $pelaksanaanSanksi->lastItem() }} dari {{ $pelaksanaanSanksi->total() }} data</span>
            </div>
            <div class="pagination-controls">
                @if($pelaksanaanSanksi->onFirstPage())
                    <span class="pagination-btn prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $pelaksanaanSanksi->previousPageUrl() }}" class="pagination-btn prev">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </a>
                @endif
                
                <div class="pagination-numbers">
                    @foreach($pelaksanaanSanksi->getUrlRange(1, $pelaksanaanSanksi->lastPage()) as $page => $url)
                        @if($page == $pelaksanaanSanksi->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                @if($pelaksanaanSanksi->hasMorePages())
                    <a href="{{ $pelaksanaanSanksi->nextPageUrl() }}" class="pagination-btn next">
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

@include('kesiswaan.pelaksanaan-sanksi.modals')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('pelaksanaanTable');
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

function filterByStatus() {
    searchTable();
}

function showDetail(id) {
    fetch(`{{ url('kesiswaan/pelaksanaan-sanksi') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            // Populate detail modal
            document.getElementById('detail_siswa').textContent = data.sanksi?.pelanggaran?.siswa?.user?.nama_lengkap || '-';
            document.getElementById('detail_nis').textContent = data.sanksi?.pelanggaran?.siswa?.nis || '-';
            document.getElementById('detail_jenis_sanksi').textContent = data.sanksi?.jenis_sanksi || '-';
            document.getElementById('detail_deskripsi').textContent = data.sanksi?.deskripsi_sanksi || '-';
            document.getElementById('detail_tanggal_pelaksanaan').textContent = data.tanggal_pelaksanaan || '-';
            document.getElementById('detail_status').textContent = data.status || '-';
            document.getElementById('detail_catatan').textContent = data.catatan || 'Tidak ada catatan';
            
            // Handle bukti foto
            const buktiContainer = document.getElementById('detail_bukti_container');
            const buktiImg = document.getElementById('detail_bukti_img');
            if (data.bukti_pelaksanaan) {
                buktiImg.src = `{{ asset('storage') }}/${data.bukti_pelaksanaan}`;
                buktiContainer.style.display = 'block';
            } else {
                buktiContainer.style.display = 'none';
            }
            
            // Show modal
            new bootstrap.Modal(document.getElementById('detailPelaksanaanModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Gagal memuat detail data', 'error');
        });
}

function editPelaksanaan(id) {
    fetch(`{{ url('kesiswaan/pelaksanaan-sanksi') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            // Populate edit form
            document.getElementById('edit_sanksi_id').value = data.sanksi_id;
            document.getElementById('edit_tanggal_pelaksanaan').value = data.tanggal_pelaksanaan;
            document.getElementById('edit_status').value = data.status;
            document.getElementById('edit_catatan').value = data.catatan || '';
            document.getElementById('editForm').action = `{{ url('kesiswaan/pelaksanaan-sanksi') }}/${id}`;
            
            // Show current bukti if exists
            const buktiPreview = document.getElementById('currentBuktiPreview');
            const buktiImage = document.getElementById('currentBuktiImage');
            if (data.bukti_pelaksanaan) {
                buktiImage.src = `{{ asset('storage') }}/${data.bukti_pelaksanaan}`;
                buktiPreview.style.display = 'block';
            } else {
                buktiPreview.style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
}

// Photo Preview Function
function previewFoto(imageSrc) {
    Swal.fire({
        title: 'Bukti Pelaksanaan Sanksi',
        imageUrl: imageSrc,
        imageWidth: 500,
        imageHeight: 400,
        imageAlt: 'Bukti Pelaksanaan Sanksi',
        showCloseButton: true,
        showConfirmButton: false,
        customClass: {
            image: 'preview-image'
        },
        didOpen: () => {
            const image = document.querySelector('.preview-image');
            if (image) {
                image.style.objectFit = 'contain';
                image.style.borderRadius = '8px';
                image.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
            }
        }
    });
}

// Add CSS for clickable photos
const style = document.createElement('style');
style.textContent = `
    .clickable-photo {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .clickable-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        opacity: 0.9;
    }
`;
document.head.appendChild(style);

document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data Pelaksanaan?',
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