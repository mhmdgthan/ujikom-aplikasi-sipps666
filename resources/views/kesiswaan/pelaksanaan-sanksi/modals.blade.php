{{-- Modal Tambah Pelaksanaan --}}
<div class="modal fade" id="tambahPelaksanaanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Pelaksanaan Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kesiswaan.pelaksanaan-sanksi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Sanksi <span class="text-danger">*</span></label>
                            <select name="sanksi_id" class="form-select" required>
                                <option value="">-- Pilih Sanksi --</option>
                                @forelse($sanksi as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->pelanggaran->siswa->user->nama_lengkap ?? 'Siswa Tidak Ditemukan' }} - 
                                    {{ $s->jenis_sanksi }} 
                                    @if($s->tanggal_mulai)
                                    ({{ $s->tanggal_mulai->format('d/m/Y') }})
                                    @endif
                                </option>
                                @empty
                                <option value="" disabled>Tidak ada sanksi tersedia</option>
                                @endforelse
                            </select>
                            @if($sanksi->count() == 0)
                            <div class="alert alert-warning mt-2">
                                <small>
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Tidak ada sanksi yang tersedia!</strong><br>
                                    Kemungkinan penyebab:
                                    <ul class="mb-0 mt-1">
                                        <li>Belum ada sanksi dengan status "disetujui"</li>
                                        <li>Semua sanksi sudah dilaksanakan</li>
                                        <li>Belum ada data pelanggaran yang diproses</li>
                                    </ul>
                                </small>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control" 
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan Pelaksanaan</label>
                            <textarea name="catatan" class="form-control" rows="3" 
                                      placeholder="Tambahkan catatan mengenai pelaksanaan sanksi..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bukti Pelaksanaan (Opsional)</label>
                            <input type="file" name="bukti_pelaksanaan" class="form-control" accept="image/*">
                            <div class="text-danger">Format: JPG, PNG, JPEG. Maksimal 2MB</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal submit" {{ $sanksi->count() == 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i> Simpan Pelaksanaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Pelaksanaan --}}
<div class="modal fade" id="editPelaksanaanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Pelaksanaan Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Sanksi <span class="text-danger">*</span></label>
                            <select id="edit_sanksi_id" name="sanksi_id" class="form-select" required>
                                <option value="">-- Pilih Sanksi --</option>
                                @foreach($sanksi as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->pelanggaran->siswa->user->nama_lengkap ?? 'Siswa Tidak Ditemukan' }} - 
                                    {{ $s->jenis_sanksi }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" id="edit_tanggal_pelaksanaan" name="tanggal_pelaksanaan" 
                                   class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="edit_status" name="status" class="form-select" required>
                                <option value="pending">Pending</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan Pelaksanaan</label>
                            <textarea id="edit_catatan" name="catatan" class="form-control" rows="3" 
                                      placeholder="Tambahkan catatan mengenai pelaksanaan sanksi..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bukti Pelaksanaan (Opsional)</label>
                            <input type="file" name="bukti_pelaksanaan" class="form-control" accept="image/*">
                            <div class="text-danger">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto</div>
                            
                            {{-- Preview bukti saat ini --}}
                            <div id="currentBuktiPreview" class="mt-2" style="display: none;">
                                <img id="currentBuktiImage" src="" alt="Bukti Saat Ini" 
                                     class="clickable-photo" onclick="previewFoto(this.src)" title="Klik untuk memperbesar"
                                     style="max-width: 200px; border-radius: 8px; border: 2px solid #e2e8f0; cursor: pointer;">
                                <br>
                                <small>Bukti saat ini - Klik untuk memperbesar</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal update">
                        <i class="fas fa-save"></i> Update Pelaksanaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail Pelaksanaan --}}
<div class="modal fade" id="detailPelaksanaanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4299e1, #3182ce);">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Pelaksanaan Sanksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Nama Siswa</div>
                            <div class="detail-value" id="detail_siswa">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">NIS</div>
                            <div class="detail-value" id="detail_nis">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Jenis Sanksi</div>
                            <div class="detail-value" id="detail_jenis_sanksi">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="detail_status">-</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-group">
                            <div class="detail-label">Deskripsi Sanksi</div>
                            <div class="detail-value" id="detail_deskripsi">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Pelaksanaan</div>
                            <div class="detail-value" id="detail_tanggal_pelaksanaan">-</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-group">
                            <div class="detail-label">Catatan</div>
                            <div class="detail-value" id="detail_catatan">-</div>
                        </div>
                    </div>
                    <div class="col-12" id="detail_bukti_container" style="display: none;">
                        <div class="detail-group">
                            <div class="detail-label">Bukti Pelaksanaan</div>
                            <img id="detail_bukti_img" class="bukti-foto clickable-photo" alt="Bukti Pelaksanaan" onclick="previewFoto(this.src)" title="Klik untuk memperbesar">
                            <div class="mt-2"><small class="text-muted">Klik foto untuk memperbesar</small></div>
                        </div>
                    </div>
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