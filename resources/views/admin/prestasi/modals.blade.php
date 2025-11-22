{{-- Modal Tambah Prestasi --}}
<div class="modal fade" id="tambahPrestasiModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i>
                    Input Prestasi Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.prestasi.store') }}" method="POST">
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
                            <label class="form-label">Jenis Prestasi <span class="text-danger">*</span></label>
                            <select name="jenis_prestasi_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Prestasi --</option>
                                @foreach($jenisPrestasi as $jp)
                                    <option value="{{ $jp->id }}">{{ $jp->nama_prestasi }} ({{ $jp->poin }} poin)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Prestasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_prestasi" class="form-control" value="{{ date('Y-m-d') }}" required>
                            <div class="form-text">Tanggal ketika prestasi diraih</div>
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
                        <div class="col-12">
                            <label class="form-label">Deskripsi Prestasi <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan detail prestasi yang diraih..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal submit">
                        <i class="fas fa-save"></i> Simpan Prestasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Prestasi --}}
<div class="modal fade" id="editPrestasiModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header edit">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Prestasi Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
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
                            <label class="form-label">Jenis Prestasi <span class="text-danger">*</span></label>
                            <select name="jenis_prestasi_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Prestasi --</option>
                                @foreach($jenisPrestasi as $jp)
                                    <option value="{{ $jp->id }}">{{ $jp->nama_prestasi }} ({{ $jp->poin }} poin)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Prestasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_prestasi" class="form-control" required>
                            <div class="form-text">Tanggal ketika prestasi diraih</div>
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
                        <div class="col-12">
                            <label class="form-label">Deskripsi Prestasi <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal update">
                        <i class="fas fa-save"></i> Update Prestasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail Prestasi --}}
<div class="modal fade" id="detailPrestasiModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Prestasi
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

{{-- Modal Verifikasi --}}
<div class="modal fade" id="verifikasiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header verify">
                <h5 class="modal-title">
                    <i class="fas fa-check-double"></i>
                    Verifikasi Prestasi
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