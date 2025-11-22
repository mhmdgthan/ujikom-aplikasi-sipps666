@extends('layouts.wali-kelas')

@section('title', 'Input Pelanggaran Siswa')
@section('page-title', 'Input Pelanggaran Siswa')

@push('styles')
<style>
    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .kelas-info {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .kelas-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .kelas-detail {
        font-size: 14px;
        opacity: 0.95;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .kelas-detail i {
        font-size: 16px;
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
        border-color: #667eea;
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

    .filter-box {
        position: relative;
        width: 180px;
    }

    .filter-box select {
        width: 100%;
        height: 40px;
        padding: 0 16px 0 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
        background: white;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23a0aec0' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    .filter-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 14px;
        pointer-events: none;
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
        min-width: 1000px;
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

    .data-table td.text-center {
        text-align: center;
    }

    .data-table tbody tr {
        transition: background 0.2s;
    }

    .data-table tbody tr:hover {
        background: #f7fafc;
    }

    .siswa-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .siswa-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #fc8181, #e53e3e);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .siswa-details {
        display: flex;
        flex-direction: column;
    }

    .siswa-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 13px;
        margin-bottom: 2px;
    }

    .siswa-kelas {
        font-size: 11px;
        color: #a0aec0;
    }

    .badge-kategori {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-kategori.ringan {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-kategori.sedang {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-kategori.berat {
        background: #fed7d7;
        color: #742a2a;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-status.pending {
        background: #feebc8;
        color: #7c2d12;
    }

    .badge-status.disetujui {
        background: #c6f6d5;
        color: #22543d;
    }

    .badge-status.ditolak {
        background: #fed7d7;
        color: #742a2a;
    }

    .badge-poin {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        background: linear-gradient(135deg, #fc8181, #e53e3e);
        color: white;
    }

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

    .btn-action.view {
        background: #bee3f8;
        color: #2c5282;
    }

    .btn-action.view:hover {
        background: #90cdf4;
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
            flex-direction: column;
        }

        .search-box, .filter-box {
            width: 100%;
        }
        
        .pagination-wrapper {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }
        
        .pagination-controls {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    @if($kelas)
    <div class="kelas-info">
        <div class="kelas-title">
            <i class="fas fa-chalkboard-teacher"></i>
            Input Pelanggaran Siswa
        </div>
        <div class="kelas-detail">
            <span><i class="fas fa-user-tie"></i> Wali Kelas: {{ Auth::user()->nama_lengkap }}</span>
            <span>•</span>
            <span><i class="fas fa-door-open"></i> Kelas yang Diampu: {{ $kelas->tingkat_kelas }} {{ $kelas->jurusan->singkatan ?? '' }}</span>
        </div>
    </div>
    @else
    <div class="kelas-info">
        <div class="kelas-title">
            <i class="fas fa-chalkboard-teacher"></i>
            Input Pelanggaran Siswa
        </div>
        <div class="kelas-detail">
            <span><i class="fas fa-user-tie"></i> Wali Kelas: {{ Auth::user()->nama_lengkap }}</span>
        </div>
    </div>
    @endif

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
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahPelanggaranModal">
            <i class="fas fa-plus"></i>
            Input Pelanggaran
        </button>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="pelanggaranTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 250px;">Siswa</th>
                        <th style="width: 280px;">Jenis Pelanggaran</th>
                        <th class="text-center" style="width: 120px;">Kategori</th>
                        <th class="text-center" style="width: 100px;">Poin</th>
                        <th class="text-center" style="width: 150px;">Status Verifikasi</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $index => $item)
                    <tr data-status="{{ strtolower($item->status_verifikasi) }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ ($pelanggaran->currentPage() - 1) * $pelanggaran->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="siswa-info">
                                <div class="siswa-avatar">
                                    {{ strtoupper(substr($item->siswa->user->nama_lengkap ?? 'N', 0, 1)) }}
                                </div>
                                <div class="siswa-details">
                                    <div class="siswa-name">{{ $item->siswa->user->nama_lengkap ?? '-' }}</div>
                                    <div class="siswa-kelas">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->tahunAjaran->tahun_ajaran ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge-kategori {{ strtolower($item->jenisPelanggaran->kategori ?? 'ringan') }}">
                                @if(strtolower($item->jenisPelanggaran->kategori ?? 'ringan') == 'ringan')
                                    <i class="fas fa-info-circle"></i>
                                @elseif(strtolower($item->jenisPelanggaran->kategori ?? 'ringan') == 'sedang')
                                    <i class="fas fa-exclamation-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($item->jenisPelanggaran->kategori ?? 'Ringan') }}
                            </span>
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
                                <button class="btn-action view" title="Lihat Detail" onclick="showDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                @if($item->status_verifikasi == 'pending')
                                <button class="btn-action edit edit-btn" title="Edit" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#editPelanggaranModal">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('wali-kelas.pelanggaran.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
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
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan {{ $pelanggaran->firstItem() }} - {{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</span>
            </div>
            <div class="pagination-controls">
                @if($pelanggaran->onFirstPage())
                    <span class="pagination-btn prev disabled">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pagination-btn prev">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </a>
                @endif
                
                <div class="pagination-numbers">
                    @foreach($pelanggaran->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
                        @if($page == $pelanggaran->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>
                
                @if($pelanggaran->hasMorePages())
                    <a href="{{ $pelanggaran->nextPageUrl() }}" class="pagination-btn next">
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

@include('wali-kelas.pelanggaran.modals')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('pelanggaranTable');
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
    fetch(`{{ url('wali-kelas/pelanggaran') }}/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Detail data:', data);
            const content = document.getElementById('detailContent');
            
            const siswaNama = data.siswa?.user?.nama_lengkap || 'Nama tidak tersedia';
            const kelasNama = data.siswa?.kelas?.nama_kelas || 'Kelas tidak tersedia';
            const jenisPelanggaran = data.jenis_pelanggaran?.nama_pelanggaran || data.jenisPelanggaran?.nama_pelanggaran || 'Jenis tidak tersedia';
            const kategori = data.jenis_pelanggaran?.kategori || data.jenisPelanggaran?.kategori || 'Ringan';
            const poin = data.poin || 0;
            const tanggal = data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID') : 'Tanggal tidak tersedia';
            const status = data.status_verifikasi || 'pending';
            const keterangan = data.keterangan || data.deskripsi || 'Tidak ada deskripsi';
            const tahunAjaran = data.tahun_ajaran?.tahun_ajaran || data.tahunAjaran?.tahun_ajaran || 'Tidak tersedia';
            
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Siswa</div>
                        <div class="detail-value">${siswaNama}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kelas</div>
                        <div class="detail-value">${kelasNama}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Jenis Pelanggaran</div>
                        <div class="detail-value">${jenisPelanggaran}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kategori & Poin</div>
                        <div class="detail-value">${kategori} (-${poin} poin)</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Pelanggaran</div>
                        <div class="detail-value">${tanggal}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tahun Ajaran</div>
                        <div class="detail-value">${tahunAjaran}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status Verifikasi</div>
                        <div class="detail-value">
                            <span class="badge-status ${status.toLowerCase()}">
                                ${status.charAt(0).toUpperCase() + status.slice(1)}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Deskripsi Pelanggaran</div>
                        <div class="detail-value">${keterangan}</div>
                    </div>
                </div>
                ${data.bukti_foto ? `
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Bukti Foto</div>
                        <div class="detail-value">
                            <img src="${data.bukti_foto.startsWith('uploads/') ? '/' + data.bukti_foto : '/storage/' + data.bukti_foto}" class="bukti-foto" alt="Bukti Pelanggaran" style="max-width: 100%; height: auto; border-radius: 8px; border: 2px solid #e2e8f0;">
                        </div>
                    </div>
                </div>
                ` : ''}
            `;
            
            const modal = new bootstrap.Modal(document.getElementById('detailPelanggaranModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail pelanggaran: ' + error.message,
                confirmButtonColor: '#e53e3e'
            });
        });
}

document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const form = document.getElementById('editForm');
        form.action = `{{ url('wali-kelas/pelanggaran') }}/${id}`;
        
        fetch(`{{ url('wali-kelas/pelanggaran') }}/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                form.querySelector('[name="siswa_id"]').value = data.siswa_id || '';
                form.querySelector('[name="jenis_pelanggaran_id"]').value = data.jenis_pelanggaran_id || '';
                form.querySelector('[name="tanggal"]').value = data.tanggal || '';
                form.querySelector('[name="tahun_ajaran_id"]').value = data.tahun_ajaran_id || '';
                if (form.querySelector('[name="guru_pencatat"]')) {
                    form.querySelector('[name="guru_pencatat"]').value = data.guru_pencatat || '';
                }
                form.querySelector('[name="keterangan"]').value = data.keterangan || '';
            })
            .catch(error => console.error('Error:', error));
    });
});

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
</script>
@endpush