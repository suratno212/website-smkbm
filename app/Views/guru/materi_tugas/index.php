<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">E-Learning</h1>
                        <p class="welcome-subtitle">Kelola materi dan tugas untuk siswa dengan mudah</p>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik E-Learning -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-primary">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= count($materi) ?></h3>
                    <p class="stat-label">Total Materi</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= count($tugas) ?></h3>
                    <p class="stat-label">Total Tugas</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-info">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= count($kelas ?? []) ?></h3>
                    <p class="stat-label">Kelas Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= count(array_filter($tugas, function($t) { return strtotime($t['deadline']) > time(); })) ?></h3>
                    <p class="stat-label">Tugas Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <h5 class="card-title"><i class="fas fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body-modern">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="<?= base_url('guru/materitugas/uploadMateri') ?>" class="quick-action-card">
                                <div class="quick-action-icon">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <h6>Upload Materi</h6>
                                <p>Upload materi pembelajaran baru</p>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('guru/materitugas/uploadTugas') ?>" class="quick-action-card">
                                <div class="quick-action-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <h6>Buat Tugas</h6>
                                <p>Buat tugas baru untuk siswa</p>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('guru/materitugas/pengumpulan') ?>" class="quick-action-card">
                                <div class="quick-action-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h6>Review Tugas</h6>
                                <p>Review pengumpulan tugas siswa</p>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('guru/materitugas/statistik') ?>" class="quick-action-card">
                                <div class="quick-action-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h6>Statistik</h6>
                                <p>Lihat statistik E-Learning</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Materi Terbaru -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-book"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Materi Terbaru</h4>
                            <p class="header-subtitle">Materi pembelajaran yang baru diupload</p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('guru/materitugas/materi') ?>" class="btn-modern btn-modern-outline btn-modern-sm">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($materi)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-book"></i></div>
                            <h5 class="empty-title">Belum ada materi</h5>
                            <p class="empty-subtitle">Upload materi pembelajaran untuk siswa</p>
                            <a href="<?= base_url('guru/materitugas/uploadMateri') ?>" class="btn-modern btn-modern-primary">Upload Materi</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($materi, 0, 5) as $m): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="file-icon me-2">
                                                    <i class="fas fa-file-pdf"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= $m['judul'] ?></h6>
                                                    <small class="text-muted"><?= $m['deskripsi'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary"><?= $m['nama_mapel'] ?? 'N/A' ?></span></td>
                                        <td><span class="badge bg-info"><?= $m['nama_kelas'] ?? 'N/A' ?></span></td>
                                        <td><?= date('d/m/Y', strtotime($m['created_at'] ?? 'now')) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('guru/materitugas/download/' . $m['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <a href="<?= base_url('guru/materitugas/editMateri/' . $m['id']) ?>" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('guru/materitugas/deleteMateri/' . $m['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus materi ini?')">
                                                    <i class="fas fa-trash"></i>
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

        <!-- Tugas Terbaru -->
        <div class="col-lg-4">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-tasks"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Tugas Terbaru</h4>
                            <p class="header-subtitle">Tugas yang baru dibuat</p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('guru/materitugas/tugas') ?>" class="btn-modern btn-modern-outline btn-modern-sm">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($tugas)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-tasks"></i></div>
                            <h5 class="empty-title">Belum ada tugas</h5>
                            <p class="empty-subtitle">Buat tugas untuk siswa</p>
                            <a href="<?= base_url('guru/materitugas/uploadTugas') ?>" class="btn-modern btn-modern-primary">Buat Tugas</a>
                        </div>
                    <?php else: ?>
                        <div class="task-list">
                            <?php foreach (array_slice($tugas, 0, 5) as $t): ?>
                            <div class="task-item">
                                <div class="task-content">
                                    <h6 class="task-title"><?= $t['deskripsi'] ?></h6>
                                    <div class="task-meta">
                                        <span class="badge bg-primary"><?= $t['nama_mapel'] ?? 'N/A' ?></span>
                                        <span class="badge bg-info"><?= $t['nama_kelas'] ?? 'N/A' ?></span>
                                    </div>
                                    <div class="task-deadline">
                                        <i class="fas fa-clock"></i>
                                        <span class="<?= strtotime($t['deadline']) < time() ? 'text-danger' : 'text-muted' ?>">
                                            Deadline: <?= date('d/m/Y H:i', strtotime($t['deadline'])) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="task-actions">
                                    <a href="<?= base_url('guru/materitugas/editTugas/' . $t['id']) ?>" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('guru/materitugas/deleteTugas/' . $t['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                                    <?php endforeach; ?>
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

.stat-card-primary { border-left: 4px solid #007bff; }
.stat-card-success { border-left: 4px solid #28a745; }
.stat-card-info { border-left: 4px solid #17a2b8; }
.stat-card-warning { border-left: 4px solid #ffc107; }

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

.stat-card-primary .stat-icon { background: #e3f2fd; color: #007bff; }
.stat-card-success .stat-icon { background: #e8f5e8; color: #28a745; }
.stat-card-info .stat-icon { background: #e1f5fe; color: #17a2b8; }
.stat-card-warning .stat-icon { background: #fff8e1; color: #ffc107; }

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

.quick-action-card {
    display: block;
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    border-color: #007bff;
    color: inherit;
    text-decoration: none;
}

.quick-action-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.quick-action-card h6 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.quick-action-card p {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.9rem;
}

.file-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #e3f2fd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
}

.task-list {
    max-height: 400px;
    overflow-y: auto;
}

.task-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.3s ease;
}

.task-item:hover {
    background-color: #f8f9fa;
}

.task-item:last-child {
    border-bottom: none;
}

.task-content {
    flex: 1;
}

.task-title {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.task-meta {
    margin-bottom: 0.5rem;
}

.task-meta .badge {
    margin-right: 0.25rem;
}

.task-deadline {
    font-size: 0.85rem;
}

.task-deadline i {
    margin-right: 0.25rem;
}

.task-actions {
    display: flex;
    gap: 0.25rem;
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
    
    .quick-action-card {
        margin-bottom: 1rem;
    }
}
</style>
<?= $this->endSection() ?> 