@extends('layouts.bk')

@section('title', 'Siswa Perlu Konseling')
@section('page-title', 'Siswa yang Perlu Konseling')

@push('styles')
<style>
.content-wrapper {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.student-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.2s;
}

.student-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.student-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.student-details h5 {
    margin: 0 0 8px 0;
    color: #2d3748;
    font-weight: 600;
}

.student-meta {
    font-size: 13px;
    color: #718096;
    margin-bottom: 8px;
}

.violation-badge {
    background: #fed7d7;
    color: #742a2a;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.btn-konseling {
    background: #48bb78;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
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
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div style="margin-bottom: 24px;">
        <h4 style="margin: 0; color: #2d3748;">Siswa yang Perlu Konseling</h4>
        <p style="margin: 0; color: #718096; font-size: 14px;">Daftar siswa yang memiliki pelanggaran dan belum mendapat konseling</p>
    </div>

    @if($siswaPerluKonseling->count() > 0)
        @foreach($siswaPerluKonseling as $siswa)
        <div class="student-card">
            <div class="student-info">
                <div class="student-details">
                    <h5>{{ $siswa->user->nama_lengkap }}</h5>
                    <div class="student-meta">
                        <i class="fas fa-id-card"></i> {{ $siswa->nis }} | 
                        <i class="fas fa-school"></i> {{ $siswa->kelas->nama_kelas ?? 'Belum ada kelas' }}
                    </div>
                    <div class="student-meta">
                        <span class="violation-badge">
                            {{ $siswa->total_pelanggaran }} Pelanggaran
                        </span>
                        @if($siswa->pelanggaran_terbaru)
                        <span style="margin-left: 8px;">
                            Terakhir: {{ $siswa->pelanggaran_terbaru->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}
                            ({{ date('d/m/Y', strtotime($siswa->pelanggaran_terbaru->tanggal_pelanggaran)) }})
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <h5>Tidak Ada Siswa yang Perlu Konseling</h5>
            <p>Semua siswa yang melanggar sudah mendapat konseling atau belum ada pelanggaran</p>
        </div>
    @endif
</div>
@endsection