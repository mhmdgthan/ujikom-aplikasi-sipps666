<table class="data-table">
    <thead>
        <tr>
            <th>No</th>
            @if($request->jenis_laporan === 'pelanggaran')
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Status</th>
            @elseif($request->jenis_laporan === 'prestasi')
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Prestasi</th>
                <th>Poin</th>
                <th>Status</th>
            @elseif($request->jenis_laporan === 'konseling')
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Masalah</th>
                <th>Solusi</th>
                <th>Tanggal</th>
            @else
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            @if($request->jenis_laporan === 'pelanggaran')
                <td>{{ $item->nama_siswa }}</td>
                <td>{{ $item->kelas_siswa }}</td>
                <td>{{ $item->jenis_pelanggaran_nama }}</td>
                <td>-{{ $item->poin }}</td>
                <td>{{ ucfirst($item->status_verifikasi) }}</td>
            @elseif($request->jenis_laporan === 'prestasi')
                <td>{{ $item->siswa->user->nama_lengkap ?? '-' }}</td>
                <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $item->jenisPrestasi->nama_prestasi }}</td>
                <td>+{{ $item->poin }}</td>
                <td>{{ ucfirst($item->status_verifikasi) }}</td>
            @elseif($request->jenis_laporan === 'konseling')
                <td>{{ $item->siswa->user->nama_lengkap ?? '-' }}</td>
                <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $item->masalah ?? '-' }}</td>
                <td>{{ $item->solusi ?? '-' }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
            @else
                <td>{{ $item->nis }}</td>
                <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $item->agama }}</td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="{{ $request->jenis_laporan === 'siswa' ? '6' : ($request->jenis_laporan === 'konseling' ? '6' : ($request->jenis_laporan === 'pelanggaran' ? '6' : '6')) }}" style="text-align: center; padding: 40px; color: #a0aec0;">
                Tidak ada data yang ditemukan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>