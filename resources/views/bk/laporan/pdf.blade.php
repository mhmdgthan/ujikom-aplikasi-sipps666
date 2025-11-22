<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Konseling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: normal;
        }
        
        .info {
            margin-bottom: 20px;
        }
        
        .info table {
            width: 100%;
        }
        
        .info td {
            padding: 3px 0;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .data-table th,
        .data-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        
        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        
        .signature {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMK BAKTI NUSANTARA 666</h1>
        <h2>LAPORAN BIMBINGAN KONSELING</h2>
        <p>{{ $tahunAjaran->tahun_ajaran }} - {{ ucfirst($tahunAjaran->semester) }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="150">Tahun Ajaran</td>
                <td width="10">:</td>
                <td>{{ $tahunAjaran->tahun_ajaran }} - {{ ucfirst($tahunAjaran->semester) }}</td>
            </tr>
            @if($request->bulan)
            <tr>
                <td>Bulan</td>
                <td>:</td>
                <td>
                    @php
                        $bulanNama = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    {{ $bulanNama[$request->bulan] }}
                </td>
            </tr>
            @endif
            @if($request->jenis_layanan)
            <tr>
                <td>Jenis Layanan</td>
                <td>:</td>
                <td>{{ $request->jenis_layanan }}</td>
            </tr>
            @endif
            <tr>
                <td>Total Data</td>
                <td>:</td>
                <td>{{ $konseling->count() }} konseling</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>:</td>
                <td>{{ date('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th width="15%">Jenis Layanan</th>
                <th width="20%">Topik</th>
                <th width="10%">Tanggal</th>
                <th width="10%">Status</th>
                <th width="10%">Konselor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($konseling as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->siswa->user->nama_lengkap ?? '-' }}</td>
                <td class="text-center">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $item->jenis_layanan }}</td>
                <td>{{ $item->topik }}</td>
                <td class="text-center">{{ $item->tanggal_konseling->format('d/m/Y') }}</td>
                <td class="text-center">{{ $item->status ?? 'Berlangsung' }}</td>
                <td>{{ $item->konselor->nama_lengkap ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data konseling</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>{{ date('d F Y') }}</p>
            <p>Guru BK</p>
            <br><br><br>
            <p>_________________________</p>
        </div>
    </div>
</body>
</html>