<?= $this->extend('layout/siswa') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('siswa/absensi') ?>">Absensi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Riwayat Absensi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Riwayat Absensi</h4>
                            <p class="header-subtitle">Riwayat kehadiran Anda</p>
                        </div>
                    </div>
                    <div class="header-action">
                        <form class="d-flex gap-2" method="get">
                            <select name="bulan" class="form-select form-select-sm" style="width: auto;">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                                        <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="tahun" class="form-select form-select-sm" style="width: auto;">
                                <?php for ($y = date('Y'); $y >= date('Y') - 2; $y--): ?>
                                    <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body-modern">
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stats-card stats-card-success">
                                <div class="stats-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stats-content">
                                    <h3 class="stats-number"><?= $rekap['hadir'] ?></h3>
                                    <p class="stats-label">Hadir</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card stats-card-warning">
                                <div class="stats-icon">
                                    <i class="fas fa-procedures"></i>
                                </div>
                                <div class="stats-content">
                                    <h3 class="stats-number"><?= $rekap['sakit'] ?></h3>
                                    <p class="stats-label">Sakit</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card stats-card-info">
                                <div class="stats-icon">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                <div class="stats-content">
                                    <h3 class="stats-number"><?= $rekap['izin'] ?></h3>
                                    <p class="stats-label">Izin</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card stats-card-danger">
                                <div class="stats-icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stats-content">
                                    <h3 class="stats-number"><?= $rekap['alpha'] ?></h3>
                                    <p class="stats-label">Alpha</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Table -->
                    <?php if (empty($absensi)): ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <h5 class="empty-title">Tidak ada data absensi</h5>
                            <p class="empty-subtitle">Tidak ada data absensi untuk periode yang dipilih</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($absensi as $index => $a): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= date('d/m/Y', strtotime($a['tanggal'])) ?></td>
                                            <td><?= date('l', strtotime($a['tanggal'])) ?></td>
                                            <td>
                                                <?php
                                                $statusClass = '';
                                                $statusText = '';

                                                switch ($a['status']) {
                                                    case 'H':
                                                        $statusClass = 'bg-success';
                                                        $statusText = 'Hadir';
                                                        break;
                                                    case 'S':
                                                        $statusClass = 'bg-warning';
                                                        $statusText = 'Sakit';
                                                        break;
                                                    case 'I':
                                                        $statusClass = 'bg-info';
                                                        $statusText = 'Izin';
                                                        break;
                                                    case 'A':
                                                        $statusClass = 'bg-danger';
                                                        $statusText = 'Alpha';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-secondary';
                                                        $statusText = $a['status'];
                                                }
                                                ?>
                                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                            </td>
                                            <td><?= $a['keterangan'] ?: '-' ?></td>
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

    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stats-card-success {
        border-left: 4px solid #28a745;
    }

    .stats-card-warning {
        border-left: 4px solid #ffc107;
    }

    .stats-card-info {
        border-left: 4px solid #17a2b8;
    }

    .stats-card-danger {
        border-left: 4px solid #dc3545;
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stats-card-success .stats-icon {
        background: #d4edda;
        color: #28a745;
    }

    .stats-card-warning .stats-icon {
        background: #fff3cd;
        color: #856404;
    }

    .stats-card-info .stats-icon {
        background: #d1ecf1;
        color: #0c5460;
    }

    .stats-card-danger .stats-icon {
        background: #f8d7da;
        color: #721c24;
    }

    .stats-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: #495057;
    }

    .stats-label {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
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
        margin-bottom: 0;
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
</style>
<?= $this->endSection() ?>