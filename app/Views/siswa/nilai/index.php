<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Nilai Akademik</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Nilai</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Siswa -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <span class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle shadow me-2" style="width:38px;height:38px;">
                                    <i class="fas fa-user-graduate text-white fs-5"></i>
                                </span>
                                Informasi Akademik
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="120"><strong>Nama:</strong></td>
                                            <td><?= esc($siswa['nama']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIS:</strong></td>
                                            <td><?= esc($siswa['nisn']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kelas:</strong></td>
                                            <td><?= esc($kelas['nama_kelas']) ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="120"><strong>Jurusan:</strong></td>
                                            <td><?= esc($kelas['nama_jurusan']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Semester:</strong></td>
                                            <td><span class="badge bg-info"><?= $semester ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tahun:</strong></td>
                                            <td><?= esc($tahunAkademik['tahun']) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="avatar-title bg-primary rounded-circle d-flex align-items-center justify-content-center shadow" style="width:60px;height:60px;">
                                <i class="fas fa-chart-line text-white fs-4"></i>
                            </div>
                            <h4 class="text-primary mb-1"><?= number_format($rataRata, 2) ?></h4>
                            <p class="text-muted mb-0">Rata-rata Nilai</p>
                            <small class="text-muted">Peringkat <?= $peringkat ?> dari <?= $statistik['total_siswa'] ?? 0 ?> siswa</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Nilai -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Mata Pelajaran</p>
                            <h4 class="mb-0"><?= count($nilai) ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary d-flex align-items-center justify-content-center shadow">
                                <span class="avatar-title">
                                    <i class="fas fa-book text-white fs-5"></i>
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
                            <p class="text-muted fw-medium">Rata-rata Nilai</p>
                            <h4 class="mb-0"><?= number_format($rataRata, 2) ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success d-flex align-items-center justify-content-center shadow">
                                <span class="avatar-title">
                                    <i class="fas fa-chart-line text-white fs-5"></i>
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
                            <p class="text-muted fw-medium">Peringkat Kelas</p>
                            <h4 class="mb-0"><?= $peringkat ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning d-flex align-items-center justify-content-center shadow">
                                <span class="avatar-title">
                                    <i class="fas fa-trophy text-white fs-5"></i>
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
                            <p class="text-muted fw-medium">Status</p>
                            <h4 class="mb-0">
                                <?php if ($rataRata >= 70): ?>
                                    <span class="badge bg-success">Lulus</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Tidak Lulus</span>
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle <?= $rataRata >= 70 ? 'bg-success' : 'bg-danger' ?> d-flex align-items-center justify-content-center shadow">
                                <span class="avatar-title">
                                    <i class="fas <?= $rataRata >= 70 ? 'fa-check' : 'fa-times' ?> text-white fs-5"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Nilai -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <span class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle shadow me-2" style="width:38px;height:38px;">
                                    <i class="fas fa-list text-white fs-5"></i>
                                </span>
                                Daftar Nilai Mata Pelajaran
                            </h4>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/nilai/raport') ?>" class="btn btn-success btn-sm me-2">
                                <i class="fas fa-file-alt me-1" aria-label="e-Raport"></i> e-Raport
                            </a>
                            <a href="<?= base_url('siswa/nilai/statistik') ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-chart-bar me-1" aria-label="Statistik"></i> Statistik
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($nilai)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">Belum ada nilai</h5>
                            <p class="text-muted">Nilai akan muncul di sini setelah guru menginput nilai untuk semester <?= $semester ?>.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>UTS</th>
                                        <th>UAS</th>
                                        <th>Tugas</th>
                                        <th>Nilai Akhir</th>
                                        <th>Grade</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($nilai as $i => $n): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td>
                                            <strong><?= esc($n['nama_mapel']) ?></strong>
                                        </td>
                                        <td>
                                            <?php if ($n['uts'] !== null): ?>
                                                <span class="badge bg-info"><?= $n['uts'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($n['uas'] !== null): ?>
                                                <span class="badge bg-warning"><?= $n['uas'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($n['tugas'] !== null): ?>
                                                <span class="badge bg-success"><?= $n['tugas'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($n['akhir'] !== null): ?>
                                                <?php
                                                $grade = '';
                                                $gradeClass = '';
                                                if ($n['akhir'] >= 90) {
                                                    $grade = 'A';
                                                    $gradeClass = 'bg-success';
                                                } elseif ($n['akhir'] >= 80) {
                                                    $grade = 'B';
                                                    $gradeClass = 'bg-info';
                                                } elseif ($n['akhir'] >= 70) {
                                                    $grade = 'C';
                                                    $gradeClass = 'bg-warning';
                                                } elseif ($n['akhir'] >= 60) {
                                                    $grade = 'D';
                                                    $gradeClass = 'bg-danger';
                                                } else {
                                                    $grade = 'E';
                                                    $gradeClass = 'bg-dark';
                                                }
                                                ?>
                                                <span class="badge <?= $gradeClass ?>"><?= $n['akhir'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($n['akhir'] !== null): ?>
                                                <span class="badge <?= $gradeClass ?>"><?= $grade ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('siswa/nilai/detail/' . $n['mapel_id']) ?>" class="btn btn-sm btn-outline-primary" aria-label="Lihat Detail Nilai">
                                                <i class="fas fa-eye"></i>
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

    <!-- Grafik Nilai -->
    <?php if (!empty($nilai)): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle shadow me-2" style="width:38px;height:38px;">
                            <i class="fas fa-chart-bar text-white fs-5"></i>
                        </span>
                        Grafik Nilai Mata Pelajaran
                    </h4>
                </div>
                <div class="card-body">
                    <canvas id="nilaiChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if (!empty($nilai)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('nilaiChart').getContext('2d');
    
    const data = {
        labels: <?= json_encode(array_column($nilai, 'nama_mapel')) ?>,
        datasets: [{
            label: 'Nilai Akhir',
            data: <?= json_encode(array_column($nilai, 'akhir')) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            tension: 0.1
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    };

    new Chart(ctx, config);
});
</script>
<?php endif; ?>
<?= $this->endSection() ?> 