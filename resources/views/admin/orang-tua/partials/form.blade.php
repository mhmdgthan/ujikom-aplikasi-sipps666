<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nama User (Orang Tua)</label>
        <select name="user_id" class="form-select" required>
            <option value="">-- Pilih Orang Tua --</option>
            @foreach($users->where('level', 'orang_tua') as $user)
                <option value="{{ $user->id }}">{{ $user->nama_lengkap ?? $user->username }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Nama Siswa</label>
        <select name="siswa_id" class="form-select" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}">{{ $siswa->user->nama_lengkap ?? '-' }} ({{ $siswa->nis }})</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Hubungan</label>
        <input type="text" name="hubungan" class="form-control" placeholder="Contoh: Ayah, Ibu, Wali" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Pekerjaan</label>
        <input type="text" name="pekerjaan" class="form-control" placeholder="Contoh: Pegawai Swasta, Petani">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Alamat</label>
        <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
    </div>
</div>
