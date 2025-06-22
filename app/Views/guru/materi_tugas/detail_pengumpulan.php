<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas') ?>">E-Learning</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas/pengumpulan') ?>">Review Tugas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pengumpulan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Tugas Info -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Informasi Tugas</h4>
                            <p class="header-subtitle">Detail tugas yang sedang direview</p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('guru/materitugas/downloadAll/' . $tugas['id']) ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-download me-2"></i>Download All
                        </a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Mata Pelajaran:</strong></td>
                                    <td><span class="badge bg-primary"><?= $tugas['nama_mapel'] ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Kelas:</strong></td>
                                    <td><span class="badge bg-info"><?= $tugas['nama_kelas'] ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi:</strong></td>
                                    <td><?= $tugas['deskripsi'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Deadline:</strong></td>
                                    <td>
                                        <span class="badge <?= strtotime($tugas['deadline']) < time() ? 'bg-danger' : 'bg-warning' ?>">
                                            <?= date('d/m/Y H:i', strtotime($tugas['deadline'])) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Bobot Nilai:</strong></td>
                                    <td><span class="badge bg-secondary"><?= $tugas['bobot_nilai'] ?? 10 ?>%</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <?php
                                        $total_siswa = count($siswa_list);
                                        $dikumpulkan = 0;
                                        $terlambat = 0;
                                        $belum_dikumpulkan = 0;
                                        
                                        foreach ($siswa_list as $siswa) {
                                            if ($siswa['status'] == 'Dikumpulkan') $dikumpulkan++;
                                            elseif ($siswa['status'] == 'Terlambat') $terlambat++;
                                            else $belum_dikumpulkan++;
                                        }
                                        ?>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-success"><?= $dikumpulkan ?> Dikumpulkan</span>
                                            <?php if ($terlambat > 0): ?>
                                                <span class="badge bg-danger"><?= $terlambat ?> Terlambat</span>
                                            <?php endif; ?>
                                            <?php if ($belum_dikumpulkan > 0): ?>
                                                <span class="badge bg-warning"><?= $belum_dikumpulkan ?> Belum</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-users"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Daftar Pengumpulan Siswa</h4>
                            <p class="header-subtitle">Review dan nilai pengumpulan tugas siswa</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($siswa_list)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-users"></i></div>
                            <h5 class="empty-title">Tidak ada siswa</h5>
                            <p class="empty-subtitle">Tidak ada siswa di kelas ini</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>File Tugas</th>
                                        <th>Tanggal Upload</th>
                                        <th>Nilai</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($siswa_list as $index => $siswa): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><strong><?= $siswa['nisn'] ?? $siswa['username'] ?? 'N/A' ?></strong></td>
                                        <td><?= $siswa['nama'] ?></td>
                                        <td>
                                            <?php
                                            $statusClass = '';
                                            $statusText = $siswa['status'];
                                            
                                            switch ($siswa['status']) {
                                                case 'Dikumpulkan':
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'Terlambat':
                                                    $statusClass = 'bg-danger';
                                                    break;
                                                case 'Belum dikumpulkan':
                                                    $statusClass = 'bg-warning';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td>
                                            <?php if ($siswa['pengumpulan'] && $siswa['pengumpulan']['file_tugas']): ?>
                                                <a href="<?= base_url('uploads/tugas_siswa/' . $siswa['pengumpulan']['file_tugas']) ?>" 
                                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($siswa['pengumpulan'] && $siswa['pengumpulan']['created_at']): ?>
                                                <?= date('d/m/Y H:i', strtotime($siswa['pengumpulan']['created_at'])) ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($siswa['pengumpulan']): ?>
                                                <span class="badge <?= $siswa['nilai'] ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= $siswa['nilai'] ? $siswa['nilai'] : 'Belum dinilai' ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($siswa['pengumpulan'] && $siswa['catatan']): ?>
                                                <span class="text-truncate d-inline-block" style="max-width: 150px;" 
                                                      title="<?= $siswa['catatan'] ?>">
                                                    <?= $siswa['catatan'] ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($siswa['pengumpulan']): ?>
                                                <button type="button" class="btn btn-sm btn-warning" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#nilaiModal<?= $siswa['pengumpulan']['id'] ?>">
                                                    <i class="fas fa-edit"></i> Nilai
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted">Belum dikumpulkan</span>
                                            <?php endif; ?>
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

<!-- Modal Nilai -->
<?php foreach ($siswa_list as $siswa): ?>
    <?php if ($siswa['pengumpulan']): ?>
    <div class="modal fade" id="nilaiModal<?= $siswa['pengumpulan']['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nilai Tugas - <?= $siswa['nama'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('guru/materitugas/nilaiTugas') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="pengumpulan_id" value="<?= $siswa['pengumpulan']['id'] ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nilai<?= $siswa['pengumpulan']['id'] ?>" class="form-label">Nilai (0-100)</label>
                            <input type="number" class="form-control" id="nilai<?= $siswa['pengumpulan']['id'] ?>" 
                                   name="nilai" min="0" max="100" 
                                   value="<?= $siswa['nilai'] ?? '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="catatan<?= $siswa['pengumpulan']['id'] ?>" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan<?= $siswa['pengumpulan']['id'] ?>" 
                                      name="catatan" rows="3"><?= $siswa['catatan'] ?? '' ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<style>
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

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

@media (max-width: 768px) {
    .card-body-modern {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>
<?= $this->endSection() ?> 