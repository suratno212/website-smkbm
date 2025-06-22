<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas') ?>">E-Learning</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Tugas</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Daftar Tugas</h1>
                        <p class="welcome-subtitle">Kelola semua tugas yang telah dibuat</p>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-tasks"></i>
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
                        <div class="header-icon"><i class="fas fa-tasks"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Semua Tugas</h4>
                            <p class="header-subtitle">Daftar lengkap tugas yang telah dibuat</p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('guru/materitugas/uploadTugas') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Tugas Baru
                        </a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($tugas)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-tasks"></i></div>
                            <h5 class="empty-title">Belum ada tugas</h5>
                            <p class="empty-subtitle">Buat tugas untuk siswa</p>
                            <a href="<?= base_url('guru/materitugas/uploadTugas') ?>" class="btn btn-primary">Buat Tugas</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Deskripsi</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Deadline</th>
                                        <th>Bobot Nilai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tugas as $index => $t): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <div class="task-info">
                                                <h6 class="task-title"><?= $t['deskripsi'] ?></h6>
                                                <?php if ($t['file']): ?>
                                                    <small class="text-muted">
                                                        <i class="fas fa-paperclip me-1"></i>Ada lampiran
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary"><?= $t['nama_mapel'] ?? 'N/A' ?></span></td>
                                        <td><span class="badge bg-info"><?= $t['nama_kelas'] ?? 'N/A' ?></span></td>
                                        <td>
                                            <div class="deadline-info">
                                                <span class="deadline-text <?= strtotime($t['deadline']) < time() ? 'text-danger' : 'text-muted' ?>">
                                                    <?= date('d/m/Y H:i', strtotime($t['deadline'])) ?>
                                                </span>
                                                <?php if (strtotime($t['deadline']) < time()): ?>
                                                    <small class="text-danger d-block">Deadline lewat</small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-secondary"><?= $t['bobot_nilai'] ?? 10 ?>%</span></td>
                                        <td>
                                            <?php
                                            $statusClass = '';
                                            $statusText = '';
                                            
                                            if (strtotime($t['deadline']) < time()) {
                                                $statusClass = 'bg-danger';
                                                $statusText = 'Deadline Lewat';
                                            } else {
                                                $statusClass = 'bg-success';
                                                $statusText = 'Aktif';
                                            }
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('guru/materitugas/detailPengumpulan/' . $t['id']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Review Pengumpulan">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($t['file']): ?>
                                                    <a href="<?= base_url('uploads/tugas/' . $t['file']) ?>" 
                                                       target="_blank" class="btn btn-sm btn-outline-info" title="Download Lampiran">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?= base_url('guru/materitugas/editTugas/' . $t['id']) ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('guru/materitugas/deleteTugas/' . $t['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Yakin ingin menghapus tugas ini?')" title="Hapus">
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
    background: #28a745;
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

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .card-body-modern {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>
<?= $this->endSection() ?> 