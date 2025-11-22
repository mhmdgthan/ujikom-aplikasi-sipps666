@extends('layouts.main')

@section('title', 'Data Pelanggaran Siswa')
@section('page-title', 'Manajemen Pelanggaran Siswa')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/pelanggaran.css') }}">
@endpush

@section('content')
<!-- White Container Wrapper -->
<div class="content-wrapper">
    <!-- Page Actions -->
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau jenis pelanggaran..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu Verifikasi</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="filter-box">
                <i class="fas fa-tags"></i>
                <select id="filterKategori" onchange="filterByKategori()">
                    <option value="">Semua Kategori</option>
                    <option value="ringan">Ringan</option>
                    <option value="sedang">Sedang</option>
                    <option value="berat">Berat</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="pelanggaranTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 220px;">Siswa</th>
                        <th style="width: 200px;">Jenis Pelanggaran</th>
                        <th class="text-center" style="width: 100px;">Poin</th>
                        <th class="text-center" style="width: 150px;">Status Verifikasi</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $index => $item)
                    <tr data-status="{{ strtolower($item->status_verifikasi) }}" data-kategori="{{ strtolower($item->jenisPelanggaran->kategoriPelanggaran->nama_kategori ?? '') }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="siswa-info">
                                <div class="siswa-avatar">
                                    {{ strtoupper(substr($item->siswa->user->nama_lengkap ?? 'N', 0, 1)) }}
                                </div>
                                <div class="siswa-details">
                                     {{ $item->siswa->user->nama_lengkap ?? 'Data Siswa Tidak Ditemukan' }}
                                    <div class="siswa-kelas">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->tahunAjaran->tahun_ajaran ?? '-' }}</div>
                        </td>
                      
                        <td class="text-center">
                            <span class="badge-poin">
                                <i class="fas fa-minus"></i>
                                {{ $item->poin }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge-status {{ strtolower($item->status_verifikasi) }}">
                                @if(strtolower($item->status_verifikasi) == 'pending')
                                    <i class="fas fa-clock"></i>
                                @elseif(strtolower($item->status_verifikasi) == 'disetujui')
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($item->status_verifikasi) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action view" title="Lihat Detail"
                                    onclick="showDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form action="{{ route('admin.pelanggaran.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Pelanggaran</div>
                                <div class="empty-state-text">Silakan input data pelanggaran siswa dengan klik tombol "Input Pelanggaran"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggaran->count() > 0)
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan <strong>{{ $pelanggaran->count() }}</strong> data pelanggaran
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Detail Pelanggaran --}}
<div class="modal fade" id="detailPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="detailContent">
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

{{-- Modal Preview Foto --}}
<div class="modal fade" id="previewFotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image"></i>
                    Bukti Foto Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Bukti Foto" class="img-fluid rounded" style="max-height: 500px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <a id="downloadLink" href="" download class="btn btn-success">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Search Function
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('pelanggaranTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();
        
        const statusFilter = document.getElementById('filterStatus').value;
        const kategoriFilter = document.getElementById('filterKategori').value;
        const rowStatus = row.dataset.status;
        const rowKategori = row.dataset.kategori;
        
        const matchesStatus = !statusFilter || rowStatus === statusFilter;
        const matchesKategori = !kategoriFilter || rowKategori === kategoriFilter;
        
        if (text.includes(filter) && matchesStatus && matchesKategori) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

// Filter by Status
function filterByStatus() {
    searchTable();
}

// Filter by Kategori
function filterByKategori() {
    searchTable();
}

// Show Detail Function
function showDetail(id) {
    fetch(`{{ url('admin/verifikasi-data') }}/${id}/detail`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('detailContent');
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Siswa</div>
                        <div class="detail-value">${data.siswa && data.siswa.user ? data.siswa.user.nama_lengkap : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kelas</div>
                        <div class="detail-value">${data.siswa && data.siswa.kelas ? data.siswa.kelas.nama_kelas : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Jenis Pelanggaran</div>
                        <div class="detail-value">${data.jenis_pelanggaran ? data.jenis_pelanggaran.nama_pelanggaran : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kategori & Poin</div>
                        <div class="detail-value">${data.kategori_poin || '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Pelanggaran</div>
                        <div class="detail-value">${data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID') : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tahun Ajaran</div>
                        <div class="detail-value">${data.tahun_ajaran ? data.tahun_ajaran.tahun_ajaran : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Guru Pencatat</div>
                        <div class="detail-value">${data.guru_pencatat_nama || 'Tidak diketahui'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status Verifikasi</div>
                        <div class="detail-value">
                            <span class="badge-status ${data.status_verifikasi ? data.status_verifikasi.toLowerCase() : 'pending'}">
                                ${data.status_verifikasi ? data.status_verifikasi.charAt(0).toUpperCase() + data.status_verifikasi.slice(1) : 'Pending'}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Catatan Verifikasi</div>
                        <div class="detail-value">${data.catatan_verifikasi || '-'}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Deskripsi Pelanggaran</div>
                        <div class="detail-value">${data.keterangan || data.deskripsi || '-'}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Bukti Foto</div>
                        <div class="detail-value">
                            ${data.bukti_foto && data.bukti_foto !== '' && data.bukti_foto !== null ? 
                                `<div class="bukti-foto-container">
                                    <img src="/storage/${data.bukti_foto}" 
                                         class="bukti-foto clickable-photo" alt="Bukti Pelanggaran" 
                                         style="max-width: 300px; border-radius: 8px;" 
                                         onclick="previewFoto('/storage/${data.bukti_foto}')" 
                                         title="Klik untuk memperbesar">
                                    <div class="mt-2">
                                        <small class="text-muted">Klik foto untuk memperbesar</small>
                                    </div>
                                </div>` : 
                                'Bukti foto tidak tersedia'
                            }
                        </div>
                    </div>
                </div>
            `;
            const modal = new bootstrap.Modal(document.getElementById('detailPelanggaranModal'));
            modal.show();
        })
        .catch(error => console.error('Error:', error));
}



// Delete Confirmation
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data Pelanggaran?',
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

// Preview foto functions
function previewFile(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

function previewEditFile(input) {
    const preview = document.getElementById('editPreview');
    const previewContainer = document.getElementById('editImagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

function previewFoto(imageSrc) {
    // Use SweetAlert2 for consistent preview like siswa photos
    Swal.fire({
        title: 'Bukti Foto Pelanggaran',
        imageUrl: imageSrc,
        imageWidth: 500,
        imageHeight: 400,
        imageAlt: 'Bukti Foto Pelanggaran',
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