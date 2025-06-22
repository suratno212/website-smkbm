<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Tugas</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/materitugas') ?>">E-Learning</a></li>
                        <li class="breadcrumb-item active">Tugas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-tasks text-warning me-2"></i>
                                Daftar Tugas
                            </h4>
                            <p class="text-muted mb-0">Kelas: <?= esc($siswa['nama_kelas'] ?? 'Tidak diketahui') ?></p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/materitugas') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($tugas)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">Belum ada tugas</h5>
                            <p class="text-muted">Tugas akan muncul di sini setelah guru memberikan tugas untuk kelas Anda.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Deskripsi Tugas</th>
                                        <th>Guru</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tugas as $i => $t): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td>
                                            <span class="badge bg-warning"><?= esc($t['nama_mapel']) ?></span>
                                        </td>
                                        <td>
                                            <strong><?= esc($t['deskripsi']) ?></strong>
                                            <?php if ($t['file']): ?>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-paperclip me-1"></i>
                                                    Ada lampiran
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($t['nama_guru']) ?></td>
                                        <td>
                                            <?php 
                                            $deadline = new DateTime($t['deadline']);
                                            $now = new DateTime();
                                            $isOverdue = $deadline < $now;
                                            ?>
                                            <span class="<?= $isOverdue ? 'text-danger' : 'text-success' ?>">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= $deadline->format('d/m/Y H:i') ?>
                                            </span>
                                            <?php if ($isOverdue): ?>
                                                <br><small class="text-danger">Terlambat</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = '';
                                            $statusText = $t['status_pengumpulan'];
                                            
                                            switch ($t['status_pengumpulan']) {
                                                case 'Dikumpulkan':
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'Belum dikumpulkan':
                                                    if ($isOverdue) {
                                                        $statusClass = 'bg-danger';
                                                        $statusText = 'Terlambat';
                                                    } else {
                                                        $statusClass = 'bg-warning';
                                                    }
                                                    break;
                                                default:
                                                    $statusClass = 'bg-secondary';
                                            }
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td>
                                            <?php if ($t['nilai'] !== null): ?>
                                                <span class="badge bg-info"><?= $t['nilai'] ?></span>
                                                <?php if ($t['catatan']): ?>
                                                    <br>
                                                    <small class="text-muted" title="<?= esc($t['catatan']) ?>">
                                                        <i class="fas fa-comment me-1"></i>
                                                        Ada catatan
                                                    </small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('siswa/materitugas/detailTugas/' . $t['id']) ?>" 
                                                   class="btn btn-sm btn-outline-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($t['file']): ?>
                                                    <a href="<?= base_url('siswa/materitugas/downloadTugas/' . $t['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Download Lampiran">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($t['status_pengumpulan'] === 'Belum dikumpulkan' && !$isOverdue): ?>
                                                    <a href="<?= base_url('siswa/materitugas/uploadTugas/' . $t['id']) ?>" 
                                                       class="btn btn-sm btn-outline-success" title="Upload Tugas">
                                                        <i class="fas fa-upload"></i>
                                                    </a>
                                                <?php endif; ?>
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

    <!-- Statistik Tugas -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Tugas</p>
                            <h4 class="mb-0"><?= count($tugas) ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center">
                                <span class="avatar-title">
                                    <i class="fas fa-tasks font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Sudah Dikumpulkan</p>
                            <h4 class="mb-0">
                                <?php 
                                $submitted = 0;
                                foreach ($tugas as $t) {
                                    if ($t['status_pengumpulan'] === 'Dikumpulkan') {
                                        $submitted++;
                                    }
                                }
                                echo $submitted;
                                ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success align-self-center">
                                <span class="avatar-title">
                                    <i class="fas fa-check font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Belum Dikumpulkan</p>
                            <h4 class="mb-0">
                                <?php 
                                $notSubmitted = 0;
                                foreach ($tugas as $t) {
                                    if ($t['status_pengumpulan'] === 'Belum dikumpulkan') {
                                        $notSubmitted++;
                                    }
                                }
                                echo $notSubmitted;
                                ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center">
                                <span class="avatar-title">
                                    <i class="fas fa-clock font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Terlambat</p>
                            <h4 class="mb-0">
                                <?php 
                                $overdue = 0;
                                foreach ($tugas as $t) {
                                    $deadline = new DateTime($t['deadline']);
                                    $now = new DateTime();
                                    if ($deadline < $now && $t['status_pengumpulan'] === 'Belum dikumpulkan') {
                                        $overdue++;
                                    }
                                }
                                echo $overdue;
                                ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-danger align-self-center">
                                <span class="avatar-title">
                                    <i class="fas fa-exclamation-triangle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 