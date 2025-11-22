{{-- Modal Tambah Pelanggaran untuk GURU --}}
<div class="modal fade" id="tambahPelanggaranModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="padding: 20px 24px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none;">
                <h5 class="modal-title" style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-plus-circle"></i>
                    Input Pelanggaran Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('guru.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding: 24px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Nama Siswa <span style="color: #e53e3e;">*</span></label>
                            <select name="siswa_id" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? '-' }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Jenis Pelanggaran <span style="color: #e53e3e;">*</span></label>
                            <select name="jenis_pelanggaran_id" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Jenis Pelanggaran --</option>
                                @foreach($jenisPelanggaran as $jp)
                                    <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">
                                        {{ $jp->nama_pelanggaran }} ({{ ucfirst($jp->kategori) }} - {{ $jp->poin }} poin)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tanggal Pelanggaran <span style="color: #e53e3e;">*</span></label>
                            <input type="date" name="tanggal" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tahun Ajaran <span style="color: #e53e3e;">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Guru Pencatat <span style="color: #e53e3e;">*</span></label>
                            <select name="guru_pencatat" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Guru Pencatat --</option>
                                @if(isset($guru))
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Deskripsi Pelanggaran <span style="color: #e53e3e;">*</span></label>
                            <textarea name="keterangan" class="form-control" style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s; resize: vertical; min-height: 80px;" rows="3" placeholder="Jelaskan detail pelanggaran yang terjadi..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Bukti Foto (Opsional)</label>
                            <input type="file" name="bukti_foto" class="form-control" style="width: 100%; height: 40px; padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" accept="image/*" onchange="previewFile(this)">
                            <small style="color: #e53e3e; font-size: 12px; margin-top: 4px; display: block;">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn-modal cancel" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; background: #f7fafc; color: #4a5568;" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal submit" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
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
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="padding: 20px 24px; background: linear-gradient(135deg, #f6ad55, #ed8936); color: white; border: none;">
                <h5 class="modal-title" style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-edit"></i>
                    Edit Pelanggaran Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 24px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Nama Siswa <span style="color: #e53e3e;">*</span></label>
                            <select name="siswa_id" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->user->nama_lengkap ?? '-' }} - {{ $s->kelas->nama_kelas ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Jenis Pelanggaran <span style="color: #e53e3e;">*</span></label>
                            <select name="jenis_pelanggaran_id" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Jenis Pelanggaran --</option>
                                @foreach($jenisPelanggaran as $jp)
                                    <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">
                                        {{ $jp->nama_pelanggaran }} ({{ ucfirst($jp->kategori ?? 'Ringan') }} - {{ $jp->poin }} poin)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tanggal Pelanggaran <span style="color: #e53e3e;">*</span></label>
                            <input type="date" name="tanggal" class="form-control" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Tahun Ajaran <span style="color: #e53e3e;">*</span></label>
                            <select name="tahun_ajaran_id" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->tahun_ajaran }} - {{ ucfirst($ta->semester) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Guru Pencatat <span style="color: #e53e3e;">*</span></label>
                            <select name="guru_pencatat" class="form-select" style="width: 100%; height: 40px; padding: 0 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" required>
                                <option value="">-- Pilih Guru Pencatat --</option>
                                @if(isset($guru))
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Deskripsi Pelanggaran <span style="color: #e53e3e;">*</span></label>
                            <textarea name="keterangan" class="form-control" style="width: 100%; padding: 12px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s; resize: vertical; min-height: 80px;" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size: 13px; font-weight: 600; color: #4a5568; margin-bottom: 8px; display: block;">Bukti Foto (Opsional)</label>
                            <input type="file" name="bukti_foto" class="form-control" style="width: 100%; height: 40px; padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; transition: all 0.2s;" accept="image/*" onchange="previewEditFile(this)">
                            <small style="color: #e53e3e; font-size: 12px; margin-top: 4px; display: block;">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto</small>
                            <div id="currentImage" class="mt-2"></div>
                            <div id="editImagePreview" class="mt-2" style="display: none;">
                                <img id="editPreview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn-modal cancel" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; background: #f7fafc; color: #4a5568;" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal update" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; background: linear-gradient(135deg, #f6ad55, #ed8936); color: white;">
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
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="padding: 20px 24px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none;">
                <h5 class="modal-title" style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-info-circle"></i>
                    Detail Pelanggaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 24px;">
                <div class="row g-3" id="detailContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
                <button type="button" class="btn-modal cancel" style="height: 40px; padding: 0 20px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; background: #f7fafc; color: #4a5568;" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.detail-group {
    margin-bottom: 16px;
}

.detail-label {
    font-size: 11px;
    font-weight: 600;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.detail-value {
    font-size: 14px;
    color: #2d3748;
    font-weight: 500;
}

.bukti-foto {
    width: 100%;
    max-width: 400px;
    height: auto;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    cursor: pointer;
    transition: all 0.2s;
}

.bukti-foto:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.form-select:focus, .form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-modal.cancel:hover {
    background: #e2e8f0;
}

.btn-modal.submit:hover, .btn-modal.update:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Mobile responsive modal */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 10px;
        max-height: calc(100vh - 20px);
    }
    
    .modal-content {
        max-height: calc(100vh - 20px);
        display: flex;
        flex-direction: column;
    }
    
    .modal-body {
        flex: 1;
        overflow-y: auto;
        max-height: calc(100vh - 200px);
        padding: 16px !important;
    }
    
    .modal-header {
        padding: 16px !important;
        flex-shrink: 0;
    }
    
    .modal-footer {
        padding: 12px 16px !important;
        flex-shrink: 0;
        position: sticky;
        bottom: 0;
        background: white;
        border-top: 1px solid #f1f5f9;
    }
    
    .col-md-6 {
        margin-bottom: 16px;
    }
    
    .form-label {
        margin-bottom: 6px !important;
    }
    
    .btn-modal {
        width: 100%;
        margin-bottom: 8px;
    }
    
    .btn-modal:last-child {
        margin-bottom: 0;
    }
}
</style>

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
                <a id="downloadLink" href="" download class="btn btn-success">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function previewFile(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

function previewEditFile(input) {
    const preview = document.getElementById('editPreview');
    const previewContainer = document.getElementById('editImagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

function previewFoto(imageSrc) {
    const previewImage = document.getElementById('previewImage');
    const downloadLink = document.getElementById('downloadLink');
    
    previewImage.src = imageSrc;
    downloadLink.href = imageSrc;
    
    const modal = new bootstrap.Modal(document.getElementById('previewFotoModal'));
    modal.show();
}
</script>