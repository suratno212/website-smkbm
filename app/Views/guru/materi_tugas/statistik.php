<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas') ?>">E-Learning</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Statistik</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Statistik E-Learning</h1>
                        <p class="welcome-subtitle">Analisis performa E-Learning Anda</p>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-primary">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $total_materi ?? 0 ?></h3>
                    <p class="stat-label">Total Materi</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $total_tugas ?? 0 ?></h3>
                    <p class="stat-label">Total Tugas</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-info">
                <div class="stat-icon">
                    <i class="fas fa-upload"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $total_pengumpulan ?? 0 ?></h3>
                    <p class="stat-label">Total Pengumpulan</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?= $dikumpulkan ?? 0 ?></h3>
                    <p class="stat-label">Sudah Dikumpulkan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Analisis -->
    <div class="row">
        <!-- Grafik Tugas per Bulan -->
        <div class="col-lg-8 mb-4">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Tugas per Bulan (<?= date('Y') ?>)</h4>
                            <p class="header-subtitle">Tren pembuatan tugas sepanjang tahun</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <canvas id="tugasChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Ringkasan Aktivitas -->
        <div class="col-lg-4 mb-4">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Ringkasan Aktivitas</h4>
                            <p class="header-subtitle">Statistik aktivitas E-Learning</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="activity-summary">
                        <div class="activity-item">
                            <div class="activity-icon bg-primary">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Materi Terupload</h6>
                                <p><?= $total_materi ?? 0 ?> materi</p>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-success">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Tugas Dibuat</h6>
                                <p><?= $total_tugas ?? 0 ?> tugas</p>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-info">
                                <i class="fas fa-upload"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Pengumpulan</h6>
                                <p><?= $total_pengumpulan ?? 0 ?> pengumpulan</p>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-warning">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Tingkat Pengumpulan</h6>
                                <p>
                                    <?php 
                                    $rate = ($total_pengumpulan > 0 && $dikumpulkan > 0) 
                                        ? round(($dikumpulkan / $total_pengumpulan) * 100, 1) 
                                        : 0;
                                    echo $rate . '%';
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips dan Rekomendasi -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Tips & Rekomendasi</h4>
                            <p class="header-subtitle">Saran untuk meningkatkan E-Learning</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-arrow-up text-success"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Meningkatkan Engagement</h6>
                                    <p>Upload materi yang interaktif dan menarik untuk meningkatkan partisipasi siswa</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Manajemen Deadline</h6>
                                    <p>Berikan deadline yang realistis dan konsisten untuk tugas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-comments text-info"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Feedback Berkala</h6>
                                    <p>Berikan feedback yang konstruktif untuk setiap pengumpulan tugas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-chart-line text-primary"></i>
                                </div>
                                <div class="tip-content">
                                    <h6>Monitor Progress</h6>
                                    <p>Pantau statistik secara berkala untuk mengoptimalkan pembelajaran</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}

.welcome-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
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
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card-primary { border-left: 4px solid #007bff; }
.stat-card-success { border-left: 4px solid #28a745; }
.stat-card-info { border-left: 4px solid #17a2b8; }
.stat-card-warning { border-left: 4px solid #ffc107; }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
}

.stat-card-primary .stat-icon { background: #e3f2fd; color: #007bff; }
.stat-card-success .stat-icon { background: #e8f5e8; color: #28a745; }
.stat-card-info .stat-icon { background: #e1f5fe; color: #17a2b8; }
.stat-card-warning .stat-icon { background: #fff8e1; color: #ffc107; }

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-label {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.9rem;
}

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

.activity-summary {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.activity-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.activity-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
    color: #495057;
}

.activity-content p {
    margin-bottom: 0;
    color: #6c757d;
    font-size: 1.1rem;
    font-weight: 600;
}

.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.tip-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.tip-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.tip-content h6 {
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #495057;
}

.tip-content p {
    margin-bottom: 0;
    color: #6c757d;
    font-size: 0.9rem;
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

@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
    
    .card-body-modern {
        padding: 1rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk grafik
    const tugasData = <?= json_encode($tugas_by_month ?? []) ?>;
    
    // Siapkan data untuk Chart.js
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const data = new Array(12).fill(0);
    
    tugasData.forEach(item => {
        const monthIndex = parseInt(item.bulan) - 1;
        data[monthIndex] = parseInt(item.total);
    });
    
    // Buat grafik
    const ctx = document.getElementById('tugasChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Tugas',
                data: data,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?> 