@extends('layouts.main')

@section('title', 'Verifikasi Data')
@section('page-title', 'Verifikasi Data')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/pelanggaran.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa atau jenis data..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="filter-box">
                <i class="fas fa-tags"></i>
                <select id="filterTipe" onchange="filterByTipe()">
                    <option value="">Semua Tipe</option>
                    <option value="pelanggaran">Pelanggaran</option>
                    <option value="prestasi">Prestasi</option>
                    <option value="sanksi">Sanksi</option>
                </select>
            </div>
        </div>
        <div class="stats-info">
            <span class="badge-status pending">
                <i class="fas fa-clock"></i>
                {{ $verifikasi->where('status', 'pending')->count() }} Pending
            </span>
        </div>
    </div>

    <div class="data-table-card">
        <div class="table-container">
            <table class="data-table" id="verifikasiTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th style="width: 100px;">Tipe</th>
                        <th style="width: 200px;">Siswa</th>
                        <th style="width: 180px;">Detail</th>
                        <th class="text-center" style="width: 120px;">Tanggal</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th style="width: 150px;">Diverifikasi Oleh</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($verifikasi as $index => $item)
                    <tr data-status="{{ strtolower($item->status) }}" data-tipe="{{ strtolower($item->tabel_terkait) }}">
                        <td class="text-center" style="font-weight: 600; color: #718096;">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            @if($item->tabel_terkait == 'pelanggaran')
                                <span class="badge-status pending" style="background: #fee2e2; color: #dc2626;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Pelanggaran
                                </span>
                            @elseif($item->tabel_terkait == 'prestasi')
                                <span class="badge-status disetujui" style="background: #dcfce7; color: #16a34a;">
                                    <i class="fas fa-trophy"></i>
                                    Prestasi
                                </span>
                            @else
                                <span class="badge-status ditolak" style="background: #fef3c7; color: #d97706;">
                                    <i class="fas fa-gavel"></i>
                                    Sanksi
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->data_terkait)
                                <div class="siswa-info">
                                    <div class="siswa-avatar">
                                        {{ strtoupper(substr($item->data_terkait->siswa->user->nama_lengkap ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="siswa-details">
                                        {{ $item->data_terkait->siswa->user->nama_lengkap ?? '-' }}
                                        <div class="siswa-kelas">{{ $item->data_terkait->siswa->nis ?? '-' }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Data tidak ditemukan</span>
                            @endif
                        </td>
                        <td>
                            @if($item->data_terkait)
                                @if($item->tabel_terkait == 'pelanggaran')
                                    <div style="font-weight: 600; color: #2d3748;">{{ $item->data_terkait->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
                                    <div style="font-size: 11px; color: #a0aec0;">Poin: {{ $item->data_terkait->poin ?? 0 }}</div>
                                @elseif($item->tabel_terkait == 'prestasi')
                                    <div style="font-weight: 600; color: #2d3748;">{{ $item->data_terkait->jenisPrestasi->nama_prestasi ?? '-' }}</div>
                                    <div style="font-size: 11px; color: #a0aec0;">Poin: {{ $item->data_terkait->poin ?? 0 }}</div>
                                @elseif($item->tabel_terkait == 'sanksi')
                                    <div style="font-weight: 600; color: #2d3748;">{{ $item->data_terkait->jenisSanksi->nama_sanksi ?? '-' }}</div>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <div style="font-weight: 600; color: #2d3748;">{{ $item->created_at->format('d M Y') }}</div>
                            <div style="font-size: 11px; color: #a0aec0;">{{ $item->created_at->format('H:i') }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge-status {{ strtolower($item->status) }}">
                                @if($item->status == 'pending')
                                    <i class="fas fa-clock"></i>
                                @elseif($item->status == 'disetujui')
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            @if($item->status != 'pending')
                                <div style="font-weight: 600; color: #2d3748; font-size: 13px;">
                                    {{ $item->userVerifikator->nama_lengkap ?? 'Tidak diketahui' }}
                                </div>
                                <div style="font-size: 11px; color: #a0aec0;">
                                    {{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}
                                </div>
                            @else
                                <span style="color: #a0aec0; font-size: 13px;">Belum diverifikasi</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($item->status == 'pending')
                                    <form method="POST" action="{{ route('admin.verifikasi-data.approve', $item->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-action verify" title="Setujui" onclick="return confirm('Setujui data ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.verifikasi-data.reject', $item->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-action delete" title="Tolak" onclick="return confirm('Tolak data ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.verifikasi-data.destroy', $item->id) }}" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus" style="background: #fed7d7; color: #742a2a;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <div class="empty-state-title">Tidak Ada Data Verifikasi</div>
                                <div class="empty-state-text">Semua data sudah diverifikasi atau belum ada data baru yang perlu diverifikasi</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($verifikasi->count() > 0)
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan <strong>{{ $verifikasi->count() }}</strong> data verifikasi
            </div>
        </div>
        @endif
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
    const table = document.getElementById('verifikasiTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();
        
        const statusFilter = document.getElementById('filterStatus').value;
        const tipeFilter = document.getElementById('filterTipe').value;
        const rowStatus = row.dataset.status;
        const rowTipe = row.dataset.tipe;
        
        const matchesStatus = !statusFilter || rowStatus === statusFilter;
        const matchesTipe = !tipeFilter || rowTipe === tipeFilter;
        
        if (text.includes(filter) && matchesStatus && matchesTipe) {
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

// Filter by Tipe
function filterByTipe() {
    searchTable();
}

// Delete Confirmation
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Data Verifikasi?',
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



<style>
.btn-action.verify {
    background: #c6f6d5;
    color: #22543d;
}

.btn-action.verify:hover {
    background: #9ae6b4;
}
</style>
@endpush