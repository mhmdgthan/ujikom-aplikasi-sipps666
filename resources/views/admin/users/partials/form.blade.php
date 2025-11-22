@php
    // [REVISI] Membuat ID unik agar tidak konflik antara modal 'tambah' dan 'edit'
    $formId = $formId ?? \Illuminate\Support\Str::random(5);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Level</label>
        <select name="level" class="form-select" required>
            <option value="">-- Pilih Level --</option>
             <option value="admin">Administrator</option>
            <option value="kepala_sekolah">Kepala Sekolah</option>
            <option value="kesiswaan">Kesiswaan</option>
            <option value="bk">BK</option>
            <option value="guru">Guru</option>
            <option value="wali_kelas">Wali Kelas</option>
            <option value="orang_tua">Orang Tua</option>
            <option value="siswa">Siswa</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Isi untuk ganti/set password">
        <small class="text-muted">Kosongkan jika tidak ingin mengubah password (saat edit).</small>
    </div>
    <div class="col-md-6 d-flex align-items-center mt-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="can_verify" value="1" id="canVerifyCheck_{{ $formId }}">
            <label class="form-check-label" for="canVerifyCheck_{{ $formId }}">Dapat Memverifikasi</label>
        </div>
    </div>
</div>