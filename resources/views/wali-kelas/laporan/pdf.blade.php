<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($request->jenis_laporan) }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; font-weight: bold; }
        .header h2 { margin: 5px 0; font-size: 16px; font-weight: normal; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 11px; }
        th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMK BAKTI NUSANTARA 666</h1>
        <h2>LAPORAN {{ strtoupper($request->jenis_laporan) }}</h2>
    </div>

    <div class="info">
        <table style="border: none;">
            <tr>
                <td style="border: none; width: 150px;">Jenis Laporan</td>
                <td style="border: none; width: 10px;">:</td>
                <td style="border: none;">{{ ucfirst($request->jenis_laporan) }}</td>
            </tr>
            <tr>
                <td style="border: none;">Tanggal Cetak</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ date('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                @if($request->jenis_laporan === 'pelanggaran')
                    <th width="30%">Nama Siswa</th>
                    <th width="15%">Kelas</th>
                    <th width="30%">Jenis Pelanggaran</th>
                    <th width="15%">Poin</th>
                    <th width="10%">Status</th>
                @elseif($request->jenis_laporan === 'prestasi')
                    <th width="25%">Nama Siswa</th>
                    <th width="15%">Kelas</th>
                    <th width="30%">Jenis Prestasi</th>
                    <th width="15%">Poin</th>
                    <th width="10%">Status</th>
                @else
                    <th width="15%">NIS</th>
                    <th width="30%">Nama Siswa</th>
                    <th width="15%">Kelas</th>
                    <th width="20%">Jenis Kelamin</th>
                    <th width="15%">Agama</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                @if($request->jenis_laporan === 'pelanggaran')
                    <td>{{ $item->siswa->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                    <td class="text-center">-{{ $item->poin }}</td>
                    <td class="text-center">{{ ucfirst($item->status_verifikasi) }}</td>
                @elseif($request->jenis_laporan === 'prestasi')
                    <td>{{ $item->siswa->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $item->jenisPrestasi->nama_prestasi }}</td>
                    <td class="text-center">+{{ $item->poin }}</td>
                    <td class="text-center">{{ ucfirst($item->status_verifikasi) }}</td>
                @else
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                    <td class="text-center">{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="text-center">{{ $item->agama }}</td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ $request->jenis_laporan === 'siswa' ? '6' : ($request->jenis_laporan === 'pelanggaran' ? '6' : '6') }}" class="text-center">
                    Tidak ada data yang ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $data->count() }}</p>
        <br><br>
        <p>Mengetahui,<br>Wali Kelas</p>
        <br><br><br>
        <p>_________________________</p>
    </div>
</body>
</html>