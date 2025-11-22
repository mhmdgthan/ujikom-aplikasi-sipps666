<div class="row g-3">
    <div class="col-md-12">
        <div class="alert alert-info" style="background: #e6fffa; border: 1px solid #81e6d9; color: #234e52; border-radius: 8px; padding: 12px; margin-bottom: 16px;">
            <i class="fas fa-info-circle"></i>
            <strong>Info:</strong> Kode tahun akan dibuat otomatis berdasarkan tahun ajaran dan semester
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
        <input type="text" name="tahun_ajaran" class="form-control" placeholder="2025/2026" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Semester</label>
        <select name="semester" class="form-select" required>
            <option value="">-- Pilih Semester --</option>
            <option value="Ganjil">Ganjil</option>
            <option value="Genap">Genap</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Status Aktif</label>
        <div class="form-check form-switch mt-2">
            <input type="checkbox" name="status_aktif" class="form-check-input" value="1">
            <label class="form-check-label">Aktif</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control" required>
    </div>
</div>
