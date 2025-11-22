<?php

namespace App\Exports;

class LaporanExport
{
    protected $data;
    protected $request;

    public function __construct($data, $request)
    {
        $this->data = $data;
        $this->request = $request;
    }

    public function export()
    {
        $headers = $this->getHeaders();
        $rows = $this->getRows();
        
        $filename = 'laporan_' . $this->request->jenis_laporan . '_' . date('Y-m-d') . '.xls';
        
        $html = '<html><head><meta charset="UTF-8"></head><body>';
        $html .= '<table border="1">';
        
        $html .= '<tr>';
        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr>';
        
        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        
        $html .= '</table></body></html>';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $html;
        exit;
    }

    private function getHeaders()
    {
        switch ($this->request->jenis_laporan) {
            case 'pelanggaran':
                return ['No', 'Nama Siswa', 'Kelas', 'Jenis Pelanggaran', 'Poin', 'Status', 'Tanggal'];
            case 'prestasi':
                return ['No', 'Nama Siswa', 'Kelas', 'Jenis Prestasi', 'Poin', 'Status', 'Tanggal'];
            case 'siswa':
                return ['No', 'NIS', 'Nama Siswa', 'Kelas', 'Jenis Kelamin', 'Agama'];
            case 'konseling':
                return ['No', 'Nama Siswa', 'Kelas', 'Masalah', 'Solusi', 'Tanggal'];
            default:
                return [];
        }
    }

    private function getRows()
    {
        $rows = [];
        $no = 1;

        foreach ($this->data as $item) {
            switch ($this->request->jenis_laporan) {
                case 'pelanggaran':
                    $rows[] = [
                        $no,
                        $item->siswa->user->nama_lengkap ?? '-',
                        $item->siswa->kelas->nama_kelas ?? '-',
                        $item->jenisPelanggaran?->nama_pelanggaran ?? '-',
                        '-' . $item->poin,
                        ucfirst($item->status_verifikasi),
                        $item->created_at->format('d/m/Y')
                    ];
                    break;
                case 'prestasi':
                    $rows[] = [
                        $no,
                        $item->siswa->user->nama_lengkap ?? '-',
                        $item->siswa->kelas->nama_kelas ?? '-',
                        $item->jenisPrestasi->nama_prestasi ?? '-',
                        '+' . $item->poin,
                        ucfirst($item->status_verifikasi),
                        $item->created_at->format('d/m/Y')
                    ];
                    break;
                case 'siswa':
                    $rows[] = [
                        $no,
                        $item->nis,
                        $item->user->nama_lengkap ?? '-',
                        $item->kelas->nama_kelas ?? '-',
                        $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                        $item->agama
                    ];
                    break;
                case 'konseling':
                    $rows[] = [
                        $no,
                        $item->siswa->user->nama_lengkap ?? '-',
                        $item->siswa->kelas->nama_kelas ?? '-',
                        $item->masalah ?? '-',
                        $item->solusi ?? '-',
                        $item->created_at->format('d/m/Y')
                    ];
                    break;
            }
            $no++;
        }

        return $rows;
    }
}