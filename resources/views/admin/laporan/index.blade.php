@extends('layouts.main')

@section('title', 'Laporan Data')
@section('page-title', 'Laporan Data')

@push('page-styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/laporan.css') }}">
@endpush

@section('content')
<div class="content-wrapper">
    <div class="form-card">
        <div class="form-title">
            <i class="fas fa-file-alt"></i>
            Generate Laporan
        </div>
        
        <form id="laporanForm" action="{{ route('admin.laporan.generate') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Jenis Laporan <span class="text-danger">*</span></label>
                    <select name="jenis_laporan" class="form-select" required>
                        <option value="">-- Pilih Jenis Laporan --</option>
                        <option value="pelanggaran">Laporan Pelanggaran</option>
                        <option value="prestasi">Laporan Prestasi</option>
                        <option value="siswa">Laporan Data Siswa</option>
                        <option value="konseling">Laporan Konseling</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Filter Kelas</label>
                    <select name="kelas_id" class="form-select">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control">
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn-generate">
                        <i class="fas fa-search"></i>
                        Generate Preview
                    </button>
                    
                    <div class="export-buttons">
                        <button type="button" class="btn-export" onclick="exportData('pdf')">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </button>
                        <button type="button" class="btn-export" onclick="exportData('excel')">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="previewSection" style="display: none;">
        <div class="preview-card">
            <div class="preview-header">
                <i class="fas fa-eye"></i>
                Preview Data
            </div>
            <div class="preview-body" id="previewContent">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('laporanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('previewContent').innerHTML = html;
        document.getElementById('previewSection').style.display = 'block';
    });
});

function exportData(format) {
    const form = document.getElementById('laporanForm');
    const formData = new FormData(form);
    formData.append('format', format);
    
    const tempForm = document.createElement('form');
    tempForm.method = 'POST';
    tempForm.action = form.action;
    tempForm.style.display = 'none';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    tempForm.appendChild(csrfInput);
    
    for (let [key, value] of formData.entries()) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        tempForm.appendChild(input);
    }
    
    document.body.appendChild(tempForm);
    tempForm.submit();
    document.body.removeChild(tempForm);
}
</script>
@endpush