<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Modern Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Selamat Datang, <?= $guru['nama'] ?? $user['username'] ?>! 👋</h1>
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
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($isWaliKelas): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Notifikasi Absensi Siswa</h4>
                            <p class="header-subtitle">Terlambat/Alpha hari ini dan terbaru</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($notifikasi)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
                            <h5 class="empty-title">Tidak ada notifikasi</h5>
                            <p class="empty-subtitle">Belum ada siswa yang terlambat atau alpha</p>
                        </div>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($notifikasi as $n): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= esc($n['pesan']) ?></span>
                                <span class="badge bg-<?= $n['status'] == 'belum_dibaca' ? 'warning text-dark' : 'secondary' ?>"><?= ucfirst($n['status']) ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($isWaliKelas && !empty($rekap_terlambat)): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Ranking Siswa Paling Sering Terlambat</h4>
                            <p class="header-subtitle">Top 10 siswa di kelas Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Kelas</th>
                                    <th>Jumlah Terlambat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($rekap_terlambat, 0, 10) as $i => $r): ?>
                                <tr>
                                    <td><?= $i+1 ?></td>
                                    <td><?= esc($r['nama']) ?></td>
                                    <td><?= esc($r['nisn']) ?></td>
                                    <td><?= esc($r['kelas']) ?></td>
                                    <td><?= esc($r['jumlah_terlambat']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Modern Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card stats-card-primary">
                <div class="stats-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $guru['nip'] ?? 'N/A' ?></h3>
                    <p class="stats-label">NIP</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-id-card"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card stats-card-success">
                <div class="stats-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $guru['nama_mapel'] ?? 'N/A' ?></h3>
                    <p class="stats-label">Mata Pelajaran</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="stats-card stats-card-warning">
                <div class="stats-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= count($pengumuman) ?></h3>
                    <p class="stats-label">Pengumuman Aktif</p>
                </div>
                <div class="stats-bg">
                    <i class="fas fa-bullhorn"></i>
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
                            <p class="header-subtitle">Informasi penting dari admin sekolah</p>
                        </div>
                    </div>
                    <div class="header-action">
                        <a href="<?= base_url('guru/pengumuman') ?>" class="btn-modern btn-modern-primary">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($pengumuman)) : ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-bell-slash"></i>
                            </div>
                            <h5 class="empty-title">Belum ada pengumuman</h5>
                            <p class="empty-subtitle">Pengumuman dari admin akan muncul di sini</p>
                        </div>
                    <?php else : ?>
                        <div class="announcement-list">
                            <?php foreach (array_slice($pengumuman, 0, 5) as $p) : ?>
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
                                        <?php if ($p['file']) : ?>
                                            <a href="<?= base_url('guru/pengumuman/download/' . $p['id']) ?>" class="btn-modern btn-modern-sm btn-modern-outline">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer-modern">
                            <a href="<?= base_url('guru/pengumuman') ?>" class="btn-modern btn-modern-primary">
                                <i class="fas fa-bullhorn"></i>
                                Lihat Semua Pengumuman
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
                        <a href="<?= base_url('guru/pengumuman') ?>" class="action-card action-card-primary">
                            <div class="action-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Pengumuman</h5>
                                <p class="action-subtitle">Kelola pengumuman</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?= base_url('guru/pengumuman/jadwal-ujian') ?>" class="action-card action-card-danger">
                            <div class="action-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Jadwal</h5>
                                <p class="action-subtitle">Lihat jadwal ujian</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="action-card action-card-success" onclick="alert('Fitur dalam pengembangan')">
                            <div class="action-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Input Nilai</h5>
                                <p class="action-subtitle">Kelola nilai siswa</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        
                        <a href="<?= base_url('guru/absensi') ?>" class="action-card action-card-info">
                            <div class="action-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="action-content">
                                <h5 class="action-title">Absensi</h5>
                                <p class="action-subtitle">Kelola kehadiran</p>
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
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
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

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.stats-label {
    color: #6c757d;
    font-weight: 500;
    margin: 0;
}

.stats-bg {
    position: absolute;
    top: -20px;
    right: -20px;
    font-size: 8rem;
    opacity: 0.05;
    color: var(--primary-color);
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

.header-action .btn-modern {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.header-action .btn-modern:hover {
    background: #283593;
    transform: scale(1.1);
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
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

.action-card-danger {
    border-color: var(--danger-color);
}

.action-card-danger:hover {
    background: var(--danger-color);
    color: white;
}

.action-card-success {
    border-color: var(--success-color);
}

.action-card-success:hover {
    background: var(--success-color);
    color: white;
}

.action-card-info {
    border-color: var(--info-color);
}

.action-card-info:hover {
    background: var(--info-color);
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

.action-card-danger .action-icon {
    background: var(--danger-color);
    color: white;
}

.action-card-success .action-icon {
    background: var(--success-color);
    color: white;
}

.action-card-info .action-icon {
    background: var(--info-color);
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
updateTime(); // Update pertama kali

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
});
</script>
<?= $this->endSection() ?>