{{-- Modal Tambah Pelanggaran --}}
<div class="modal fade" id="tambahPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Input Pelanggaran Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? '-' }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select name="jenis_pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Pelanggaran --</option>
                                @foreach($jenisPelanggaran as $jp)
                                    <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">
                                        {{ $jp->nama_pelanggaran }} ({{ $jp->kategoriPelanggaran->nama_kategori ?? 'Tidak diketahui' }} - {{ $jp->poin }} poin)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pelanggaran <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Guru Pencatat <span class="text-danger">*</span></label>
                            <select name="guru_pencatat" class="form-select" required>
                                <option value="">-- Pilih Guru Pencatat --</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Guru Verifikator</label>
                            <select name="guru_verifikator" class="form-select">
                                <option value="">-- Pilih Guru Verifikator --</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Pelanggaran <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan detail pelanggaran yang terjadi..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bukti Foto (Opsional)</label>
                            <input type="file" name="bukti_foto" class="form-control" accept="image/*" onchange="previewFile(this)">
                            <div class="form-text">Format: JPG, PNG, JPEG. Maksimal 2MB</div>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal submit">
                        <i class="fas fa-save"></i> Simpan Pelanggaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Pelanggaran --}}
<div class="modal fade" id="editPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Pelanggaran Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? '-' }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select name="jenis_pelanggaran_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Pelanggaran --</option>
                                @foreach($jenisPelanggaran as $jp)
                                    <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">
                                        {{ $jp->nama_pelanggaran }} ({{ $jp->kategoriPelanggaran->nama_kategori ?? 'Tidak diketahui' }} - {{ $jp->poin }} poin)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pelanggaran <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Guru Pencatat <span class="text-danger">*</span></label>
                            <select name="guru_pencatat" class="form-select" required>
                                <option value="">-- Pilih Guru Pencatat --</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Guru Verifikator</label>
                            <select name="guru_verifikator" class="form-select">
                                <option value="">-- Pilih Guru Verifikator --</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Pelanggaran <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan detail pelanggaran yang terjadi..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bukti Foto (Opsional)</label>
                            <input type="file" name="bukti_foto" class="form-control" accept="image/*" onchange="previewEditFile(this)">
                            <div class="form-text">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto</div>
                            <div id="currentImage" class="mt-2"></div>
                            <div id="editImagePreview" class="mt-2" style="display: none;">
                                <img id="editPreview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal update">
                        <i class="fas fa-save"></i> Update Pelanggaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail Pelanggaran --}}
<div class="modal fade" id="detailPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="detailContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Preview Foto --}}
<div class="modal fade" id="previewFotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image"></i>
                    Bukti Foto Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Bukti Foto" class="img-fluid rounded" style="max-height: 500px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <a id="downloadLink" href="" download class="btn-modal submit">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Verifikasi --}}
<div class="modal fade" id="verifikasiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header verify">
                <h5 class="modal-title">
                    <i class="fas fa-check-double"></i>
                    Verifikasi Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="verifikasiForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select name="status_verifikasi" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Verifikasi</label>
                        <textarea name="catatan_verifikasi" class="form-control" rows="3" placeholder="Berikan catatan untuk keputusan verifikasi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal approve">
                        <i class="fas fa-check"></i> Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>