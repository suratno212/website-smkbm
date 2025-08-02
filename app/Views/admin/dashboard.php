<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Modern Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Selamat Datang, Admin! 👋</h1>
                        <p class="welcome-subtitle">Selamat datang di Sistem Informasi Akademik SMK Bhakti Mulya BNS</p>
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
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Stats Cards Row 1 -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-primary">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_siswa ?></h3>
                    <p class="stats-label">Total Siswa</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-users"></i>
                </div>
                <a href="<?= base_url('admin/siswa') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-success">
                <div class="stats-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_guru ?></h3>
                    <p class="stats-label">Total Guru</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <a href="<?= base_url('admin/guru') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-warning">
                <div class="stats-icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_kelas ?></h3>
                    <p class="stats-label">Total Kelas</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-door-open"></i>
                </div>
                <a href="<?= base_url('admin/master/kelas') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-danger">
                <div class="stats-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_mapel ?></h3>
                    <p class="stats-label">Total Mata Pelajaran</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-book"></i>
                </div>
                <a href="<?= base_url('admin/master/mapel') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modern Stats Cards Row 2 -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-info">
                <div class="stats-icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_users ?></h3>
                    <p class="stats-label">Total Users</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-user-cog"></i>
                </div>
                <a href="<?= base_url('admin/users') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-secondary">
                <div class="stats-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_jurusan ?></h3>
                    <p class="stats-label">Total Jurusan</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <a href="<?= base_url('admin/master/jurusan') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-dark">
                <div class="stats-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_tahun_akademik ?></h3>
                    <p class="stats-label">Tahun Akademik</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="<?= base_url('admin/master/tahun_akademik') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-light">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_jadwal ?></h3>
                    <p class="stats-label">Total Jadwal</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="<?= base_url('admin/jadwal') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Calon Siswa Stats Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-purple">
                <div class="stats-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_calon_siswa ?></h3>
                    <p class="stats-label">Total Calon Siswa</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-user-friends"></i>
                </div>
                <a href="<?= base_url('admin/calon-siswa') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-warning">
                <div class="stats-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $calon_siswa_terdaftar ?></h3>
                    <p class="stats-label">Terdaftar</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-user-clock"></i>
                </div>
                <a href="<?= base_url('admin/calon-siswa') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-success">
                <div class="stats-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $calon_siswa_diterima ?></h3>
                    <p class="stats-label">Diterima</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="<?= base_url('admin/calon-siswa') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-danger">
                <div class="stats-icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $calon_siswa_ditolak ?></h3>
                    <p class="stats-label">Ditolak</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-user-times"></i>
                </div>
                <a href="<?= base_url('admin/calon-siswa') ?>" class="stats-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Analytics Dashboard Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Analytics Dashboard</h4>
                            <p class="header-subtitle">Statistik dan grafik data sekolah</p>
                        </div>
                    </div>
                    <div class="header-action">
                        <button class="btn-modern btn-refresh" onclick="refreshAnalytics()" id="refreshAnalyticsBtn">
                            <i class="fas fa-sync-alt"></i>
                            <span class="btn-text">Refresh</span>
                        </button>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="analytics-grid">
                        <!-- Chart 1: Siswa per Jurusan -->
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Siswa per Jurusan</h5>
                                <div class="chart-legend">
                                    <span class="legend-item">
                                        <span class="legend-color" style="background: #1a237e;"></span>
                                        Total Siswa
                                    </span>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="chartSiswaJurusan" width="400" height="200"></canvas>
                            </div>
                        </div>

                        <!-- Chart 2: Absensi Hari Ini -->
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Absensi Hari Ini</h5>
                                <div class="chart-legend">
                                    <span class="legend-item">
                                        <span class="legend-color" style="background: #28a745;"></span>
                                        Hadir
                                    </span>
                                    <span class="legend-item">
                                        <span class="legend-color" style="background: #dc3545;"></span>
                                        Tidak Hadir
                                    </span>
                                    <span class="legend-item">
                                        <span class="legend-color" style="background: #ffc107;"></span>
                                        Sakit/Izin
                                    </span>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="chartAbsensi" width="400" height="200"></canvas>
                            </div>
                        </div>

                        <!-- Chart 3: Nilai Rata-rata per Mapel -->
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Nilai Rata-rata per Mata Pelajaran</h5>
                                <div class="chart-legend">
                                    <span class="legend-item">
                                        <span class="legend-color" style="background: #17a2b8;"></span>
                                        Rata-rata Nilai
                                    </span>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="chartNilaiMapel" width="400" height="200"></canvas>
                            </div>
                        </div>

                        <!-- Chart 4: Jadwal per Hari -->
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Jadwal Pelajaran per Hari</h5>
                                <div class="chart-legend">
                                    <span class="legend-item">
                                        <span class="legend-color" style="background: #6f42c1;"></span>
                                        Jumlah Jadwal
                                    </span>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="chartJadwalHari" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Pengumuman Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Pengumuman Terbaru</h4>
                            <p class="header-subtitle">Informasi penting untuk seluruh sekolah</p>
                        </div>
                    </div>
                    <div class="header-action">
                        <a href="<?= base_url('admin/pengumuman') ?>" class="btn-modern btn-modern-primary">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($pengumuman_terbaru)) : ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-bell-slash"></i>
                            </div>
                            <h5 class="empty-title">Belum ada pengumuman</h5>
                            <p class="empty-subtitle">Pengumuman yang dibuat akan muncul di sini</p>
                        </div>
                    <?php else : ?>
                        <div class="announcement-list">
                            <?php foreach (array_slice($pengumuman_terbaru, 0, 5) as $p) : ?>
                                <div class="announcement-item">
                                    <div class="announcement-badge">
                                        <span class="badge-modern badge-<?= $p['jenis'] == 'Jadwal Ujian' ? 'danger' : ($p['jenis'] == 'Kegiatan' ? 'warning' : 'info') ?>">
                                            <?= $p['jenis'] ?>
                                        </span>
                                    </div>
                                    <div class="announcement-content">
                                        <h6 class="announcement-title"><?= $p['judul'] ?></h6>
                                        <?php if ($p['isi']) : ?>
                                            <p class="announcement-text"><?= strlen($p['isi']) > 120 ? substr($p['isi'], 0, 120) . '...' : $p['isi'] ?></p>
                                        <?php endif; ?>
                                        <div class="announcement-meta">
                                            <span class="meta-item">
                                                <i class="fas fa-calendar"></i>
                                                <?= date('d/m/Y H:i', strtotime($p['created_at'])) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="announcement-actions">
                                        <a href="<?= base_url('admin/pengumuman/edit/' . $p['id']) ?>" class="btn-modern btn-modern-sm btn-modern-outline">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer-modern">
                            <a href="<?= base_url('admin/pengumuman') ?>" class="btn-modern btn-modern-primary">
                                <i class="fas fa-bullhorn"></i>
                                Kelola Pengumuman
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Aksi Cepat</h4>
                            <p class="header-subtitle">Akses fitur utama dengan cepat</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="quick-actions-grid">
                        <a href="<?= base_url('admin/siswa') ?>" class="action-card action-card-primary">
                            <div class="action-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Kelola Siswa</h5>
                                <p class="action-subtitle">Data siswa dan PPDB</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?= base_url('admin/guru') ?>" class="action-card action-card-success">
                            <div class="action-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Kelola Guru</h5>
                                <p class="action-subtitle">Data guru dan wali kelas</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?= base_url('admin/master') ?>" class="action-card action-card-warning">
                            <div class="action-icon">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Data Master</h5>
                                <p class="action-subtitle">Jurusan, mapel, ruangan</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?= base_url('admin/jadwal') ?>" class="action-card action-card-danger">
                            <div class="action-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Jadwal Pelajaran</h5>
                                <p class="action-subtitle">Atur jadwal kelas</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?= base_url('admin/pengumuman') ?>" class="action-card action-card-info">
                            <div class="action-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Pengumuman</h5>
                                <p class="action-subtitle">Buat dan kelola pengumuman</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?= base_url('admin/users') ?>" class="action-card action-card-secondary">
                            <div class="action-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Manajemen User</h5>
                                <p class="action-subtitle">Kelola akses pengguna</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Dashboard Styles */
:root {
    --primary-color: #1a237e;
    --secondary-color: #F7D117;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
    --border-radius: 15px;
    --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
}

/* Welcome Header */
.welcome-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, #283593 100%);
    border-radius: var(--border-radius);
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow);
}

.welcome-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.welcome-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(45deg, #fff, #F7D117);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1rem;
}

.welcome-meta {
    display: flex;
    gap: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.8;
}

.welcome-illustration {
    position: relative;
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
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Stats Cards */
.stats-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    height: 100%;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
    transition: box-shadow 0.35s cubic-bezier(.4,2,.3,1), transform 0.35s cubic-bezier(.4,2,.3,1);
    cursor: pointer;
    border: none;
}

.stats-card:hover {
    transform: translateY(-4px) scale(1.025);
    box-shadow: 0 12px 32px rgba(44, 62, 80, 0.18);
}

.stats-card-primary {
    border-left: 4px solid var(--primary-color);
}

.stats-card-success {
    border-left: 4px solid var(--success-color);
}

.stats-card-warning {
    border-left: 4px solid var(--warning-color);
}

.stats-card-danger {
    border-left: 4px solid var(--danger-color);
}

.stats-card-info {
    border-left: 4px solid var(--info-color);
}

.stats-card-secondary {
    border-left: 4px solid #6c757d;
}

.stats-card-dark {
    border-left: 4px solid var(--dark-color);
}

.stats-card-light {
    border-left: 4px solid #adb5bd;
}

.stats-card-purple {
    border-left: 4px solid #6f42c1;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.stats-card-primary .stats-icon {
    background: linear-gradient(135deg, var(--primary-color), #283593);
    color: white;
}

.stats-card-success .stats-icon {
    background: linear-gradient(135deg, var(--success-color), #20c997);
    color: white;
}

.stats-card-warning .stats-icon {
    background: linear-gradient(135deg, var(--warning-color), #fd7e14);
    color: white;
}

.stats-card-danger .stats-icon {
    background: linear-gradient(135deg, var(--danger-color), #e74c3c);
    color: white;
}

.stats-card-info .stats-icon {
    background: linear-gradient(135deg, var(--info-color), #3498db);
    color: white;
}

.stats-card-secondary .stats-icon {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
}

.stats-card-dark .stats-icon {
    background: linear-gradient(135deg, var(--dark-color), #212529);
    color: white;
}

.stats-card-light .stats-icon {
    background: linear-gradient(135deg, #adb5bd, #6c757d);
    color: white;
}

.stats-card-purple .stats-icon {
    background: linear-gradient(135deg, #6f42c1, #5a32a3);
    color: white;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
    transition: color 0.3s;
}

.stats-label {
    color: #6c757d;
    font-weight: 500;
    margin: 0;
    transition: color 0.3s;
}

.stats-bg {
    position: absolute;
    top: -20px;
    right: -20px;
    font-size: 8rem;
    opacity: 0.05;
    color: var(--primary-color);
}

.stats-link {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    opacity: 0;
    transform: scale(0.8);
}

.stats-card:hover .stats-link {
    opacity: 1;
    transform: scale(1);
}

.stats-link:hover {
    background: #283593;
    transform: scale(1.1);
}

/* Modern Cards */
.modern-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    box-shadow: var(--shadow-hover);
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
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.header-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0;
    color: var(--dark-color);
}

.header-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.header-action {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-action .btn-modern {
    margin: 0;
}

.header-action .btn-modern:hover {
    transform: translateY(-2px);
}

.card-body-modern {
    padding: 1.5rem;
}

.card-footer-modern {
    padding: 1.5rem;
    border-top: 1px solid #dee2e6;
    text-align: center;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: #6c757d;
}

.empty-title {
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.empty-subtitle {
    color: #adb5bd;
    margin: 0;
}

/* Announcement List */
.announcement-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.announcement-item {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.announcement-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.announcement-badge {
    flex-shrink: 0;
}

.badge-modern {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-danger {
    background: var(--danger-color);
    color: white;
}

.badge-warning {
    background: var(--warning-color);
    color: #212529;
}

.badge-info {
    background: var(--info-color);
    color: white;
}

.announcement-content {
    flex: 1;
}

.announcement-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.announcement-text {
    color: #6c757d;
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.announcement-meta {
    display: flex;
    gap: 1rem;
}

.announcement-meta .meta-item {
    color: #adb5bd;
    font-size: 0.8rem;
}

.announcement-actions {
    flex-shrink: 0;
}

/* Quick Actions Grid */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.action-card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
    text-decoration: none;
}

.action-card:hover::before {
    opacity: 1;
}

.action-card-primary {
    border-color: var(--primary-color);
}

.action-card-primary:hover {
    background: var(--primary-color);
    color: white;
}

.action-card-success {
    border-color: var(--success-color);
}

.action-card-success:hover {
    background: var(--success-color);
    color: white;
}

.action-card-warning {
    border-color: var(--warning-color);
}

.action-card-warning:hover {
    background: var(--warning-color);
    color: white;
}

.action-card-danger {
    border-color: var(--danger-color);
}

.action-card-danger:hover {
    background: var(--danger-color);
    color: white;
}

.action-card-info {
    border-color: var(--info-color);
}

.action-card-info:hover {
    background: var(--info-color);
    color: white;
}

.action-card-secondary {
    border-color: #6c757d;
}

.action-card-secondary:hover {
    background: #6c757d;
    color: white;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.action-card-primary .action-icon {
    background: var(--primary-color);
    color: white;
}

.action-card-success .action-icon {
    background: var(--success-color);
    color: white;
}

.action-card-warning .action-icon {
    background: var(--warning-color);
    color: white;
}

.action-card-danger .action-icon {
    background: var(--danger-color);
    color: white;
}

.action-card-info .action-icon {
    background: var(--info-color);
    color: white;
}

.action-card-secondary .action-icon {
    background: #6c757d;
    color: white;
}

.action-content {
    flex: 1;
}

.action-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    transition: color 0.3s ease;
}

.action-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
    transition: color 0.3s ease;
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

/* Modern Buttons */
.btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-modern-primary {
    background: var(--primary-color);
    color: white;
}

.btn-modern-primary:hover {
    background: #283593;
    color: white;
    transform: translateY(-2px);
}

.btn-modern-outline {
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.btn-modern-outline:hover {
    background: var(--primary-color);
    color: white;
}

.btn-modern-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

/* Refresh Button Styles */
.btn-refresh {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, var(--primary-color) 0%, #283593 100%);
    box-shadow: 0 4px 15px rgba(26, 35, 126, 0.3);
    border: none;
    font-weight: 600;
    letter-spacing: 0.5px;
    min-width: 120px;
    justify-content: center;
    color: white;
}

.btn-refresh:hover {
    background: linear-gradient(135deg, #283593 0%, #1a237e 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(26, 35, 126, 0.4);
    color: white;
}

.btn-refresh:active {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(26, 35, 126, 0.3);
    color: white;
}

.btn-refresh:disabled {
    background: linear-gradient(135deg, #9fa8da 0%, #7986cb 100%);
    cursor: not-allowed;
    transform: none;
    box-shadow: 0 2px 8px rgba(26, 35, 126, 0.2);
    color: rgba(255, 255, 255, 0.7);
}

.btn-refresh:disabled:hover {
    transform: none;
    box-shadow: 0 2px 8px rgba(26, 35, 126, 0.2);
    color: rgba(255, 255, 255, 0.7);
}

.btn-refresh i {
    transition: all 0.3s ease;
    font-size: 1.1em;
    color: white;
}

.btn-refresh:hover i {
    transform: rotate(180deg);
    color: white;
}

.btn-refresh.loading i {
    animation: spin 1s linear infinite;
    color: white;
}

.btn-refresh.loading .btn-text {
    opacity: 0.7;
    color: white;
}

.btn-refresh .btn-text {
    transition: all 0.3s ease;
    font-weight: 600;
    color: white;
}

/* Ripple effect for refresh button */
.btn-refresh::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-refresh:active::before {
    width: 300px;
    height: 300px;
}

/* Success animation for refresh completion */
.btn-refresh.success {
    background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
    animation: successPulse 0.6s ease;
}

@keyframes successPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .welcome-meta {
        justify-content: center;
    }
    
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
    
    .announcement-item {
        flex-direction: column;
        text-align: center;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    /* Mobile responsive for refresh button */
    .btn-refresh {
        min-width: 100px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }
    
    .btn-refresh .btn-text {
        font-size: 0.85rem;
    }
    
    .header-action {
        margin-top: 1rem;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .welcome-header {
        padding: 1.5rem;
    }
    
    .stats-card {
        padding: 1rem;
    }
    
    .stats-number {
        font-size: 1.5rem;
    }
}

/* Analytics Styles */
.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-top: 1rem;
}

.chart-container {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.chart-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.chart-title {
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
    font-size: 1.1rem;
}

.chart-legend {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-light);
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
}

.chart-wrapper {
    position: relative;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chart-wrapper canvas {
    max-width: 100%;
    height: auto !important;
}

/* Loading state for charts */
.chart-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    color: var(--text-light);
}

.chart-loading i {
    font-size: 2rem;
    animation: spin 1s linear infinite;
}

@media (max-width: 768px) {
    .analytics-grid {
        grid-template-columns: 1fr;
    }
    
    .chart-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .chart-legend {
        justify-content: flex-start;
    }
}
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Update waktu real-time
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    document.getElementById('current-time').textContent = timeString;
}

// Update waktu setiap detik
setInterval(updateTime, 1000);
updateTime(); // Update pertama kali

// Analytics Charts
let charts = {};

// Initialize charts
function initializeCharts() {
    // Chart 1: Siswa per Jurusan
    const ctxSiswaJurusan = document.getElementById('chartSiswaJurusan');
    if (ctxSiswaJurusan) {
        charts.siswaJurusan = new Chart(ctxSiswaJurusan, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        '#1a237e', // TKJ (biru tua)
                        '#388e3c' // TBSM (hijau)
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    // Chart 2: Absensi Hari Ini
    const ctxAbsensi = document.getElementById('chartAbsensi');
    if (ctxAbsensi) {
        charts.absensi = new Chart(ctxAbsensi, {
            type: 'pie',
            data: {
                labels: ['Hadir', 'Tidak Hadir', 'Sakit/Izin'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    // Chart 3: Nilai Rata-rata per Mapel
    const ctxNilaiMapel = document.getElementById('chartNilaiMapel');
    if (ctxNilaiMapel) {
        charts.nilaiMapel = new Chart(ctxNilaiMapel, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: [],
                    backgroundColor: '#17a2b8',
                    borderColor: '#17a2b8',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Chart 4: Jadwal per Hari
    const ctxJadwalHari = document.getElementById('chartJadwalHari');
    if (ctxJadwalHari) {
        charts.jadwalHari = new Chart(ctxJadwalHari, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                datasets: [{
                    label: 'Jumlah Jadwal',
                    data: [0, 0, 0, 0, 0, 0],
                    borderColor: '#6f42c1',
                    backgroundColor: 'rgba(111, 66, 193, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
}

// Load analytics data
function loadAnalyticsData() {
    return fetch('<?= base_url('admin/dashboard/analytics') ?>')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            updateCharts(data);
            return data;
        })
        .catch(error => {
            console.error('Error loading analytics data:', error);
            throw error;
        });
}

// Update charts with data
function updateCharts(data) {
    // Update Siswa per Jurusan
    if (charts.siswaJurusan && data.siswa_per_jurusan) {
        const labels = data.siswa_per_jurusan.map(item => item.nama_jurusan);
        const values = data.siswa_per_jurusan.map(item => parseInt(item.total));
        
        charts.siswaJurusan.data.labels = labels;
        charts.siswaJurusan.data.datasets[0].data = values;
        charts.siswaJurusan.update();
    }

    // Update Absensi Hari Ini
    if (charts.absensi && data.absensi_hari_ini) {
        const hadir = data.absensi_hari_ini.find(item => item.status === 'hadir')?.total || 0;
        const tidakHadir = data.absensi_hari_ini.find(item => item.status === 'tidak_hadir')?.total || 0;
        const sakitIzin = data.absensi_hari_ini.find(item => item.status === 'sakit')?.total || 0;
        
        charts.absensi.data.datasets[0].data = [hadir, tidakHadir, sakitIzin];
        charts.absensi.update();
    }

    // Update Nilai Rata-rata per Mapel
    if (charts.nilaiMapel && data.nilai_per_mapel) {
        const labels = data.nilai_per_mapel.map(item => item.nama_mapel);
        const values = data.nilai_per_mapel.map(item => parseFloat(item.rata_rata).toFixed(1));
        
        charts.nilaiMapel.data.labels = labels;
        charts.nilaiMapel.data.datasets[0].data = values;
        charts.nilaiMapel.update();
    }

    // Update Jadwal per Hari
    if (charts.jadwalHari && data.jadwal_per_hari) {
        const hariOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const jadwalData = hariOrder.map(hari => {
            const item = data.jadwal_per_hari.find(j => j.hari === hari);
            return item ? parseInt(item.total) : 0;
        });
        
        charts.jadwalHari.data.datasets[0].data = jadwalData;
        charts.jadwalHari.update();
    }
}

// Refresh analytics
function refreshAnalytics() {
    const refreshBtn = document.getElementById('refreshAnalyticsBtn');
    const icon = refreshBtn.querySelector('i');
    const btnText = refreshBtn.querySelector('.btn-text');
    
    // Add loading state
    refreshBtn.classList.add('loading');
    refreshBtn.disabled = true;
    btnText.textContent = 'Refreshing...';
    
    // Load analytics data
    loadAnalyticsData()
        .then(() => {
            // Show success state
            refreshBtn.classList.remove('loading');
            refreshBtn.classList.add('success');
            btnText.textContent = 'Refreshed!';
            
            // Remove success state after 2 seconds
            setTimeout(() => {
                refreshBtn.classList.remove('success');
                refreshBtn.disabled = false;
                btnText.textContent = 'Refresh';
            }, 2000);
        })
        .catch((error) => {
            console.error('Error refreshing analytics:', error);
            
            // Remove loading state on error
            refreshBtn.classList.remove('loading');
            refreshBtn.disabled = false;
            btnText.textContent = 'Refresh';
            
            // Show error state briefly
            refreshBtn.style.background = 'linear-gradient(135deg, #f44336 0%, #d32f2f 100%)';
            setTimeout(() => {
                refreshBtn.style.background = '';
            }, 2000);
        });
}

// Add smooth animations on page load
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.stats-card, .modern-card, .action-card');
    
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.6s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Initialize charts
    initializeCharts();
    
    // Load analytics data
    loadAnalyticsData();
});
</script>
<?= $this->endSection() ?> 