<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Absensi Guru 📊</h1>
                        <p class="welcome-subtitle">Riwayat kehadiran Anda</p>
                        <div class="welcome-meta">
                            <span class="meta-item">
                                <i class="fas fa-user"></i>
                                <?= $guru['nama'] ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                Total: <?= count($absensi) ?> hari
                            </span>
                        </div>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-chart-line"></i>
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
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Riwayat Absensi</h4>
                            <p class="header-subtitle">Daftar kehadiran Anda</p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="<?= base_url('guru/absensi-guru/create') ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Input Absensi
                        </a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <?= session('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($absensi)): ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h5>Belum Ada Data Absensi</h5>
                            <p>Anda belum mengisi absensi. Silakan input absensi pertama Anda.</p>
                            <a href="<?= base_url('guru/absensi-guru/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Input Absensi Pertama
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Durasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($absensi as $a): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= date('d/m/Y', strtotime($a['tanggal'])) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= date('l', strtotime($a['tanggal'])) ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-clock"></i> <?= $a['jam_masuk'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($a['jam_pulang']): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-clock"></i> <?= $a['jam_pulang'] ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-minus"></i> Belum Pulang
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = 'bg-secondary';
                                                switch ($a['status']) {
                                                    case 'Hadir':
                                                        $statusClass = 'bg-success';
                                                        break;
                                                    case 'Izin':
                                                        $statusClass = 'bg-warning';
                                                        break;
                                                    case 'Sakit':
                                                        $statusClass = 'bg-info';
                                                        break;
                                                    case 'Alpha':
                                                        $statusClass = 'bg-danger';
                                                        break;
                                                    case 'Dinas Luar':
                                                        $statusClass = 'bg-primary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $statusClass ?>">
                                                    <?= $a['status'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($a['keterangan']): ?>
                                                    <span class="text-muted"><?= esc($a['keterangan']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($a['jam_masuk'] && $a['jam_pulang']) {
                                                    $masuk = strtotime($a['jam_masuk']);
                                                    $pulang = strtotime($a['jam_pulang']);
                                                    $durasi = $pulang - $masuk;
                                                    $jam = floor($durasi / 3600);
                                                    $menit = floor(($durasi % 3600) / 60);
                                                    echo "<span class='badge bg-primary'>{$jam}j {$menit}m</span>";
                                                } else {
                                                    echo "<span class='badge bg-secondary'>-</span>";
                                                }
                                                ?>
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
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 4rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #495057;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 2rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

@media (max-width: 768px) {
    .header-actions {
        margin-top: 1rem;
        justify-content: center;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>

<?= $this->endSection() ?> 