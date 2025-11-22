<div class="row g-3">
 <div class="col-md-6">
    <label class="form-label">Pilih Guru Sebagai Wali Kelas <span class="text-danger">*</span></label>
    <select name="guru_id" class="form-select" required>
        <option value="">-- Pilih Guru --</option>
        @foreach($guru as $g)
            @if($g->user_id) {{-- Pastikan guru punya user_id --}}
            <option value="{{ $g->user_id }}" 
                {{ old('guru_id') == $g->user_id ? 'selected' : '' }}
                data-nip="{{ $g->nip }}"
                data-bidang="{{ $g->bidang_studi }}"
            >
                {{ $g->nama_guru }} ({{ $g->nip }}) - {{ $g->bidang_studi }}
            </option>
            @endif
        @endforeach
    </select>
    <small class="text-muted">Hanya guru yang sudah memiliki akun user yang bisa dipilih</small>
</div>
    <div class="col-md-6">
        <label class="form-label">Kelas <span class="text-danger">*</span></label>
        <select name="kelas_id" class="form-select" required>
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12">
        <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
        <select name="tahun_ajaran_id" class="form-select" required>
            <option value="">-- Pilih Tahun Ajaran --</option>
            @foreach($tahunAjaran as $ta)
                <option value="{{ $ta->id }}" {{ $ta->status_aktif ? 'selected' : '' }}>
                    {{ $ta->tahun_ajaran }} - Semester {{ ucfirst($ta->semester) }}
                    @if($ta->status_aktif) <span class="badge bg-success ms-1">Aktif</span> @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_mulai" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control">
        <small class="text-muted">Kosongkan jika masih aktif</small>
    </div>

    <div class="col-12">
        <label class="form-label">Catatan</label>
        <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
    </div>
</div>