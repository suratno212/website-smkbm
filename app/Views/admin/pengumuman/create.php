<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pengumuman</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/pengumuman/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul">Judul Pengumuman</label>
                                    <input type="text" name="judul" id="judul" class="form-control <?= session('errors.judul') ? 'is-invalid' : '' ?>" value="<?= old('judul') ?>" required>
                                    <?php if (session('errors.judul')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.judul') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis">Jenis Pengumuman</label>
                                    <select name="jenis" id="jenis" class="form-control <?= session('errors.jenis') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="Umum" <?= old('jenis') == 'Umum' ? 'selected' : '' ?>>Umum</option>
                                        <option value="Jadwal Ujian" <?= old('jenis') == 'Jadwal Ujian' ? 'selected' : '' ?>>Jadwal Ujian</option>
                                        <option value="Kegiatan" <?= old('jenis') == 'Kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
                                        <option value="Lainnya" <?= old('jenis') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                    </select>
                                    <?php if (session('errors.jenis')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.jenis') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="isi">Isi Pengumuman</label>
                            <textarea name="isi" id="isi" rows="5" class="form-control <?= session('errors.isi') ? 'is-invalid' : '' ?>" placeholder="Isi pengumuman (opsional)"><?= old('isi') ?></textarea>
                            <?php if (session('errors.isi')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.isi') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file">File Lampiran (PDF/Gambar)</label>
                                    <input type="file" name="file" id="file" class="form-control <?= session('errors.file') ? 'is-invalid' : '' ?>" accept=".pdf,.jpg,.jpeg,.png,.gif">
                                    <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG, GIF. Maksimal 5MB.</small>
                                    <?php if (session('errors.file')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.file') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control <?= session('errors.status') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif" <?= old('status') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?= old('status') == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                                    </select>
                                    <?php if (session('errors.status')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.status') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('admin/pengumuman') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 