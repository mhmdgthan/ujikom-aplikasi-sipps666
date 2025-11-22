@extends('layouts.kesiswaan')

@section('title', 'Laporan Data')
@section('page-title', 'Laporan Data')

@push('styles')
<style>
    .content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .form-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        padding: 24px;
        margin-bottom: 24px;
    }

    .form-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
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

    .btn-generate {
        height: 40px;
        padding: 0 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-export {
        height: 40px;
        padding: 0 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #4a5568;
    }

    .btn-export.pdf {
        border-color: #e53e3e;
        color: #e53e3e;
    }

    .btn-export.excel {
        border-color: #38a169;
        color: #38a169;
    }

    .btn-export:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .export-buttons {
        display: flex;
        gap: 12px;
        margin-top: 16px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        display: block;
    }

    .preview-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        margin-top: 24px;
    }

    .preview-header {
        padding: 16px 20px;
        background: #f7fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
        color: #2d3748;
    }

    .preview-body {
        padding: 20px;
        max-height: 400px;
        overflow-y: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        padding: 12px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #4a5568;
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0;
        background: #f7fafc;
    }

    .data-table td {
        padding: 12px;
        font-size: 13px;
        color: #4a5568;
        border-bottom: 1px solid #f1f5f9;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="form-card">
        <div class="form-title">
            <i class="fas fa-file-alt"></i>
            Generate Laporan
        </div>
        
        <form id="laporanForm" action="{{ route('kesiswaan.laporan.generate') }}" method="POST">
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
                        <button type="button" class="btn-export pdf" onclick="exportData('pdf')">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </button>
                        <button type="button" class="btn-export excel" onclick="exportData('excel')">
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
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Gagal memuat preview data'
        });
    });
});

function exportData(format) {
    const form = document.getElementById('laporanForm');
    const formData = new FormData(form);
    formData.append('format', format);
    
    // Create temporary form for download
    const tempForm = document.createElement('form');
    tempForm.method = 'POST';
    tempForm.action = form.action;
    tempForm.style.display = 'none';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    tempForm.appendChild(csrfInput);
    
    // Add form data
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