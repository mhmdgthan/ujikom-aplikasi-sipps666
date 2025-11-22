{{-- resources/views/admin/siswa/partials/form.blade.php --}}
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">User Siswa</label>
        <select name="user_id" class="form-select" required>
            <option value="">-- Pilih User Siswa --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_lengkap }} ({{ $user->username }})</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">NIS</label>
        <input type="text" name="nis" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">NISN</label>
        <input type="text" name="nisn" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nama Siswa</label>
        <input type="text" name="nama_lengkap" class="form-control" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Kelas</label>
        <select name="kelas_id" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Agama</label>
        <input type="text" name="agama" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">No. Telepon</label>
        <input type="text" name="no_telepon" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Foto (Opsional)</label>
        <input type="file" name="foto" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" rows="2" required></textarea>
    </div>
</div>
