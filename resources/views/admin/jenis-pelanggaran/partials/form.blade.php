<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label">Nama Pelanggaran <span class="text-danger">*</span></label>
        <input type="text" name="nama_pelanggaran" class="form-control" placeholder="Contoh: Terlambat masuk kelas" required>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Kategori Pelanggaran <span class="text-danger">*</span></label>
        <select name="kategori_pelanggaran_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoriPelanggaran as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }} ({{ $kategori->kategori_induk }})</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Poin <span class="text-danger">*</span></label>
        <input type="number" name="poin" class="form-control" placeholder="Contoh: 10" min="1" required>
    </div>
    
    <div class="col-md-12">
        <label class="form-label">Sanksi</label>
        <select name="sanksi" class="form-select">
            <option value="">-- Pilih Sanksi --</option>
            @foreach($jenisSanksi as $sanksi)
                <option value="{{ $sanksi->nama_sanksi }}">{{ $sanksi->nama_sanksi }} ({{ ucfirst($sanksi->kategori) }})</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-12">
        <label class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="3" placeholder="Deskripsi detail pelanggaran..."></textarea>
    </div>
</div>