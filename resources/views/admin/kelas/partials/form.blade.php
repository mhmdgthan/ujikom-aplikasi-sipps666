<div class="mb-3">
    <label for="nama_kelas" class="form-label fw-semibold">Nama Kelas</label>
    <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" 
        value="{{ old('nama_kelas', isset($item) ? $item->nama_kelas : '') }}" 
        placeholder="Contoh: XII RPL 1" required>
</div>

<div class="mb-3">
    <label for="jurusan" class="form-label fw-semibold">Jurusan</label>
    <input type="text" name="jurusan" class="form-control" id="jurusan"
        value="{{ old('jurusan', isset($item) ? $item->jurusan : '') }}" 
        placeholder="Contoh: Rekayasa Perangkat Lunak" required>
</div>

<div class="mb-3">
    <label for="kapasitas" class="form-label fw-semibold">Kapasitas</label>
    <input type="number" name="kapasitas" class="form-control" id="kapasitas"
        value="{{ old('kapasitas', isset($item) ? $item->kapasitas : '') }}" 
        placeholder="Contoh: 30" min="1" required>
</div>
