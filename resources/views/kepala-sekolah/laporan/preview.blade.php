@extends('layouts.kepala-sekolah')

@section('title', 'Preview Laporan')
@section('page-title', 'Preview Laporan')

@section('content')
<div class="content-card">
    <div class="content-card-header">
        <div class="content-card-title">
            <i class="fas fa-file-alt"></i>
            Preview Laporan {{ ucfirst($request->jenis_laporan) }}
        </div>
        <div>
            <form action="{{ route('kepala-sekolah.laporan.generate') }}" method="POST" style="display: inline-block;">
                @csrf
                @foreach($request->all() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </button>
            </form>
            <form action="{{ route('kepala-sekolah.laporan.generate') }}" method="POST" style="display: inline-block;">
                @csrf
                @foreach($request->all() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input type="hidden" name="format" value="excel">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Download Excel
                </button>
            </form>
        </div>
    </div>
    <div class="content-card-body">
        <div class="table-wrapper">
        @if($request->jenis_laporan == 'siswa')
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data siswa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        @elseif($request->jenis_laporan == 'pelanggaran')
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $pelanggaran)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pelanggaran->tanggal ? \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $pelanggaran->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                            <td>{{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                            <td>{{ $pelanggaran->poin }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        @elseif($request->jenis_laporan == 'prestasi')
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Prestasi</th>
                            <th>Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $prestasi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $prestasi->tanggal_prestasi ? \Carbon\Carbon::parse($prestasi->tanggal_prestasi)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $prestasi->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                            <td>{{ $prestasi->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $prestasi->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                            <td>{{ $prestasi->poin }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data prestasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        @elseif($request->jenis_laporan == 'konseling')
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Konselor</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $konseling)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $konseling->tanggal_konseling ? \Carbon\Carbon::parse($konseling->tanggal_konseling)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $konseling->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                            <td>{{ $konseling->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $konseling->konselor->nama_lengkap ?? '-' }}</td>
                            <td>{{ Str::limit($konseling->keterangan, 50) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data konseling</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        @elseif($request->jenis_laporan == 'rekap')
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Pelanggaran</th>
                            <th>Total Prestasi</th>
                            <th>Poin Pelanggaran</th>
                            <th>Poin Prestasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $siswa->pelanggaran->count() }}</td>
                            <td>{{ $siswa->prestasi->count() }}</td>
                            <td>{{ $siswa->pelanggaran->sum('poin') }}</td>
                            <td>{{ $siswa->prestasi->sum('poin') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data rekap</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        @endif
        </div>
    </div>
</div>
@endsection