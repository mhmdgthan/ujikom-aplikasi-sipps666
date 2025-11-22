@extends('layouts.main')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('sidebar-menu')
<a href="{{ route('kepala-sekolah.dashboard') }}" class="menu-item">
    <i class="fas fa-home"></i>
    <span>Dashboard</span>
</a>
<a href="{{ route('kepala-sekolah.siswa.index') }}" class="menu-item active">
    <i class="fas fa-users"></i>
    <span>Data Siswa</span>
</a>
@endsection

@section('content')
@if(session('success'))
<div style="padding: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; margin-bottom: 20px;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Profil Siswa -->
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>
            <i class="fas fa-user-circle"></i>
            Profil Siswa
        </h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('kepala-sekolah.siswa.edit', $siswa->id) }}" style="padding: 10px 20px; background: #FF9800; color: white; text-decoration: none; border-radius: 8px;">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('kepala-sekolah.siswa.reset-password', $siswa->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Reset password ke NIS?')">
                @csrf
                <button type="submit" style="padding: 10px 20px; background: #9C27B0; color: white; border: none; border-radius: 8px; cursor: pointer;">
                    <i class="fas fa-key"></i> Reset Password
                </button>
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: auto 1fr; gap: 30px;">
        <!-- Foto -->
        <div style="text-align: center;">
            @if($siswa->foto)
                <img src="{{ $siswa->foto && str_starts_with($siswa->foto, 'siswa/') ? asset('storage/' . $siswa->foto) : asset('uploads/siswa/' . $siswa->foto) }}" alt="Foto" style="width: 150px; height: 150px; border-radius: 12px; object-fit: cover; border: 3px solid #2196F3;">
            @else
                <div style="width: 150px; height: 150px; border-radius: 12px; background: #e0e0e0; display: flex; align-items: center; justify-content: center; font-size: 48px; color: #999;">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </div>

        <!-- Data Siswa -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
            <div>
                <p style="color: #999; margin-bottom: 5px;">NIS</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->nis }}</p>
            </div>
            <div>
                <p style="color: #999; margin-bottom: 5px;">NISN</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->nisn }}</p>
            </div>
            <div>
                <p style="color: #999; margin-bottom: 5px;">Nama Lengkap</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->user->nama_lengkap ?? '-' }}</p>
            </div>
            <div>
                <p style="color: #999; margin-bottom: 5px;">Kelas</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            </div>
            <div>
                <p style="color: #999; margin-bottom: 5px;">Jenis Kelamin</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div>
                <p style="color: #999; margin-bottom: 5px;">Agama</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->agama }}</p>
            </div>
            <div>
                <p style="color: #999; margin-bottom: 5px;">Tempat, Tanggal Lahir</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->format('d/m/Y') }}</p>
            </div>
            <div>
                <p style="color: #999; margin-bottom: 5px;">No Telepon</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->no_telepon ?? '-' }}</p>
            </div>
            <div style="grid-column: span 3;">
                <p style="color: #999; margin-bottom: 5px;">Alamat</p>
                <p style="font-weight: 600; font-size: 16px;">{{ $siswa->alamat }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 20px;">
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $siswa->getTotalPoinPelanggaran($tahunAjaranAktif?->id) }}</h3>
            <p>Poin Pelanggaran</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-trophy"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $siswa->getTotalPoinPrestasi($tahunAjaranAktif?->id) }}</h3>
            <p>Poin Prestasi</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $siswa->getPoinBersih($tahunAjaranAktif?->id) }}</h3>
            <p>Poin Bersih</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="stat-info">
            <h3 style="font-size: 20px;">{{ $siswa->getKategoriRisiko($tahunAjaranAktif?->id) }}</h3>
            <p>Status Risiko</p>
        </div>
    </div>
</div>

<!-- Riwayat Pelanggaran -->
<div class="content-card">
    <h3>
        <i class="fas fa-history"></i>
        Riwayat Pelanggaran
    </h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Kategori</th>
                    <th>Poin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa->pelanggaran()->latest()->take(10)->get() as $item)
                <tr>
                    <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                    <td><span class="badge badge-{{ $item->jenisPelanggaran->kategori == 'ringan' ? 'warning' : 'danger' }}">{{ ucfirst($item->jenisPelanggaran->kategori) }}</span></td>
                    <td><span class="badge badge-danger">{{ $item->poin }} Poin</span></td>
                    <td>
                        @if($item->status_verifikasi == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($item->status_verifikasi == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #4CAF50;">
                        <i class="fas fa-check-circle"></i> Tidak ada pelanggaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Riwayat Prestasi -->
<div class="content-card">
    <h3>
        <i class="fas fa-medal"></i>
        Riwayat Prestasi
    </h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Prestasi</th>
                    <th>Tingkat</th>
                    <th>Poin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa->prestasi()->latest()->take(10)->get() as $item)
                <tr>
                    <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->jenisPrestasi->nama_prestasi }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($item->tingkat) }}</span></td>
                    <td><span class="badge badge-success">{{ $item->poin }} Poin</span></td>
                    <td>
                        @if($item->status_verifikasi == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($item->status_verifikasi == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada prestasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
