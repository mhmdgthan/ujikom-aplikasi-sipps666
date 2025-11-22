@extends('layouts.bk')

@section('title', 'Laporan Konseling')
@section('page-title', 'Laporan Bimbingan Konseling')

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
        padding: 24px;
        border: 1px solid #f1f5f9;
        margin-bottom: 24px;
    }

    .form-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
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

    .btn-generate {
        height: 40px;
        padding: 0 24px;
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

    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .info-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .info-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .info-text {
        font-size: 14px;
        opacity: 0.9;
    }

    /* ================ RESPONSIVE ================ */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 16px;
        }

        .form-card {
            padding: 16px;
        }

        .info-card {
            padding: 16px;
        }

        .info-title {
            font-size: 16px;
        }

        .form-title {
            font-size: 16px;
        }

        .btn-generate {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .row.g-3 > .col-md-6,
        .row.g-3 > .col-md-4 {
            margin-bottom: 16px;
        }

        .form-control, .form-select {
            height: 44px;
        }

        .btn-generate {
            height: 44px;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="info-card">
        <div class="info-title">
            <i class="fas fa-file-alt"></i>
            Generate Laporan Konseling
        </div>
        <div class="info-text">
            Buat laporan konseling berdasarkan filter tahun ajaran, bulan, dan jenis layanan
        </div>
    </div>

    <div class="form-card">
        <div class="form-title">
            <div class="form-icon">
                <i class="fas fa-filter"></i>
            </div>
            Filter Laporan
        </div>

        <form action="{{ route('bk.laporan.generate') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                    <select name="tahun_ajaran_id" class="form-select" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ $ta->status_aktif ? 'selected' : '' }}>
                                {{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}
                                @if($ta->status_aktif) (Aktif) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bulan (Opsional)</label>
                    <select name="bulan" class="form-select">
                        <option value="">-- Semua Bulan --</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis Layanan (Opsional)</label>
                    <select name="jenis_layanan" class="form-select">
                        <option value="">-- Semua Jenis Layanan --</option>
                        <option value="Konseling Individual">Konseling Individual</option>
                        <option value="Konseling Kelompok">Konseling Kelompok</option>
                        <option value="Bimbingan Klasikal">Bimbingan Klasikal</option>
                        <option value="Konsultasi">Konsultasi</option>
                    </select>
                </div>

                <div class="col-md-6 d-flex align-items-end gap-2">
                    <button type="submit" name="format" value="preview" class="btn-generate" style="flex: 1;">
                        <i class="fas fa-eye"></i>
                        Preview
                    </button>
                    <button type="submit" name="format" value="pdf" class="btn-generate" style="flex: 1; background: linear-gradient(135deg, #48bb78, #38a169);">
                        <i class="fas fa-download"></i>
                        Download PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="form-card">
        <div class="form-title">
            <div class="form-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            Informasi Laporan
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div style="text-align: center; padding: 20px; background: #f7fafc; border-radius: 8px;">
                    <div style="font-size: 24px; font-weight: 700; color: #667eea; margin-bottom: 8px;">
                        {{ \App\Models\BimbinganKonseling::count() }}
                    </div>
                    <div style="font-size: 12px; color: #718096; text-transform: uppercase;">Total Konseling</div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="text-align: center; padding: 20px; background: #f7fafc; border-radius: 8px;">
                    <div style="font-size: 24px; font-weight: 700; color: #48bb78; margin-bottom: 8px;">
                        {{ \App\Models\BimbinganKonseling::whereMonth('tanggal_konseling', now()->month)->count() }}
                    </div>
                    <div style="font-size: 12px; color: #718096; text-transform: uppercase;">Bulan Ini</div>
                </div>
            </div>
            <div class="col-md-4">
                <div style="text-align: center; padding: 20px; background: #f7fafc; border-radius: 8px;">
                    <div style="font-size: 24px; font-weight: 700; color: #ed8936; margin-bottom: 8px;">
                        {{ \App\Models\BimbinganKonseling::where('status', 'Selesai')->count() }}
                    </div>
                    <div style="font-size: 12px; color: #718096; text-transform: uppercase;">Selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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