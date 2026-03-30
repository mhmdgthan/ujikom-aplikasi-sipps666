# 🏫 SIPPS 666 — Sistem Informasi Poin Pelanggaran Siswa

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white)

**Aplikasi web untuk mengelola data pelanggaran, prestasi, dan konseling siswa secara terintegrasi.**

Dibuat sebagai proyek Ujian Kompetensi Kejuruan (UKK) oleh **Muhammad Gathan Prayoga**  
SMK Bakti Nusantara 666 · XII PPLG 1 · 2025

</div>

---

## 📋 Deskripsi

SIPPS 666 adalah aplikasi berbasis **Laravel** yang dirancang untuk membantu sekolah dalam mengelola data pelanggaran siswa secara digital, transparan, dan efisien. Sistem ini mendukung **8 role pengguna** dengan hak akses berbeda untuk proses monitoring dan pelaporan.

---

## ✨ Fitur Utama

- 📊 **Dashboard** statistik real-time per role
- 📝 **Input & Manajemen Pelanggaran** dengan bukti foto
- 🏆 **Manajemen Prestasi** siswa (Akademik & Non-Akademik)
- ⚖️ **Manajemen Sanksi** & Pelaksanaan Sanksi
- 🧠 **Bimbingan Konseling (BK)** dengan laporan konseling
- ✅ **Sistem Verifikasi** data pelanggaran oleh Kesiswaan
- 📄 **Export Laporan** ke PDF dan Excel
- 💾 **Backup Database** langsung dari dashboard Admin
- 🔍 **Filter & Pencarian Canggih** berdasarkan kelas, tanggal, kategori

---

## 👥 Role Pengguna

| Role | Akses |
|------|-------|
| 👑 Admin | Kelola semua data master, input pelanggaran, monitoring, laporan |
| 🏫 Kepala Sekolah | Monitoring & laporan pelanggaran seluruh sekolah |
| 📋 Kesiswaan | Input & verifikasi pelanggaran, monitoring siswa |
| 🧠 Guru BK | Konseling dan pengelolaan data pelanggaran siswa |
| 🏷️ Wali Kelas | Melihat & mencatat pelanggaran siswa kelasnya |
| 👨‍🏫 Guru | Input pelanggaran saat piket, laporan harian |
| 👨‍👩‍👦 Orang Tua | Melihat pelanggaran & prestasi anak |
| 🎓 Siswa | Melihat riwayat pelanggaran & profil pribadi |

---

## 🛠️ Teknologi

| Kategori | Teknologi |
|----------|-----------|
| Framework | Laravel 11.x |
| Database | MySQL |
| Frontend | Bootstrap 5.3 |
| JavaScript | jQuery 3.6 |
| PDF Generator | DomPDF |
| Icons | Font Awesome 6.0 |
| Charts | Chart.js |

---

## 🚀 Cara Install & Menjalankan

```bash
# 1. Clone repository
git clone https://github.com/mhmdgthan/ujikomaplikasi-sipps666.git
cd ujikomaplikasi-sipps666

# 2. Install dependencies
composer install
npm install

# 3. Salin file environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Sesuaikan konfigurasi database di file .env
DB_DATABASE=db_pelanggaran_siwa
DB_USERNAME=root
DB_PASSWORD=

# 6. Migrasi & seed database
php artisan migrate --seed

# 7. Jalankan server
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

---

## 🔐 Akun Demo

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Kepala Sekolah | `danis` | `danis123` |
| Kesiswaan | `dini` | `dini123` |
| Guru BK | `ridwan` | `ridwan123` |
| Wali Kelas | `suhendar` | `suhendar123` |
| Guru | `asep` | `asep123` |
| Orang Tua | `iman` | `iman123` |
| Siswa | `gathan` | `gathan123` |

---

## 📁 Struktur Modul

```
├── Data Master
│   ├── Manajemen User
│   ├── Data Siswa
│   ├── Data Guru
│   ├── Data Kelas
│   ├── Data Wali Kelas
│   ├── Data Jurusan
│   ├── Data Orang Tua
│   └── Tahun Ajaran
├── Jenis & Kategori
│   ├── Jenis Pelanggaran
│   ├── Kategori Pelanggaran
│   ├── Jenis Prestasi
│   └── Jenis Sanksi
├── Pelanggaran & Sanksi
│   ├── Data Pelanggaran
│   ├── Data Sanksi
│   └── Pelaksanaan Sanksi
├── Prestasi
├── Konseling (BK)
├── Verifikasi Data
├── Laporan (PDF & Excel)
├── Monitoring All Data
└── System Backup
```

---

## 👤 Developer

**Muhammad Gathan Prayoga**  
NIS: 232417070055  
XII PPLG 1 — SMK Bakti Nusantara 666  
📍 Jl. Raya Percobaan No.65, Cileunyi, Kabupaten Bandung, Jawa Barat

---

## 📄 Lisensi

Project ini dibuat untuk keperluan **Ujian Kompetensi Kejuruan (UKK) 2025**.
