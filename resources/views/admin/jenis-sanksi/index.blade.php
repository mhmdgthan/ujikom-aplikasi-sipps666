@extends('layouts.main')

@section('title', 'Data Jenis Sanksi')
@section('page-title', 'Manajemen Jenis Sanksi')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/jenis-sanksi.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="page-actions">
        <div class="page-actions-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari nama sanksi..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <i class="fas fa-filter"></i>
                <select id="filterKategori" onchange="filterByKategori()">
                    <option value="">Semua Kategori</option>
                    <option value="RINGAN">RINGAN</option>
                    <option value="SEDANG">SEDANG</option>
                    <option value="BERAT">BERAT</option>
                </select>
            </div>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i>
            Tambah Jenis Sanksi
        </button>
    </div>

    <div class="data-table-card">
        <table class="data-table" id="sanksiTable">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Sanksi</th>
                    <th style="width: 120px;">Kategori</th>
                    <th>Deskripsi</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisSanksi as $index => $item)
                <tr data-kategori="{{ $item->kategori }}">
                    <td style="font-weight: 600; color: #718096;">{{ ($jenisSanksi->currentPage() - 1) * $jenisSanksi->perPage() + $index + 1 }}</td>
                    <td style="font-weight: 600; color: #2d3748;">{{ $item->nama_sanksi }}</td>
                    <td>
                        <span class="badge-kategori {{ strtolower($item->kategori) }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td>{{ $item->deskripsi ?? '-' }}</td>
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
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-gavel"></i>
                            </div>
                            <div class="empty-state-title">Belum Ada Data Jenis Sanksi</div>
                            <div class="empty-state-text">Silakan tambahkan data jenis sanksi baru</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($jenisSanksi->hasPages())
        <div class="table-footer">
            <div class="showing-info">
                Menampilkan {{ $jenisSanksi->firstItem() }} - {{ $jenisSanksi->lastItem() }} dari {{ $jenisSanksi->total() }} data
            </div>
            <div class="pagination-container">
                <nav><ul class="custom-pagination">
                @if ($jenisSanksi->onFirstPage())<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>@else<li class="page-item"><a class="page-link" href="{{ $jenisSanksi->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>@endif
                @php $start=max($jenisSanksi->currentPage()-2,1);$end=min($start+4,$jenisSanksi->lastPage());$start=max($end-4,1); @endphp
                @if($start>1)<li class="page-item"><a class="page-link" href="{{ $jenisSanksi->url(1) }}">1</a></li>@if($start>2)<li class="page-item disabled"><span class="page-link">...</span></li>@endif @endif
                @for($i=$start;$i<=$end;$i++)<li class="page-item {{ $i==$jenisSanksi->currentPage()?'active':'' }}"><a class="page-link" href="{{ $jenisSanksi->url($i) }}">{{ $i }}</a></li>@endfor
                @if($end<$jenisSanksi->lastPage())@if($end<$jenisSanksi->lastPage()-1)<li class="page-item disabled"><span class="page-link">...</span></li>@endif<li class="page-item"><a class="page-link" href="{{ $jenisSanksi->url($jenisSanksi->lastPage()) }}">{{ $jenisSanksi->lastPage() }}</a></li>@endif
                @if($jenisSanksi->hasMorePages())<li class="page-item"><a class="page-link" href="{{ $jenisSanksi->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>@else<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>@endif
                </ul></nav>
            </div>
        </div>
        <style>.table-footer{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-top:1px solid #e2e8f0;background:#f8fafc;border-radius:0 0 12px 12px}.showing-info{font-size:14px;color:#64748b;font-weight:500}.pagination-container{display:flex;align-items:center}.custom-pagination{display:flex;list-style:none;padding:0;margin:0;gap:4px;align-items:center}.custom-pagination .page-item{display:inline-block}.custom-pagination .page-link{display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 12px;font-size:14px;font-weight:500;color:#475569;background:white;border:1px solid #e2e8f0;border-radius:8px;text-decoration:none;transition:all 0.2s ease;cursor:pointer}.custom-pagination .page-link:hover{background:#f1f5f9;border-color:#cbd5e0;color:#1e293b;transform:translateY(-1px)}.custom-pagination .page-item.active .page-link{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-color:#667eea;color:white;font-weight:600;box-shadow:0 4px 12px rgba(102,126,234,0.3)}.custom-pagination .page-item.disabled .page-link{color:#cbd5e0;background:#f8fafc;border-color:#e2e8f0;cursor:not-allowed;pointer-events:none}.custom-pagination .page-link i{font-size:12px}</style>
        @endif
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; padding: 20px 24px;">
                <h5 class="modal-title" style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-plus"></i>
                    Tambah Jenis Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.jenis-sanksi.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 24px;">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Nama Sanksi</label>
                        <input type="text" name="nama_sanksi" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Kategori</label>
                        <select name="kategori" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Kategori</option>
                            <option value="RINGAN">RINGAN</option>
                            <option value="SEDANG">SEDANG</option>
                            <option value="BERAT">BERAT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; resize: vertical; min-height: 80px;" rows="3"></textarea>
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
                    Edit Jenis Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 24px;">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Nama Sanksi</label>
                        <input type="text" name="nama_sanksi" id="edit_nama_sanksi" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Kategori</label>
                        <select name="kategori" id="edit_kategori" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; appearance: none; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'%3E%3Cpath fill=\'%23a0aec0\' d=\'M6 9L1 4h10z\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 14px center;" required>
                            <option value="">Pilih Kategori</option>
                            <option value="RINGAN">RINGAN</option>
                            <option value="SEDANG">SEDANG</option>
                            <option value="BERAT">BERAT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; resize: vertical; min-height: 80px;" rows="3"></textarea>
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
                    Detail Jenis Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Nama Sanksi</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_nama_sanksi">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Kategori</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_kategori">-</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-group" style="margin-bottom: 16px;">
                            <div class="detail-label" style="font-size: 11px; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Deskripsi</div>
                            <div class="detail-value" style="font-size: 14px; color: #2d3748; font-weight: 500;" id="detail_deskripsi">-</div>
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
function showDetail(id) {
    fetch(`/admin/jenis-sanksi/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detail_nama_sanksi').textContent = data.nama_sanksi || '-';
            document.getElementById('detail_kategori').textContent = data.kategori || '-';
            document.getElementById('detail_deskripsi').textContent = data.deskripsi || '-';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('detail_nama_sanksi').textContent = '-';
            document.getElementById('detail_kategori').textContent = '-';
            document.getElementById('detail_deskripsi').textContent = '-';
        });
}

function editData(id) {
    fetch(`/admin/jenis-sanksi/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editForm').action = `/admin/jenis-sanksi/${id}`;
            document.getElementById('edit_nama_sanksi').value = data.nama_sanksi || '';
            document.getElementById('edit_kategori').value = data.kategori || '';
            document.getElementById('edit_deskripsi').value = data.deskripsi || '';
        })
        .catch(error => console.error('Error:', error));
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
            form.action = `/admin/jenis-sanksi/${id}`;
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
        
        const kategoriFilter = document.getElementById('filterKategori').value;
        const rowKategori = row.dataset.kategori;
        const matchesKategori = !kategoriFilter || rowKategori === kategoriFilter;
        
        if (text.includes(filter) && matchesKategori) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

function filterByKategori() {
    const select = document.getElementById('filterKategori');
    const filter = select.value;
    const table = document.getElementById('sanksiTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const kategori = row.dataset.kategori;
        
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const text = row.textContent.toLowerCase();
        const matchesSearch = !searchInput || text.includes(searchInput);
        
        if ((!filter || kategori === filter) && matchesSearch) {
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