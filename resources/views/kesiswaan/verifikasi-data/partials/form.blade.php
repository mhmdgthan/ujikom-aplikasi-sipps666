<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Tabel Terkait <span class="text-danger">*</span></label>
        <input type="text" name="tabel_terkait" class="form-control" placeholder="Nama tabel" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">ID Terkait <span class="text-danger">*</span></label>
        <input type="number" name="id_terkait" class="form-control" placeholder="Masukkan ID terkait" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">User Pencatat <span class="text-danger">*</span></label>
        <select name="user_pencatat" class="form-select" required>
            <option value="">-- Pilih Pencatat --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">User Verifikator</label>
        <select name="user_verifikator" class="form-select">
            <option value="">-- Pilih Verifikator --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            <option value="">-- Pilih Status --</option>
            <option value="Pending">Pending</option>
            <option value="Diterima">Diterima</option>
            <option value="Ditolak">Ditolak</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Tanggal Pencatatan <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_pencatatan" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Tanggal Verifikasi</label>
        <input type="date" name="tanggal_verifikasi" class="form-control">
    </div>
    <div class="col-12">
        <label class="form-label">Catatan Verifikasi</label>
        <textarea name="catatan_verifikasi" class="form-control" rows="3" placeholder="Tuliskan catatan (opsional)"></textarea>
    </div>
</div>
