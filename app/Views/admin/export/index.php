<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Export Data 📊</h1>
                        <p class="welcome-subtitle">Export data sekolah dalam format Excel atau PDF</p>
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
                            <i class="fas fa-file-export"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="row">
        <!-- Data Siswa -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="export-card">
                <div class="export-header">
                    <div class="export-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="export-info">
                        <h4>Data Siswa</h4>
                        <p>Export data lengkap siswa termasuk NIS, nama, kelas, dan jurusan</p>
                    </div>
                </div>
                <div class="export-actions">
                    <a href="<?= base_url('admin/export/siswa/excel') ?>" class="btn-export btn-excel">
                        <i class="fas fa-file-excel"></i>
                        Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Data Guru -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="export-card">
                <div class="export-header">
                    <div class="export-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="export-info">
                        <h4>Data Guru</h4>
                        <p>Export data lengkap guru termasuk mata pelajaran yang diampu</p>
                    </div>
                </div>
                <div class="export-actions">
                    <a href="<?= base_url('admin/export/guru/excel') ?>" class="btn-export btn-excel">
                        <i class="fas fa-file-excel"></i>
                        Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Jadwal Pelajaran -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="export-card">
                <div class="export-header">
                    <div class="export-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="export-info">
                        <h4>Jadwal Pelajaran</h4>
                        <p>Export jadwal pelajaran lengkap dengan guru dan ruangan</p>
                    </div>
                </div>
                <div class="export-actions">
                    <a href="<?= base_url('admin/export/jadwal/excel') ?>" class="btn-export btn-excel">
                        <i class="fas fa-file-excel"></i>
                        Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Rekap Absensi -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="export-card">
                <div class="export-header">
                    <div class="export-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="export-info">
                        <h4>Rekap Absensi</h4>
                        <p>Export rekap absensi siswa per tanggal tertentu</p>
                    </div>
                </div>
                <div class="export-actions">
                    <a href="<?= base_url('admin/export/absensi/excel') ?>" class="btn-export btn-excel">
                        <i class="fas fa-file-excel"></i>
                        Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Data Nilai -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="export-card">
                <div class="export-header">
                    <div class="export-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="export-info">
                        <h4>Data Nilai</h4>
                        <p>Export data nilai siswa termasuk UTS, UAS, dan tugas</p>
                    </div>
                </div>
                <div class="export-actions">
                    <a href="<?= base_url('admin/export/nilai/excel') ?>" class="btn-export btn-excel">
                        <i class="fas fa-file-excel"></i>
                        Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Export Semua Data -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="export-card export-card-special">
                <div class="export-header">
                    <div class="export-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <div class="export-info">
                        <h4>Export Semua Data</h4>
                        <p>Download semua data dalam satu file ZIP</p>
                    </div>
                </div>
                <div class="export-actions">
                    <a href="<?= base_url('admin/export/all') ?>" class="btn-export btn-special">
                        <i class="fas fa-file-archive"></i>
                        Download ZIP
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Export History -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Riwayat Export</h4>
                            <p class="header-subtitle">Data export terakhir</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="export-history">
                        <div class="history-item">
                            <div class="history-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div class="history-content">
                                <h6>Data Siswa</h6>
                                <p>Export terakhir: <?= date('d/m/Y H:i') ?></p>
                            </div>
                            <div class="history-status">
                                <span class="badge-success">Berhasil</span>
                            </div>
                        </div>
                        <div class="history-item">
                            <div class="history-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="history-content">
                                <h6>Jadwal Pelajaran</h6>
                                <p>Export terakhir: <?= date('d/m/Y H:i', strtotime('-1 day')) ?></p>
                            </div>
                            <div class="history-status">
                                <span class="badge-success">Berhasil</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Export Styles */
    .export-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        height: 100%;
    }

    .export-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .export-card-special {
        background: linear-gradient(135deg, #1a237e, #283593);
        color: white;
    }

    .export-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .export-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #1a237e, #283593);
        color: white;
        flex-shrink: 0;
    }

    .export-card-special .export-icon {
        background: rgba(255, 255, 255, 0.2);
    }

    .export-info h4 {
        margin: 0 0 0.5rem 0;
        font-weight: 600;
    }

    .export-info p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .export-card-special .export-info p {
        color: rgba(255, 255, 255, 0.8);
    }

    .export-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-export {
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
        font-size: 0.9rem;
    }

    .btn-excel {
        background: #217346;
        color: white;
    }

    .btn-excel:hover {
        background: #1e6b3d;
        color: white;
        transform: translateY(-2px);
    }

    .btn-pdf {
        background: #dc3545;
        color: white;
    }

    .btn-pdf:hover {
        background: #c82333;
        color: white;
        transform: translateY(-2px);
    }

    .btn-special {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-special:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    /* Export History */
    .export-history {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .history-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .history-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .history-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: #1a237e;
        color: white;
    }

    .history-content {
        flex: 1;
    }

    .history-content h6 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }

    .history-content p {
        margin: 0;
        color: #666;
        font-size: 0.8rem;
    }

    .history-status .badge-success {
        background: #28a745;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 15px;
        font-size: 0.8rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .export-header {
            flex-direction: column;
            text-align: center;
        }

        .export-actions {
            justify-content: center;
        }

        .history-item {
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

    // Add smooth animations on page load
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.export-card, .modern-card');

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