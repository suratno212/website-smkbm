<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">E-Learning</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">E-Learning</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Materi Pembelajaran -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-book text-primary me-2"></i>
                                Materi Pembelajaran
                            </h4>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/materitugas/materi') ?>" class="btn btn-primary btn-sm">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($materi)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada materi pembelajaran</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Judul</th>
                                        <th>Guru</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($materi, 0, 5) as $m): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-info"><?= esc($m['nama_mapel']) ?></span>
                                        </td>
                                        <td>
                                            <strong><?= esc($m['judul']) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= esc($m['deskripsi']) ?></small>
                                        </td>
                                        <td><?= esc($m['nama_guru']) ?></td>
                                        <td>
                                            <?php if ($m['file']): ?>
                                                <a href="<?= base_url('siswa/materitugas/downloadMateri/' . $m['kd_materi']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
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

        <!-- Tugas -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-tasks text-warning me-2"></i>
                                Tugas
                            </h4>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/materitugas/tugas') ?>" class="btn btn-warning btn-sm">
                                Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($tugas)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada tugas</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Deskripsi</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($tugas, 0, 5) as $t): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-warning"><?= esc($t['nama_mapel']) ?></span>
                                        </td>
                                        <td>
                                            <strong><?= esc($t['deskripsi']) ?></strong>
                                            <br>
                                            <small class="text-muted">Oleh: <?= esc($t['nama_guru']) ?></small>
                                        </td>
                                        <td>
                                            <?php 
                                            $deadline = new DateTime($t['deadline']);
                                            $now = new DateTime();
                                            $isOverdue = $deadline < $now;
                                            ?>
                                            <span class="<?= $isOverdue ? 'text-danger' : 'text-success' ?>">
                                                <?= $deadline->format('d/m/Y H:i') ?>
                                            </span>
                                            <?php if ($isOverdue): ?>
                                                <br><small class="text-danger">Terlambat</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('siswa/materitugas/detailTugas/' . $t['kd_tugas']) ?>" 
                                               class="btn btn-sm btn-outline-info">
                                                Detail
                                            </a>
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

    <!-- Statistik -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Materi</p>
                            <h4 class="mb-0"><?= count($materi) ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center d-flex justify-content-center align-items-center shadow" style="width:56px;height:56px;margin:auto;">
                                <span class="avatar-title">
                                    <i class="fas fa-book" style="font-size:2rem;color:#fff;"></i>
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
                            <p class="text-muted fw-medium">Total Tugas</p>
                            <h4 class="mb-0"><?= count($tugas) ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center d-flex justify-content-center align-items-center shadow" style="width:56px;height:56px;margin:auto;">
                                <span class="avatar-title">
                                    <i class="fas fa-tasks" style="font-size:2rem;color:#fff;"></i>
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
                            <p class="text-muted fw-medium">Tugas Aktif</p>
                            <h4 class="mb-0">
                                <?php 
                                $activeTasks = 0;
                                foreach ($tugas as $t) {
                                    if (new DateTime($t['deadline']) > new DateTime()) {
                                        $activeTasks++;
                                    }
                                }
                                echo $activeTasks;
                                ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success align-self-center d-flex justify-content-center align-items-center shadow" style="width:56px;height:56px;margin:auto;">
                                <span class="avatar-title">
                                    <i class="fas fa-clock" style="font-size:2rem;color:#fff;"></i>
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
                            <p class="text-muted fw-medium">Tugas Terlambat</p>
                            <h4 class="mb-0">
                                <?php 
                                $overdueTasks = 0;
                                foreach ($tugas as $t) {
                                    if (new DateTime($t['deadline']) < new DateTime()) {
                                        $overdueTasks++;
                                    }
                                }
                                echo $overdueTasks;
                                ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-danger align-self-center d-flex justify-content-center align-items-center shadow" style="width:56px;height:56px;margin:auto;">
                                <span class="avatar-title">
                                    <i class="fas fa-exclamation-triangle" style="font-size:2rem;color:#fff;"></i>
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