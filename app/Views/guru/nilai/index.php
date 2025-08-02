<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>

<style>
    /* Custom Modern UI */
    .gradient-header {
        background: linear-gradient(90deg, #0d47a1 60%, #1976d2 100%);
        color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 24px rgba(13, 71, 161, 0.08);
        position: relative;
        overflow: hidden;
    }
    .gradient-header .header-icon {
        font-size: 3.5rem;
        opacity: 0.15;
        position: absolute;
        right: 2rem;
        bottom: 0.5rem;
    }
    .modern-card {
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .modern-card:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 6px 24px rgba(25, 118, 210, 0.13);
    }
    .modern-btn {
        border-radius: 2rem;
        font-weight: 600;
        transition: background 0.2s, transform 0.15s;
    }
    .modern-btn:hover {
        transform: scale(1.04);
        filter: brightness(0.95);
    }
    .kelas-card {
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: box-shadow 0.15s, transform 0.15s;
        background: #f8fafc;
    }
    .kelas-card:hover {
        box-shadow: 0 6px 24px rgba(25, 118, 210, 0.13);
        transform: translateY(-2px) scale(1.02);
    }
    .kelas-badge {
        background: #1976d2;
        color: #fff;
        border-radius: 1rem;
        font-size: 0.85rem;
        padding: 0.2rem 0.8rem;
        margin-left: 0.5rem;
    }
</style>

<div class="container-fluid">
    <!-- Gradient Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="gradient-header p-4 mb-2 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">
                            <i class="fas fa-chart-line me-2"></i>Input Nilai
                        </h2>
                        <div class="fs-5 text-light">SIAKAD SMK Bhakti Mulya BNS</div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-primary fs-6 shadow-sm">Guru: <?= $guru['nama'] ?? 'N/A' ?></span>
                    </div>
                </div>
                <i class="fas fa-graduation-cap header-icon"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats Modern Card -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="modern-card bg-primary text-white p-3 text-center">
                <div class="mb-2"><i class="fas fa-users fa-2x"></i></div>
                <div class="fs-2 fw-bold"><?= count($kelasList) ?></div>
                <div>Total Kelas</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="modern-card bg-success text-white p-3 text-center">
                <div class="mb-2"><i class="fas fa-book fa-2x"></i></div>
                <div class="fs-2 fw-bold"><?= count($mapelList) ?></div>
                <div>Mata Pelajaran</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="modern-card bg-info text-white p-3 text-center">
                <div class="mb-2"><i class="fas fa-calendar-alt fa-2x"></i></div>
                <div class="fs-2 fw-bold">1</div>
                <div>Semester Aktif</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="modern-card bg-warning text-white p-3 text-center">
                <div class="mb-2"><i class="fas fa-graduation-cap fa-2x"></i></div>
                <div class="fs-2 fw-bold">2024/2025</div>
                <div>Tahun Ajaran</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card p-4 mb-4">
                <h4 class="mb-3 fw-bold"><i class="fas fa-list me-2"></i>Pilih Kelas dan Mata Pelajaran</h4>
                <?php if (empty($kelasList)) : ?>
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h5 class="text-muted">Tidak Ada Kelas</h5>
                        <p class="text-muted">Anda belum ditugaskan sebagai wali kelas atau guru mata pelajaran.</p>
                        <a href="<?= base_url('guru/dashboard') ?>" class="btn btn-primary modern-btn">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                <?php else : ?>
                    <form action="<?= base_url('guru/nilai/input') ?>" method="GET" id="nilaiForm">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="kelas_id" class="form-label fw-bold">
                                    <i class="fas fa-users me-2"></i>Pilih Kelas
                                </label>
                                <select class="form-select form-select-lg" id="kelas_id" name="kelas_id" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($kelasList as $kelas) : ?>
                                        <option value="<?= $kelas['kd_kelas'] ?>">
                                            <?= $kelas['nama_kelas'] ?> - <?= $kelas['nama_jurusan'] ?? '' ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="mapel_id" class="form-label fw-bold">
                                    <i class="fas fa-book me-2"></i>Mata Pelajaran
                                </label>
                                <select class="form-select form-select-lg" id="mapel_id" name="mapel_id" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php foreach ($mapelList as $mapel) : ?>
                                        <option value="<?= $mapel['id'] ?>"><?= $mapel['nama_mapel'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="semester" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2"></i>Semester
                                </label>
                                <select class="form-select form-select-lg" id="semester" name="semester" required>
                                    <option value="Ganjil">Semester Ganjil</option>
                                    <option value="Genap">Semester Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary btn-lg modern-btn">
                                    <i class="fas fa-edit me-2"></i>Input Nilai
                                </button>
                                <button type="button" class="btn btn-info btn-lg modern-btn" onclick="showRekap()">
                                    <i class="fas fa-chart-bar me-2"></i>Lihat Rekap
                                </button>
                                <button type="button" class="btn btn-success btn-lg modern-btn" onclick="showCetak()">
                                    <i class="fas fa-print me-2"></i>Cetak Nilai
                                </button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kelas yang Anda Kelola -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-4">
                <h4 class="mb-3 fw-bold"><i class="fas fa-history me-2"></i>Kelas yang Anda Kelola</h4>
                <?php if (!empty($kelasList)) : ?>
                    <div class="row g-3">
                        <?php foreach ($kelasList as $kelas) : ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="kelas-card p-3 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary rounded-circle p-3 me-3">
                                            <i class="fas fa-users text-white fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold"><?= $kelas['nama_kelas'] ?>
                                                <span class="kelas-badge">Jurusan: <?= $kelas['nama_jurusan'] ?></span>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="<?= base_url("guru/nilai/rekap?kelas_id={$kelas['kd_kelas']}") ?>" class="btn btn-outline-primary modern-btn btn-sm">
                                            <i class="fas fa-chart-bar me-1"></i>Rekap Nilai
                                        </a>
                                        <a href="<?= base_url("guru/nilai/input?kelas_id={$kelas['kd_kelas']}") ?>" class="btn btn-outline-success modern-btn btn-sm">
                                            <i class="fas fa-edit me-1"></i>Input Nilai
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="text-center py-4 text-muted">Belum ada kelas yang Anda kelola.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function showRekap() {
    const kelasId = document.getElementById('kelas_id').value;
    const semester = document.getElementById('semester').value;
    
    if (!kelasId) {
        alert('Pilih kelas terlebih dahulu!');
        return;
    }
    
    window.location.href = `<?= base_url('guru/nilai/rekap') ?>?kelas_id=${kelasId}&semester=${semester}`;
}

function showCetak() {
    const kelasId = document.getElementById('kelas_id').value;
    const semester = document.getElementById('semester').value;
    
    if (!kelasId) {
        alert('Pilih kelas terlebih dahulu!');
        return;
    }
    
    window.open(`<?= base_url('guru/nilai/cetak') ?>?kelas_id=${kelasId}&semester=${semester}`, '_blank');
}

// Form validation
document.getElementById('nilaiForm').addEventListener('submit', function(e) {
    const kelasId = document.getElementById('kelas_id').value;
    const mapelId = document.getElementById('mapel_id').value;
    
    if (!kelasId || !mapelId) {
        e.preventDefault();
        alert('Pilih kelas dan mata pelajaran terlebih dahulu!');
        return false;
    }
});
</script>

<?= $this->endSection() ?> 