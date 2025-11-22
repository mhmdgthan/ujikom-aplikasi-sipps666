@extends('layouts.main')

@section('title', 'Backup System')
@section('page-title', 'Backup & Restore Database')

@push('styles')
<style>
.content-wrapper {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.page-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.btn-backup {
    background: linear-gradient(135deg, #48bb78, #38a169);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-backup:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
}

.backup-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.2s;
}

.backup-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.backup-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.backup-details h5 {
    margin: 0 0 8px 0;
    color: #2d3748;
    font-weight: 600;
}

.backup-meta {
    font-size: 13px;
    color: #718096;
}

.backup-actions {
    display: flex;
    gap: 8px;
}

.btn-action {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-download {
    background: #bee3f8;
    color: #2c5282;
}

.btn-delete {
    background: #fed7d7;
    color: #742a2a;
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
    <div class="page-actions">
        <div>
            <h4 style="margin: 0; color: #2d3748;">Backup System</h4>
            <p style="margin: 0; color: #718096; font-size: 14px;">Kelola backup database dan aplikasi</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <form action="{{ route('admin.backup.create') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-backup">
                    <i class="fas fa-database"></i>
                    Backup Database
                </button>
            </form>
            <a href="{{ route('admin.backup.download-app') }}" class="btn-backup" style="text-decoration: none; background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-file-archive"></i>
                Download Aplikasi
            </a>
        </div>
    </div>

    @if($backups->count() > 0)
        @foreach($backups as $backup)
        <div class="backup-card">
            <div class="backup-info">
                <div class="backup-details">
                    <h5>{{ $backup['name'] }}</h5>
                    <div class="backup-meta">
                        <i class="fas fa-calendar"></i> {{ date('d M Y H:i', $backup['date']) }} | 
                        <i class="fas fa-hdd"></i> {{ number_format($backup['size'] / 1024, 2) }} KB
                    </div>
                </div>
                <div class="backup-actions">
                    <a href="{{ route('admin.backup.download', basename($backup['name'])) }}" class="btn-action btn-download">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <form action="{{ route('admin.backup.destroy', basename($backup['name'])) }}" method="POST" class="d-inline form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-database"></i>
            </div>
            <h5>Belum Ada Backup</h5>
            <p>Klik "Buat Backup Baru" untuk membuat backup database pertama</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Backup?',
            text: "File backup yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
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
    confirmButtonColor: '#e53e3e'
});
@endif
</script>
@endpush