<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($request->jenis_laporan) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMK BAKTI NUSANTARA 666</h1>
        <h2>LAPORAN {{ strtoupper($request->jenis_laporan) }}</h2>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ date('d F Y H:i:s') }}</p>
        @if($request->kelas_id)
            <p><strong>Kelas:</strong> {{ $data->first()->siswa->kelas->nama_kelas ?? 'Semua Kelas' }}</p>
        @endif
        @if($request->tanggal_mulai && $request->tanggal_selesai)
            <p><strong>Periode:</strong> {{ date('d F Y', strtotime($request->tanggal_mulai)) }} - {{ date('d F Y', strtotime($request->tanggal_selesai)) }}</p>
        @endif
        <p><strong>Total Data:</strong> {{ $data->count() }} record</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                @if($request->jenis_laporan == 'pelanggaran')
                    <th width="20%">Nama Siswa</th>
                    <th width="10%">Kelas</th>
                    <th width="15%">Jurusan</th>
                    <th width="20%">Jenis Pelanggaran</th>
                    <th width="8%">Poin</th>
                    <th width="12%">Tanggal</th>
                    <th width="15%">Guru Pencatat</th>
                @elseif($request->jenis_laporan == 'prestasi')
                    <th width="20%">Nama Siswa</th>
                    <th width="12%">Kelas</th>
                    <th width="12%">Jurusan</th>
                    <th width="20%">Jenis Prestasi</th>
                    <th width="12%">Kategori</th>
                    <th width="8%">Poin</th>
                    <th width="16%">Tanggal</th>
                @elseif($request->jenis_laporan == 'siswa')
                    <th width="25%">Nama Lengkap</th>
                    <th width="12%">NIS</th>
                    <th width="12%">NISN</th>
                    <th width="15%">Kelas</th>
                    <th width="20%">Jurusan</th>
                    <th width="16%">Jenis Kelamin</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                @if($request->jenis_laporan == 'pelanggaran')
                    <td>{{ $item->nama_siswa }}</td>
                    <td>{{ $item->kelas_siswa }}</td>
                    <td>{{ $item->jurusan_siswa }}</td>
                    <td>{{ $item->jenis_pelanggaran_nama }}</td>
                    <td class="text-center">{{ $item->poin ?? 0 }}</td>
                    <td>{{ $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : 'Tidak Diketahui' }}</td>
                    <td>{{ $item->guru_pencatat_nama }}</td>
                @elseif($request->jenis_laporan == 'prestasi')
                    <td>{{ $item->nama_siswa }}</td>
                    <td>{{ $item->kelas_siswa }}</td>
                    <td>{{ $item->jurusan_siswa }}</td>
                    <td>{{ $item->jenis_prestasi_nama }}</td>
                    <td>{{ $item->kategori_prestasi_nama }}</td>
                    <td class="text-center">{{ $item->poin ?? 0 }}</td>
                    <td>{{ $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : 'Tidak Diketahui' }}</td>
                @elseif($request->jenis_laporan == 'siswa')
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->kelas_nama }}</td>
                    <td>{{ $item->jurusan_nama }}</td>
                    <td>{{ $item->jenis_kelamin ?? 'Tidak Diketahui' }}</td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        <p>SMK Bakti Nusantara 666</p>
    </div>
</body>
</html>