<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-primary">
                                <i class="fas fa-chart-line me-2"></i>Kelola Nilai Siswa
                            </h4>
                            <p class="text-muted mb-0">Input, edit, dan kelola nilai siswa per mata pelajaran</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary fs-6">Guru: <?= $guru['nama'] ?? 'N/A' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Kelas</h6>
                            <h3 class="mb-0"><?= count($kelasList) ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Mata Pelajaran</h6>
                            <h3 class="mb-0"><?= count($mapelList) ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Semester Aktif</h6>
                            <h3 class="mb-0">1</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Tahun Ajaran</h6>
                            <h3 class="mb-0">2024/2025</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Pilih Kelas dan Mata Pelajaran
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($kelasList)) : ?>
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Kelas</h5>
                            <p class="text-muted">Anda belum ditugaskan sebagai wali kelas atau guru mata pelajaran.</p>
                            <a href="<?= base_url('guru/dashboard') ?>" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    <?php else : ?>
                        <form action="<?= base_url('guru/nilai/input') ?>" method="GET" id="nilaiForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kelas_id" class="form-label fw-bold">
                                            <i class="fas fa-users me-2"></i>Pilih Kelas
                                        </label>
                                        <select class="form-select form-select-lg" id="kelas_id" name="kelas_id" required>
                                            <option value="">-- Pilih Kelas --</option>
                                            <?php foreach ($kelasList as $kelas) : ?>
                                                <option value="<?= $kelas['id'] ?>">
                                                    <?= $kelas['nama_kelas'] ?> - <?= $kelas['nama_jurusan'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
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
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="semester" class="form-label fw-bold">
                                            <i class="fas fa-calendar me-2"></i>Semester
                                        </label>
                                        <select class="form-select form-select-lg" id="semester" name="semester" required>
                                            <option value="Ganjil">Semester Ganjil</option>
                                            <option value="Genap">Semester Genap</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg me-2">
                                        <i class="fas fa-edit me-2"></i>Input Nilai
                                    </button>
                                    <button type="button" class="btn btn-info btn-lg me-2" onclick="showRekap()">
                                        <i class="fas fa-chart-bar me-2"></i>Lihat Rekap
                                    </button>
                                    <button type="button" class="btn btn-success btn-lg" onclick="showCetak()">
                                        <i class="fas fa-print me-2"></i>Cetak Nilai
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Kelas yang Anda Kelola
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($kelasList)) : ?>
                        <div class="row">
                            <?php foreach ($kelasList as $kelas) : ?>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-primary rounded-circle p-3 me-3">
                                                    <i class="fas fa-users text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold"><?= $kelas['nama_kelas'] ?></h6>
                                                    <small class="text-muted"><?= $kelas['nama_jurusan'] ?></small>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <a href="<?= base_url("guru/nilai/rekap?kelas_id={$kelas['id']}") ?>" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-chart-bar me-2"></i>Lihat Rekap
                                                </a>
                                                <a href="<?= base_url("guru/nilai/cetak?kelas_id={$kelas['id']}") ?>" 
                                                   class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-print me-2"></i>Cetak Nilai
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle fa-2x text-info mb-3"></i>
                            <p class="text-muted">Belum ada kelas yang ditugaskan</p>
                        </div>
                    <?php endif; ?>
                </div>
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