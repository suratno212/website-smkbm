<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Absensi Siswa 📝</h1>
                        <p class="welcome-subtitle">Kelola kehadiran Anda di sekolah</p>
                        <div class="welcome-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar-day"></i>
                                <?= date('l, d F Y') ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span id="current-time"></span>
                            </span>
                        </div>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Absensi Hari Ini -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Status Absensi Hari Ini</h4>
                            <p class="header-subtitle"><?= date('d F Y') ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success"><?= session('success') ?></div>
                    <?php endif; ?>
                    
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger"><?= session('error') ?></div>
                    <?php endif; ?>

                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger text-center my-5"><?= $error_message ?></div>
                    <?php else: ?>
                        <?php if ($absen_today): ?>
                            <div class="absensi-status absensi-done">
                                <div class="status-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="status-content">
                                    <h5>Absensi Sudah Diisi</h5>
                                    <p class="status-detail">
                                        <strong>Status:</strong> 
                                        <span class="badge badge-<?= $absen_today['status'] == 'hadir' ? 'success' : ($absen_today['status'] == 'sakit' ? 'warning' : ($absen_today['status'] == 'izin' ? 'info' : 'danger')) ?>">
                                            <?= ucfirst($absen_today['status']) ?>
                                        </span>
                                    </p>
                                    <?php if (isset($absen_today['keterangan']) && $absen_today['keterangan']): ?>
                                        <p class="status-detail">
                                            <strong>Keterangan:</strong> <?= $absen_today['keterangan'] ?>
                                        </p>
                                    <?php endif; ?>
                                    <p class="status-time">
                                        <i class="fas fa-clock"></i>
                                        Diisi pada: <?= date('H:i', strtotime($absen_today['created_at'] ?? 'now')) ?>
                                    </p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="absensi-status absensi-pending">
                                <div class="status-icon">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="status-content">
                                    <h5>Belum Mengisi Absensi</h5>
                                    <p>Anda belum mengisi absensi untuk hari ini. Silakan isi absensi sekarang.</p>
                                    <a href="<?= base_url('siswa/absensi/form') ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Isi Absensi Sekarang
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="action-card action-card-primary">
                <div class="action-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="action-content">
                    <h5>Isi Absensi</h5>
                    <p>Isi absensi kehadiran Anda hari ini</p>
                </div>
                <div class="action-arrow">
                    <a href="<?= base_url('siswa/absensi/form') ?>" class="btn-link">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="action-card action-card-info">
                <div class="action-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="action-content">
                    <h5>Riwayat Absensi</h5>
                    <p>Lihat riwayat kehadiran Anda</p>
                </div>
                <div class="action-arrow">
                    <a href="<?= base_url('siswa/absensi/riwayat') ?>" class="btn-link">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Absensi Status Styles */
.absensi-status {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
    border-radius: 15px;
    margin: 1rem 0;
}

.absensi-done {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border: 1px solid #c3e6cb;
    color: #155724;
}

.absensi-pending {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    border: 1px solid #ffeaa7;
    color: #856404;
}

.status-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
}

.absensi-done .status-icon {
    background: #28a745;
    color: white;
}

.absensi-pending .status-icon {
    background: #ffc107;
    color: white;
}

.status-content {
    flex: 1;
}

.status-content h5 {
    margin: 0 0 1rem 0;
    font-weight: 600;
}

.status-detail {
    margin: 0.5rem 0;
    font-size: 0.95rem;
}

.status-time {
    margin: 1rem 0 0 0;
    font-size: 0.9rem;
    opacity: 0.8;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.badge-success {
    background: #28a745;
    color: white;
}

.badge-warning {
    background: #ffc107;
    color: #212529;
}

.badge-info {
    background: #17a2b8;
    color: white;
}

.badge-danger {
    background: #dc3545;
    color: white;
}

/* Action Cards */
.action-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    height: 100%;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.action-card-primary {
    border-left: 4px solid #1a237e;
}

.action-card-info {
    border-left: 4px solid #17a2b8;
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.action-card-primary .action-icon {
    background: linear-gradient(135deg, #1a237e, #283593);
}

.action-card-info .action-icon {
    background: linear-gradient(135deg, #17a2b8, #138496);
}

.action-content {
    flex: 1;
}

.action-content h5 {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    color: #333;
}

.action-content p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.action-arrow {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}

.action-card:hover .action-arrow {
    opacity: 1;
    transform: translateX(0);
}

.btn-link {
    color: #1a237e;
    text-decoration: none;
    font-size: 1.2rem;
}

.btn-link:hover {
    color: #283593;
}

/* Responsive */
@media (max-width: 768px) {
    .absensi-status {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .action-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
// Update waktu real-time
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    document.getElementById('current-time').textContent = timeString;
}

// Update waktu setiap detik
setInterval(updateTime, 1000);
updateTime();
</script>

<?= $this->endSection() ?> 