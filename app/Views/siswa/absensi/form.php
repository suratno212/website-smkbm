<?= $this->extend('layout/siswa') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Absensi Hari Ini</h4>
                            <p class="header-subtitle">Silakan isi absensi kehadiran Anda hari ini</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success"> <?= session('success') ?> </div>
                    <?php endif; ?>
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger"> <?= session('error') ?> </div>
                    <?php endif; ?>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger text-center my-5"><?= $error_message ?></div>
                        <?php return; ?>
                    <?php endif; ?>
                    <?php if (isset($absensi_hari_ini) && $absensi_hari_ini): ?>
                        <div class="alert alert-info">
                            Anda sudah mengisi absensi hari ini.<br>
                            <b>Status:</b> <?= $this->getStatusTextHelper($absensi_hari_ini['status']) ?><br>
                            <b>Keterangan:</b> <?= isset($absensi_hari_ini['keterangan']) ? ($absensi_hari_ini['keterangan'] ?: '-') : '-' ?>
                        </div>
                    <?php else: ?>
                        <form action="<?= base_url('siswa/absensi/simpan') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Status Kehadiran</label>
                                <select name="status" class="form-control" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="H">Hadir</option>
                                    <option value="S">Sakit</option>
                                    <option value="I">Izin</option>
                                    <option value="A">Alpha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan (opsional)</label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Keterangan tambahan">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Absensi
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-end">
            <a href="<?= base_url('siswa/absensi/riwayat') ?>" class="btn btn-outline-info">
                <i class="fas fa-history"></i> Lihat Riwayat Absensi
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>