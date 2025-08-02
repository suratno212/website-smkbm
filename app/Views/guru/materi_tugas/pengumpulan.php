<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas') ?>">E-Learning</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Review Tugas</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Review Pengumpulan Tugas</h1>
                        <p class="welcome-subtitle">Kelola dan nilai pengumpulan tugas siswa</p>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h5 class="card-title"><i class="fas fa-filter"></i> Filter Tugas</h5>
                </div>
                <div class="card-body-modern">
                    <form method="get" class="row g-3">
                        <div class="col-md-3">
                            <label for="kd_mapel" class="form-label">Mata Pelajaran</label>
                            <select name="kd_mapel" id="kd_mapel" class="form-select">
                                <option value="">Semua Mata Pelajaran</option>
                                <?php foreach ($mapel_list ?? [] as $mapel): ?>
                                    <option value="<?= $mapel['kd_mapel'] ?>" <?= $selected_mapel == $mapel['kd_mapel'] ? 'selected' : '' ?>>
                                        <?= $mapel['nama_mapel'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="kd_kelas" class="form-label">Kelas</label>
                            <select name="kd_kelas" id="kd_kelas" class="form-select">
                                <option value="">Semua Kelas</option>
                                <?php foreach ($kelas_list ?? [] as $kelas): ?>
                                    <option value="<?= $kelas['kd_kelas'] ?>" <?= $selected_kelas == $kelas['kd_kelas'] ? 'selected' : '' ?>>
                                        <?= $kelas['nama_kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="dikumpulkan" <?= $selected_status == 'dikumpulkan' ? 'selected' : '' ?>>Dikumpulkan</option>
                                <option value="belum_dikumpulkan" <?= $selected_status == 'belum_dikumpulkan' ? 'selected' : '' ?>>Belum dikumpulkan</option>
                                <option value="terlambat" <?= $selected_status == 'terlambat' ? 'selected' : '' ?>>Terlambat</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Filter
                                </button>
                                <a href="<?= base_url('guru/materitugas/pengumpulan') ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-primary">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $total_tugas ?? 0 ?></h3>
                    <p class="stat-label">Total Tugas</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $dikumpulkan ?? 0 ?></h3>
                    <p class="stat-label">Dikumpulkan</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $belum_dikumpulkan ?? 0 ?></h3>
                    <p class="stat-label">Belum Dikumpulkan</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-danger">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $terlambat ?? 0 ?></h3>
                    <p class="stat-label">Terlambat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Tugas -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-list"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Daftar Tugas</h4>
                            <p class="header-subtitle">Review pengumpulan tugas siswa</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($tugas_list)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-tasks"></i></div>
                            <h5 class="empty-title">Belum ada tugas</h5>
                            <p class="empty-subtitle">Buat tugas terlebih dahulu untuk melihat pengumpulan</p>
                            <a href="<?= base_url('guru/materitugas/uploadTugas') ?>" class="btn btn-primary">Buat Tugas</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul Tugas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tugas_list as $tugas): ?>
                                        <tr>
                                            <td>
                                                <div class="task-info">
                                                    <h6 class="task-title"><?= $tugas['deskripsi'] ?></h6>
                                                    <small class="text-muted">Dibuat: <?= date('d/m/Y H:i', strtotime($tugas['created_at'])) ?></small>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary"><?= $tugas['nama_mapel'] ?></span></td>
                                            <td><span class="badge bg-info"><?= $tugas['nama_kelas'] ?></span></td>
                                            <td>
                                                <div class="deadline-info">
                                                    <span class="deadline-text <?= strtotime($tugas['deadline']) < time() ? 'text-danger' : 'text-muted' ?>">
                                                        <?= date('d/m/Y H:i', strtotime($tugas['deadline'])) ?>
                                                    </span>
                                                    <?php if (strtotime($tugas['deadline']) < time()): ?>
                                                        <small class="text-danger d-block">Deadline lewat</small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                $total_siswa = $tugas['total_siswa'] ?? 0;
                                                $dikumpulkan = $tugas['dikumpulkan'] ?? 0;
                                                $terlambat = $tugas['terlambat'] ?? 0;
                                                $belum_dikumpulkan = $total_siswa - $dikumpulkan - $terlambat;
                                                ?>
                                                <div class="status-summary">
                                                    <div class="status-item">
                                                        <span class="status-dot bg-success"></span>
                                                        <small><?= $dikumpulkan ?> dikumpulkan</small>
                                                    </div>
                                                    <?php if ($terlambat > 0): ?>
                                                        <div class="status-item">
                                                            <span class="status-dot bg-danger"></span>
                                                            <small><?= $terlambat ?> terlambat</small>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($belum_dikumpulkan > 0): ?>
                                                        <div class="status-item">
                                                            <span class="status-dot bg-warning"></span>
                                                            <small><?= $belum_dikumpulkan ?> belum</small>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress-container">
                                                    <div class="progress">
                                                        <?php if ($total_siswa > 0): ?>
                                                            <div class="progress-bar bg-success" style="width: <?= ($dikumpulkan / $total_siswa) * 100 ?>%"></div>
                                                            <div class="progress-bar bg-danger" style="width: <?= ($terlambat / $total_siswa) * 100 ?>%"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <small class="text-muted"><?= $dikumpulkan + $terlambat ?>/<?= $total_siswa ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('guru/materitugas/detailPengumpulan/' . $tugas['id']) ?>"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    <a href="<?= base_url('guru/materitugas/downloadAll/' . $tugas['id']) ?>"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i> Download All
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .welcome-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
    }

    .welcome-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .floating-card {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .modern-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon {
        width: 40px;
        height: 40px;
        background: #007bff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .header-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: #495057;
    }

    .header-subtitle {
        color: #6c757d;
        margin: 0;
        font-size: 0.9rem;
    }

    .card-body-modern {
        padding: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card-primary {
        border-left: 4px solid #007bff;
    }

    .stat-card-success {
        border-left: 4px solid #28a745;
    }

    .stat-card-warning {
        border-left: 4px solid #ffc107;
    }

    .stat-card-danger {
        border-left: 4px solid #dc3545;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .stat-card-primary .stat-icon {
        background: #e3f2fd;
        color: #007bff;
    }

    .stat-card-success .stat-icon {
        background: #e8f5e8;
        color: #28a745;
    }

    .stat-card-warning .stat-icon {
        background: #fff8e1;
        color: #ffc107;
    }

    .stat-card-danger .stat-icon {
        background: #ffebee;
        color: #dc3545;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .task-info h6 {
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .deadline-info {
        display: flex;
        flex-direction: column;
    }

    .deadline-text {
        font-weight: 600;
    }

    .status-summary {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .status-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .progress-container {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 4px;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
        color: #6c757d;
    }

    .empty-title {
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .empty-subtitle {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
            text-align: center;
        }

        .welcome-title {
            font-size: 2rem;
        }

        .stat-card {
            margin-bottom: 1rem;
        }

        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>
<?= $this->endSection() ?>