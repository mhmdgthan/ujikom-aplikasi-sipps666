@extends('layouts.main')

@section('title', 'Data Sanksi')
@section('page-title', 'Manajemen Data Sanksi')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/sanksi.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama siswa..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterStatus" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="AKTIF">AKTIF</option>
                    <option value="SELESAI">SELESAI</option>
                    <option value="BATAL">BATAL</option>
                </select>
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i>
            Tambah Data Sanksi
        </button>
    </div>

    <div class="data-table-card">
        <table class="data-table" id="sanksiTable">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Siswa</th>
                    <th>Jenis Sanksi</th>
                    <th style="width: 120px;">Tanggal</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanksi as $index => $item)
                <tr data-status="{{ $item->status }}">
                    <td style="font-weight: 600; color: #718096;">{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight: 600; color: #2d3748;">{{ $item->pelanggaran->siswa->user->nama_lengkap ?? '-' }}</div>
                        <div style="font-size: 11px; color: #a0aec0;">{{ $item->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</div>
                    </td>
                    <td>{{ $item->jenis_sanksi }}</td>
                    <td>{{ $item->tanggal_mulai->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge-status {{ strtolower($item->status) }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action view" onclick="showDetail({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#detailModal">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action edit" onclick="editData({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action delete" onclick="deleteData({{ $item->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
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
                            <div class="empty-state-title">Belum Ada Data Sanksi</div>
                            <div class="empty-state-text">Silakan tambahkan data sanksi baru</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; padding: 20px 24px;">
                <h5 class="modal-title" style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-plus"></i>
                    Tambah Data Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.sanksi.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 24px;">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Pilih Siswa</label>
                        <select name="pelanggaran_id" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($pelanggaran as $p)
                                <option value="{{ $p->id }}">{{ $p->siswa->user->nama_lengkap ?? '-' }} - {{ $p->jenisPelanggaran->nama_pelanggaran ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Jenis Sanksi</label>
                        <select name="jenis_sanksi" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Jenis Sanksi</option>
                            @foreach($jenisSanksi as $js)
                                <option value="{{ $js->nama_sanksi }}">{{ $js->nama_sanksi }} ({{ $js->kategori }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Status</label>
                        <select name="status" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Status</option>
                            <option value="belum">Belum</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Deskripsi Sanksi</label>
                        <textarea name="deskripsi_sanksi" class="form-control" style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; resize: vertical; min-height: 80px;" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; background: #f7fafc; color: #4a5568;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; background: linear-gradient(135deg, #667eea, #764ba2); color: white;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f6ad55, #ed8936); color: white; border: none; padding: 20px 24px;">
                <h5 class="modal-title" style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-edit"></i>
                    Edit Data Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 24px;">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Pelanggaran Siswa</label>
                        <select name="pelanggaran_id" id="edit_pelanggaran_id" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Pelanggaran Siswa</option>
                            @foreach($pelanggaran as $p)
                                <option value="{{ $p->id }}">{{ $p->siswa->user->nama_lengkap ?? '-' }} - {{ $p->jenisPelanggaran->nama_pelanggaran ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Jenis Sanksi</label>
                        <select name="jenis_sanksi" id="edit_jenis_sanksi" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Jenis Sanksi</option>
                            @foreach($jenisSanksi as $js)
                                <option value="{{ $js->nama_sanksi }}">{{ $js->nama_sanksi }} ({{ $js->kategori }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Status</label>
                        <select name="status" id="edit_status" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Status</option>
                            <option value="belum">Belum</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Deskripsi Sanksi</label>
                        <textarea name="deskripsi_sanksi" id="edit_deskripsi_sanksi" class="form-control" style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; resize: vertical; min-height: 80px;" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; background: #f7fafc; color: #4a5568;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; background: linear-gradient(135deg, #f6ad55, #ed8936); color: white;">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #3182ce, #2c5282); color: white; border: none; padding: 20px 24px;">
                <h5 class="modal-title" style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-gavel"></i>
                    Detail Data Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Siswa</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_siswa">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Kelas</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_kelas">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Jenis Sanksi</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_jenis_sanksi">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Tanggal Sanksi</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_tanggal_sanksi">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Status</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_status">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Dibuat Pada</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_created_at">-</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Keterangan</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_keterangan">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; background: #f7fafc; color: #4a5568;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const sanksiData = @json($sanksi);

function showDetail(id) {
    fetch(`/admin/sanksi/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detail_siswa').textContent = data.pelanggaran?.siswa?.user?.nama_lengkap || '-';
            document.getElementById('detail_kelas').textContent = data.pelanggaran?.siswa?.kelas?.nama_kelas || '-';
            document.getElementById('detail_jenis_sanksi').textContent = data.jenis_sanksi || '-';
            document.getElementById('detail_tanggal_sanksi').textContent = data.tanggal_mulai ? new Date(data.tanggal_mulai).toLocaleDateString('id-ID') : '-';
            document.getElementById('detail_status').textContent = data.status || '-';
            document.getElementById('detail_created_at').textContent = data.created_at ? new Date(data.created_at).toLocaleDateString('id-ID') : '-';
            document.getElementById('detail_keterangan').textContent = data.deskripsi_sanksi || '-';
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat detail sanksi'
            });
        });
}

function editData(id) {
    const item = sanksiData.find(s => s.id === id);
    if (item) {
        document.getElementById('editForm').action = `/admin/sanksi/${id}`;
        document.getElementById('edit_pelanggaran_id').value = item.pelanggaran_id;
        document.getElementById('edit_jenis_sanksi').value = item.jenis_sanksi;
        document.getElementById('edit_tanggal_mulai').value = item.tanggal_mulai;
        document.getElementById('edit_tanggal_selesai').value = item.tanggal_selesai || '';
        document.getElementById('edit_status').value = item.status;
        document.getElementById('edit_deskripsi_sanksi').value = item.deskripsi_sanksi || '';
    }
}

function deleteData(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/sanksi/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('sanksiTable');
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
    const select = document.getElementById('filterStatus');
    const filter = select.value;
    const table = document.getElementById('sanksiTable');
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
@endsection