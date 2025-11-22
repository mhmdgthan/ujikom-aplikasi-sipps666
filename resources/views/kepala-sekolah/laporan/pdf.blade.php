<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($request->jenis_laporan) }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">SMK Bakti Nusantara 666</div>
        <div>Laporan {{ ucfirst($request->jenis_laporan) }}</div>
        <div>{{ date('d/m/Y') }}</div>
    </div>

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
                    <td colspan="4" style="text-align: center;">Tidak ada data siswa</td>
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
                    <td colspan="6" style="text-align: center;">Tidak ada data pelanggaran</td>
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
                    <td colspan="6" style="text-align: center;">Tidak ada data prestasi</td>
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
                    <td>{{ $konseling->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data konseling</td>
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
                    <td colspan="7" style="text-align: center;">Tidak ada data rekap</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</body>
</html>