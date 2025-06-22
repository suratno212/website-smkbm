<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Absensi Siswa</h1>
                        <p class="welcome-subtitle">Silakan pilih kelas dan tanggal untuk mengisi absensi</p>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-filter"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Filter Absensi</h4>
                            <p class="header-subtitle">Pilih kelas dan tanggal absensi</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <form action="<?= base_url('guru/absensi/input') ?>" method="get" class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas_diampu as $k) : ?>
                                    <option value="<?= $k['id'] ?>"><?= $k['nama_kelas'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" class="btn-modern btn-modern-primary">
                                <i class="fas fa-arrow-right"></i> Input Absensi
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer-modern">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div><strong>Guru:</strong> <?= $guru['nama'] ?></div>
                        <div><strong>Mapel:</strong> <?= $mapel_diajar['nama_mapel'] ?? '-' ?></div>
                        <div class="ms-auto">
                            <a href="<?= base_url('guru/absensi/rekap') ?>" class="btn-modern btn-modern-outline">
                                <i class="fas fa-chart-bar"></i> Lihat Rekap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern style, reuse from dashboard */
.welcome-header { background: linear-gradient(135deg, var(--primary-color) 0%, #283593 100%); border-radius: var(--border-radius); padding: 2rem; color: white; position: relative; overflow: hidden; box-shadow: var(--shadow); }
.welcome-content { display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1; }
.welcome-title { font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; background: linear-gradient(45deg, #fff, #F7D117); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.welcome-subtitle { font-size: 1.1rem; opacity: 0.9; margin-bottom: 1rem; }
.floating-card { width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; animation: float 3s ease-in-out infinite; }
@keyframes float { 0%,100%{transform:translateY(0px);} 50%{transform:translateY(-10px);} }
.modern-card { background: white; border-radius: var(--border-radius); box-shadow: var(--shadow); overflow: hidden; transition: all 0.3s ease; margin-bottom: 2rem; }
.card-header-modern { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1.5rem; border-bottom: 1px solid #dee2e6; display: flex; align-items: center; justify-content: space-between; }
.header-content { display: flex; align-items: center; gap: 1rem; }
.header-icon { width: 40px; height: 40px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1rem; }
.header-title { font-size: 1.1rem; font-weight: 600; margin: 0; color: var(--dark-color); }
.header-subtitle { color: #6c757d; margin: 0; font-size: 0.9rem; }
.card-body-modern { padding: 1.5rem; }
.card-footer-modern { padding: 1rem 1.5rem; border-top: 1px solid #dee2e6; background: #f8f9fa; font-size: 1rem; }
.btn-modern { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border: none; cursor: pointer; }
.btn-modern-primary { background: var(--primary-color); color: white; }
.btn-modern-primary:hover { background: #283593; color: white; transform: translateY(-2px); }
@media (max-width: 768px) { .welcome-content { flex-direction: column; text-align: center; gap: 1rem; } .welcome-title { font-size: 1.5rem; } }
</style>
<?= $this->endSection() ?> 