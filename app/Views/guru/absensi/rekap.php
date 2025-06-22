<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Modern Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Rekap Absensi Siswa</h1>
                        <p class="welcome-subtitle">Laporan kehadiran siswa per periode</p>
                        <div class="welcome-meta">
                            <span class="meta-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <?= $guru['nama'] ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <?= date('F Y', strtotime($selected_bulan . '-01')) ?>
                            </span>
                        </div>
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

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-filter"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Filter Rekap</h4>
                            <p class="header-subtitle">Pilih kelas dan periode</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <form action="<?= base_url('guru/absensi/rekap') ?>" method="get" class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas_diampu as $k) : ?>
                                    <option value="<?= $k['id'] ?>" <?= $selected_kelas == $k['id'] ? 'selected' : '' ?>>
                                        <?= $k['nama_kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="bulan" class="form-label">Periode</label>
                            <input type="month" name="bulan" id="bulan" class="form-control" value="<?= $selected_bulan ?>" required>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn-modern btn-modern-primary">
                                <i class="fas fa-search"></i> Tampilkan Rekap
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($rekap_absensi)) : ?>
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card stats-card-success">
                    <div class="stats-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">
                            <?= array_sum(array_column($rekap_absensi, 'hadir')) ?>
                        </h3>
                        <p class="stats-label">Total Hadir</p>
                    </div>
                    <div class="stats-bg">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card stats-card-warning">
                    <div class="stats-icon">
                        <i class="fas fa-thermometer-half"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">
                            <?= array_sum(array_column($rekap_absensi, 'sakit')) ?>
                        </h3>
                        <p class="stats-label">Total Sakit</p>
                    </div>
                    <div class="stats-bg">
                        <i class="fas fa-thermometer-half"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card stats-card-info">
                    <div class="stats-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">
                            <?= array_sum(array_column($rekap_absensi, 'izin')) ?>
                        </h3>
                        <p class="stats-label">Total Izin</p>
                    </div>
                    <div class="stats-bg">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card stats-card-danger">
                    <div class="stats-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">
                            <?= array_sum(array_column($rekap_absensi, 'alpha')) ?>
                        </h3>
                        <p class="stats-label">Total Alpha</p>
                    </div>
                    <div class="stats-bg">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekap Table -->
        <div class="row">
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header-modern">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="header-text">
                                <h4 class="header-title">Detail Rekap Absensi</h4>
                                <p class="header-subtitle">Per siswa periode <?= date('F Y', strtotime($selected_bulan . '-01')) ?></p>
                            </div>
                        </div>
                        <div class="header-action">
                            <button onclick="exportToExcel()" class="btn-modern btn-modern-outline">
                                <i class="fas fa-download"></i> Export Excel
                            </button>
                        </div>
                    </div>
                    <div class="card-body-modern">
                        <div class="table-responsive">
                            <table class="table table-hover" id="rekapTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Hadir</th>
                                        <th>Sakit</th>
                                        <th>Izin</th>
                                        <th>Alpha</th>
                                        <th>Total</th>
                                        <th>Persentase</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rekap_absensi as $index => $rekap) : ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><strong><?= $rekap['siswa']['nisn'] ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <strong><?= $rekap['siswa']['nama'] ?></strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success"><?= $rekap['hadir'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark"><?= $rekap['sakit'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= $rekap['izin'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger"><?= $rekap['alpha'] ?></span>
                                            </td>
                                            <td>
                                                <strong><?= $rekap['total'] ?></strong>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" 
                                                         style="width: <?= $rekap['persentase'] ?>%">
                                                        <?= $rekap['persentase'] ?>%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($rekap['persentase'] >= 90) : ?>
                                                    <span class="badge bg-success">Sangat Baik</span>
                                                <?php elseif ($rekap['persentase'] >= 80) : ?>
                                                    <span class="badge bg-primary">Baik</span>
                                                <?php elseif ($rekap['persentase'] >= 70) : ?>
                                                    <span class="badge bg-warning text-dark">Cukup</span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">Kurang</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($selected_kelas) : ?>
        <!-- Empty State -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="modern-card">
                    <div class="card-body-modern text-center">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="empty-title">Belum ada data absensi</h5>
                            <p class="empty-subtitle">Tidak ada data absensi untuk periode yang dipilih</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
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
    font-size: 2rem;
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
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
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

.stats-card-success {
    border-left: 4px solid var(--success-color);
}

.stats-card-warning {
    border-left: 4px solid var(--warning-color);
}

.stats-card-info {
    border-left: 4px solid var(--info-color);
}

.stats-card-danger {
    border-left: 4px solid var(--danger-color);
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

.stats-card-success .stats-icon {
    background: linear-gradient(135deg, var(--success-color), #20c997);
    color: white;
}

.stats-card-warning .stats-icon {
    background: linear-gradient(135deg, var(--warning-color), #fd7e14);
    color: white;
}

.stats-card-info .stats-icon {
    background: linear-gradient(135deg, var(--info-color), #3498db);
    color: white;
}

.stats-card-danger .stats-icon {
    background: linear-gradient(135deg, var(--danger-color), #e74c3c);
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
    margin-bottom: 2rem;
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
    width: 40px;
    height: 40px;
    background: var(--primary-color);
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
    color: var(--dark-color);
}

.header-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.card-body-modern {
    padding: 1.5rem;
}

/* Table Styles */
.table {
    margin-bottom: 0;
}

.table thead th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.avatar-sm {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Progress Bar */
.progress {
    border-radius: 10px;
    background-color: #e9ecef;
}

.progress-bar {
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
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

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .welcome-meta {
        justify-content: center;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
// Export to Excel function
function exportToExcel() {
    const table = document.getElementById('rekapTable');
    const html = table.outerHTML;
    const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    const downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    downloadLink.href = url;
    downloadLink.download = 'rekap_absensi_<?= $selected_bulan ?>.xls';
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Add smooth animations on page load
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.stats-card, .modern-card');
    
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