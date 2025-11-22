<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Monitoring All Data</title>
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
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-ringan { background: #d4edda; color: #155724; }
        .badge-sedang { background: #fff3cd; color: #856404; }
        .badge-berat { background: #f8d7da; color: #721c24; }
        .badge-disetujui { background: #d4edda; color: #155724; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-ditolak { background: #f8d7da; color: #721c24; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN MONITORING ALL DATA</h1>
        <p>Sistem Informasi Pelanggaran Siswa</p>
        @if($tanggalMulai && $tanggalSelesai)
            <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}</p>
        @else
            <p>Semua Data</p>
        @endif
    </div>

    <div class="info-box">
        <strong>Informasi Laporan:</strong><br>
        Tanggal Cetak: {{ date('d/m/Y H:i:s') }}<br>
        Dicetak oleh: Admin
    </div>

    <div class="stats-grid">
        @if(isset($stats['siswa']))
        <div class="stat-card">
            <div class="stat-number">{{ $stats['siswa'] }}</div>
            <div class="stat-label">Total Siswa</div>
        </div>
        @endif
        @if(isset($stats['guru']))
        <div class="stat-card">
            <div class="stat-number">{{ $stats['guru'] }}</div>
            <div class="stat-label">Total Guru</div>
        </div>
        @endif
        @if(isset($stats['pelanggaran']))
        <div class="stat-card">
            <div class="stat-number">{{ $stats['pelanggaran'] }}</div>
            <div class="stat-label">Pelanggaran</div>
        </div>
        @endif
        @if(isset($stats['prestasi']))
        <div class="stat-card">
            <div class="stat-number">{{ $stats['prestasi'] }}</div>
            <div class="stat-label">Prestasi</div>
        </div>
        @endif
        @if(isset($stats['sanksi']))
        <div class="stat-card">
            <div class="stat-number">{{ $stats['sanksi'] }}</div>
            <div class="stat-label">Sanksi</div>
        </div>
        @endif
        @if(isset($stats['kelas']))
        <div class="stat-card">
            <div class="stat-number">{{ $stats['kelas'] }}</div>
            <div class="stat-label">Kelas</div>
        </div>
        @endif
        @if(isset($stats['jurusan']))
        <div class="stat-card">
            <div class="stat-number">{{ $stats['jurusan'] }}</div>
            <div class="stat-label">Jurusan</div>
        </div>
        @endif
    </div>

    @if(isset($data['pelanggaran']) && $data['pelanggaran']->count() > 0)
    <div class="section-title">Data Pelanggaran</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['pelanggaran'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                <td>{{ $item->jenisPelanggaran->nama_pelanggaran ?? 'Jenis tidak tersedia' }}</td>
                <td>{{ $item->poin ?? 0 }}</td>
                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                <td><span class="badge badge-{{ strtolower($item->status_verifikasi) }}">{{ ucfirst($item->status_verifikasi) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if(isset($data['prestasi']) && $data['prestasi']->count() > 0)
    <div class="section-title">Data Prestasi</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Jenis Prestasi</th>
                <th>Tingkat</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['prestasi'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                <td>{{ $item->jenisPrestasi->nama_prestasi ?? 'Jenis tidak tersedia' }}</td>
                <td>{{ $item->tingkat ?? 'Belum ditentukan' }}</td>
                <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                <td><span class="badge badge-{{ strtolower($item->status_verifikasi) }}">{{ ucfirst($item->status_verifikasi) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if(isset($data['sanksi']) && $data['sanksi']->count() > 0)
    <div class="section-title">Data Sanksi</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Jenis Sanksi</th>
                <th>Deskripsi</th>
                <th>Tanggal Mulai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['sanksi'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->pelanggaran->siswa->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                <td>{{ $item->jenis_sanksi ?? 'Jenis tidak tersedia' }}</td>
                <td>{{ $item->deskripsi_sanksi ? Str::limit($item->deskripsi_sanksi, 50) : 'Tidak ada deskripsi' }}</td>
                <td>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                <td><span class="badge badge-{{ strtolower($item->status) }}">{{ ucfirst($item->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if(isset($data['siswa']) && $data['siswa']->count() > 0)
    <div class="section-title">Data Siswa</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['siswa'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->user->nama_lengkap ?? 'Nama tidak tersedia' }}</td>
                <td>{{ $item->nisn ?? 'NISN tidak tersedia' }}</td>
                <td>{{ $item->kelas->nama_kelas ?? 'Belum ada kelas' }}</td>
                <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if(isset($data['guru']) && $data['guru']->count() > 0)
    <div class="section-title">Data Guru</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>NIP</th>
                <th>Mata Pelajaran</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['guru'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_guru }}</td>
                <td>{{ $item->nip ?? 'NIP tidak tersedia' }}</td>
                <td>{{ $item->mata_pelajaran ?? 'Belum ditentukan' }}</td>
                <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if(isset($data['kelas']) && $data['kelas']->count() > 0)
    <div class="section-title">Data Kelas</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Jurusan</th>
                <th>Tingkat</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['kelas'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_kelas }}</td>
                <td>{{ $item->jurusan->nama_jurusan ?? 'Belum ada jurusan' }}</td>
                <td>{{ $item->tingkat ?? 'Belum ditentukan' }}</td>
                <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if(isset($data['jurusan']) && $data['jurusan']->count() > 0)
    <div class="section-title">Data Jurusan</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jurusan</th>
                <th>Kode Jurusan</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['jurusan'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_jurusan }}</td>
                <td>{{ $item->kode_jurusan }}</td>
                <td>{{ $item->deskripsi ? Str::limit($item->deskripsi, 40) : 'Belum ada deskripsi' }}</td>
                <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>