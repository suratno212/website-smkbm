<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Modern Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Input Absensi Siswa</h1>
                        <p class="welcome-subtitle">
                            Kelas: <strong><?= $selected_kelas ? $kelas_diampu[array_search($selected_kelas, array_column($kelas_diampu, 'id'))]['nama_kelas'] : 'Pilih Kelas' ?></strong> | 
                            Tanggal: <strong><?= date('d/m/Y', strtotime($selected_tanggal)) ?></strong>
                        </p>
                        <div class="welcome-meta">
                            <span class="meta-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <?= $guru['nama'] ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-book"></i>
                                <?= $mapel_diajar['nama_mapel'] ?? 'N/A' ?>
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

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($siswa_list)) : ?>
        <!-- Empty State -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="modern-card">
                    <div class="card-body-modern text-center">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <h5 class="empty-title">Belum ada siswa</h5>
                            <p class="empty-subtitle">Silakan pilih kelas terlebih dahulu</p>
                            <a href="<?= base_url('guru/absensi') ?>" class="btn-modern btn-modern-primary">
                                <i class="fas fa-arrow-left"></i>
                                Kembali ke Pilihan Kelas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <!-- Absensi Form -->
        <div class="row">
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header-modern">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="fas fa-list-check"></i>
                            </div>
                            <div class="header-text">
                                <h4 class="header-title">Daftar Siswa</h4>
                                <p class="header-subtitle">Pilih status kehadiran untuk setiap siswa</p>
                            </div>
                        </div>
                        <div class="header-action">
                            <span class="badge bg-primary fs-6"><?= count($siswa_list) ?> Siswa</span>
                        </div>
                    </div>
                    <div class="card-body-modern">
                        <form action="<?= base_url('guru/absensi/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="tanggal" value="<?= $selected_tanggal ?>">
                            <input type="hidden" name="kelas_id" value="<?= $selected_kelas ?>">
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">NIS</th>
                                            <th width="30%">Nama Siswa</th>
                                            <th width="20%">Status</th>
                                            <th width="30%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($siswa_list as $index => $siswa) : ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <strong><?= $siswa['nis'] ?></strong>
                                                    <input type="hidden" name="siswa_id[]" value="<?= $siswa['id'] ?>">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-3">
                                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong><?= $siswa['nama'] ?></strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="status[]" class="form-select status-select" data-siswa="<?= $siswa['id'] ?>">
                                                        <option value="Hadir" <?= ($siswa['absensi_status'] == 'Hadir') ? 'selected' : '' ?>>Hadir</option>
                                                        <option value="Sakit" <?= ($siswa['absensi_status'] == 'Sakit') ? 'selected' : '' ?>>Sakit</option>
                                                        <option value="Izin" <?= ($siswa['absensi_status'] == 'Izin') ? 'selected' : '' ?>>Izin</option>
                                                        <option value="Alpha" <?= ($siswa['absensi_status'] == 'Alpha') ? 'selected' : '' ?>>Alpha</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-<?= strtolower($siswa['absensi_status'] ?: 'hadir') ?>">
                                                        <?= $siswa['absensi_status'] ?: 'Belum diisi' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="<?= base_url('guru/absensi') ?>" class="btn-modern btn-modern-outline">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                                <button type="submit" class="btn-modern btn-modern-primary">
                                    <i class="fas fa-save"></i>
                                    Simpan Absensi
                                </button>
                            </div>
                        </form>
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

/* Status Badge */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-hadir {
    background: var(--success-color);
    color: white;
}

.status-sakit {
    background: var(--warning-color);
    color: #212529;
}

.status-izin {
    background: var(--info-color);
    color: white;
}

.status-alpha {
    background: var(--danger-color);
    color: white;
}

/* Form Controls */
.form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.25);
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
// Update status badge when dropdown changes
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const siswaId = this.getAttribute('data-siswa');
            const status = this.value;
            const row = this.closest('tr');
            const badge = row.querySelector('.status-badge');
            
            // Update badge
            badge.className = `status-badge status-${status.toLowerCase()}`;
            badge.textContent = status;
        });
    });
});
</script>
<?= $this->endSection() ?> 