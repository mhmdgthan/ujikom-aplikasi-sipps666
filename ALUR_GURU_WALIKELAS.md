# ALUR INPUT GURU & WALI KELAS

## **Langkah 1: Input User (Level Guru)**

### Admin masuk ke menu **Users**
1. Klik "Tambah User"
2. Isi form:
   - **Username**: suhendar
   - **Password**: password123
   - **Nama Lengkap**: Suhendar, S.Pd
   - **Level**: Guru
3. Simpan

**Hasil**: User dengan level 'guru' berhasil dibuat

---

## **Langkah 2: Input Data Guru**

### Admin masuk ke menu **Guru**
1. Klik "Tambah Guru"
2. Isi form:
   - **User**: Pilih "Suhendar, S.Pd" (dari dropdown user yang level guru)
   - **NIP**: 198501012010011001
   - **Nama Guru**: Suhendar, S.Pd
   - **Jenis Kelamin**: Laki-laki
   - **Bidang Studi**: Matematika
   - **Email**: suhendar@smk.sch.id
   - **No. Telepon**: 081234567890
3. Simpan

**Hasil**: Profil guru lengkap terhubung ke user

---

## **Langkah 3: Input Wali Kelas (Opsional)**

### Admin masuk ke menu **Wali Kelas**
1. Klik "Tambah Wali Kelas"
2. Isi form:
   - **Pilih Guru**: Suhendar, S.Pd (198501012010011001) - Matematika
   - **Kelas**: XII RPL 1
   - **Tahun Ajaran**: 2024/2025 - Semester Ganjil
   - **Tanggal Mulai**: 2024-07-15
   - **Tanggal Selesai**: (kosong = masih aktif)
   - **Catatan**: Wali kelas periode 2024/2025
3. Simpan

**Hasil**: Suhendar sekarang menjadi guru sekaligus wali kelas XII RPL 1

---

## **Hasil Akhir Login Suhendar:**

### **Jika Hanya Guru:**
- **Sidebar**: "Guru"
- **Akses**: Dashboard guru, input pelanggaran, data diri
- **Route**: `/guru/*`

### **Jika Guru + Wali Kelas:**
- **Sidebar**: "Guru & Wali Kelas"
- **Akses**: Semua akses guru + data siswa kelas, monitoring kelas
- **Route**: `/wali-kelas/*` (otomatis redirect)

---

## **Struktur Database:**

```
users (id=1, username=suhendar, level=guru)
  ↓
guru (user_id=1, nama_guru=Suhendar, nip=198501012010011001)
  ↓ (opsional)
wali_kelas (guru_id=1, kelas_id=5, tahun_ajaran_id=1)
```

---

## **Cara Kerja Sistem:**

1. **Login** dengan username/password
2. **Sistem cek** level user
3. **Jika guru**: Cek apakah ada di tabel `wali_kelas`
4. **Jika ada**: Tampilkan "Guru & Wali Kelas" + akses wali kelas
5. **Jika tidak**: Tampilkan "Guru" saja

---

## **Catatan Penting:**

- ✅ **User harus dibuat dulu** sebelum input guru
- ✅ **Guru harus ada** sebelum bisa jadi wali kelas  
- ✅ **Satu guru bisa jadi wali kelas** di beberapa periode berbeda
- ✅ **Sistem otomatis detect** role berdasarkan assignment
- ✅ **Tanggal selesai kosong** = masih aktif sebagai wali kelas