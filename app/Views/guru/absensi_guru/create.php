<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Input Absensi Guru 📝</h1>
                        <p class="welcome-subtitle">Isi kehadiran Anda hari ini</p>
                        <div class="welcome-meta">
                            <span class="meta-item">
                                <i class="fas fa-user"></i>
                                <?= $guru['nama'] ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-calendar-day"></i>
                                <?= date('l, d F Y') ?>
                            </span>
                        </div>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Form Absensi Guru</h4>
                            <p class="header-subtitle">Isi data kehadiran Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success"><?= session('success') ?></div>
                    <?php endif; ?>
                    
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger"><?= session('error') ?></div>
                    <?php endif; ?>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
                            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

                    <?php if ($absen_today): ?>
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle"></i> Absensi Hari Ini</h5>
                            <p>Anda sudah mengisi absensi untuk hari ini (<?= date('d F Y') ?>).</p>
                            <p><strong>Status:</strong> <?= $absen_today['status'] ?></p>
                            <p><strong>Jam Masuk:</strong> <?= $absen_today['jam_masuk'] ?></p>
                            <?php if ($absen_today['jam_pulang']): ?>
                                <p><strong>Jam Pulang:</strong> <?= $absen_today['jam_pulang'] ?></p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
    <form action="<?= base_url('guru/absensi-guru/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                                    </div>
        </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jam_masuk" class="form-label">Jam Masuk <span class="text-danger">*</span></label>
            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="<?= old('jam_masuk') ?>" required>
        </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
            <label for="jam_pulang" class="form-label">Jam Pulang</label>
            <input type="time" name="jam_pulang" id="jam_pulang" class="form-control" value="<?= old('jam_pulang') ?>">
                                        <small class="form-text text-muted">Kosongkan jika belum pulang</small>
                                    </div>
        </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Status <span class="text-danger">*</span></label><br>
                                        <div class="status-options">
            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status_hadir" value="Hadir" <?= old('status')=='Hadir'?'checked':'' ?> required>
                <label class="form-check-label" for="status_hadir">Hadir</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_izin" value="Izin" <?= old('status')=='Izin'?'checked':'' ?>>
                <label class="form-check-label" for="status_izin">Izin</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_sakit" value="Sakit" <?= old('status')=='Sakit'?'checked':'' ?>>
                <label class="form-check-label" for="status_sakit">Sakit</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_alpha" value="Alpha" <?= old('status')=='Alpha'?'checked':'' ?>>
                <label class="form-check-label" for="status_alpha">Alpha</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_dinas" value="Dinas Luar" <?= old('status')=='Dinas Luar'?'checked':'' ?>>
                <label class="form-check-label" for="status_dinas">Dinas Luar</label>
            </div>
        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
            <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tambahkan keterangan jika diperlukan..."><?= old('keterangan') ?></textarea>
                            </div>

                            <div class="form-actions mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Absensi
                                </button>
                                <a href="<?= base_url('guru/absensi-guru') ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-options {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.form-check-inline {
    margin-right: 0;
}

.form-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

@media (max-width: 768px) {
    .status-options {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<?= $this->endSection() ?> 