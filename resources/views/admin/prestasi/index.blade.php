@extends('layouts.main')

@section('title', 'Data Prestasi Siswa')
@section('page-title', 'Manajemen Prestasi Siswa')
@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/prestasi.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau jenis prestasi..." onkeyup="searchTable()">
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#tambahPrestasiModal">
            <i class="fas fa-plus"></i>
            Input Prestasi
        </button>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="prestasiTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 250px;">Siswa</th>
                        <th style="width: 200px;">Jenis Prestasi</th>
                        <th class="text-center" style="width: 120px;">Tanggal</th>
                        <th class="text-center" style="width: 100px;">Poin</th>
                        <th class="text-center" style="width: 150px;">Status</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasi as $index => $item)
                    <tr>
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ $index + 1 }}
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
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->jenisPrestasi->nama_prestasi }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->tahunAjaran->tahun_ajaran ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <div style="font-weight: 600; color: #2d3748; font-size: 13px;">
                                {{ \Carbon\Carbon::parse($item->tanggal_prestasi)->format('d/m/Y') }}
                            </div>
                            <div style="font-size: 11px; color: #a0aec0;">
                                {{ \Carbon\Carbon::parse($item->tanggal_prestasi)->diffForHumans() }}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-poin">
                                <i class="fas fa-plus"></i>
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
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailPrestasiModal"
                                    onclick="showDetail({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button class="btn-action verify" title="Verifikasi"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#verifikasiModal">
                                    <i class="fas fa-check-double"></i>
                                </button>
                                
                                <button class="btn-action edit edit-btn" title="Edit"
                                    data-id="{{ $item->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPrestasiModal">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.prestasi.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="empty-state-title">Belum Ada Data Prestasi</div>
                                <div class="empty-state-text">Silakan input data prestasi siswa dengan klik tombol "Input Prestasi"</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prestasi->count() > 0)
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan <strong>{{ $prestasi->count() }}</strong> data prestasi
            </div>
        </div>
        @endif
    </div>
</div>

@include('admin.prestasi.modals')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('prestasiTable');
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

function showDetail(id) {
    fetch(`{{ url('admin/prestasi') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('detailContent');
            content.innerHTML = `
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Nama Siswa</div>
                        <div class="detail-value">${data.siswa.user ? data.siswa.user.nama_lengkap : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Kelas</div>
                        <div class="detail-value">${data.siswa.kelas ? data.siswa.kelas.nama_kelas : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Jenis Prestasi</div>
                        <div class="detail-value">${data.jenis_prestasi.nama_prestasi}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tanggal Prestasi</div>
                        <div class="detail-value">${formatTanggal(data.tanggal_prestasi)}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Poin</div>
                        <div class="detail-value">+${data.poin} poin</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Guru Pencatat</div>
                        <div class="detail-value">${data.guru_pencatat ? data.guru_pencatat.nama_guru : '-'}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Status Verifikasi</div>
                        <div class="detail-value">
                            <span class="badge-status ${data.status_verifikasi.toLowerCase()}">
                                ${data.status_verifikasi}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-group">
                        <div class="detail-label">Tahun Ajaran</div>
                        <div class="detail-value">${data.tahun_ajaran ? data.tahun_ajaran.tahun_ajaran : '-'}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="detail-group">
                        <div class="detail-label">Deskripsi Prestasi</div>
                        <div class="detail-value">${data.keterangan || '-'}</div>
                    </div>
                </div>
            `;
        })
        .catch(error => console.error('Error:', error));
}

function formatTanggal(tanggal) {
    if (!tanggal) return '-';
    const date = new Date(tanggal);
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    return date.toLocaleDateString('id-ID', options);
}

// Edit Modal Handler
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const form = document.getElementById('editForm');
        form.action = `{{ url('admin/prestasi') }}/${id}`;
        
        fetch(`{{ url('admin/prestasi') }}/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                form.querySelector('[name="siswa_id"]').value = data.siswa_id || '';
                form.querySelector('[name="jenis_prestasi_id"]').value = data.jenis_prestasi_id || '';
                form.querySelector('[name="tahun_ajaran_id"]').value = data.tahun_ajaran_id || '';
                form.querySelector('[name="guru_pencatat"]').value = data.guru_pencatat || '';
                form.querySelector('[name="keterangan"]').value = data.keterangan || '';
                
                // Set tanggal prestasi
                if (data.tanggal_prestasi) {
                    const tanggal = new Date(data.tanggal_prestasi).toISOString().split('T')[0];
                    form.querySelector('[name="tanggal_prestasi"]').value = tanggal;
                }
            })
            .catch(error => console.error('Error:', error));
    });
});

// Verifikasi Modal Handler
document.querySelectorAll('[data-bs-target="#verifikasiModal"]').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const form = document.getElementById('verifikasiForm');
        form.action = `{{ url('admin/prestasi') }}/${id}/verifikasi`;
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

// Delete Confirmation
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data Prestasi?',
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
</script>
@endpush