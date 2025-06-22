<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Daftar Pertemuan</h1>
                        <p class="welcome-subtitle">Kelola pertemuan untuk setiap kelas</p>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10 mb-4">
            <div class="modern-card">
                <div class="card-header-modern d-flex justify-content-between align-items-center">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Pertemuan</h4>
                            <p class="header-subtitle">List pertemuan per kelas</p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('guru/pertemuan/create') ?>" class="btn-modern btn-modern-primary btn-modern-sm"><i class="fas fa-plus"></i> Tambah Pertemuan</a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($pertemuan)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-calendar-times"></i></div>
                            <h5 class="empty-title">Belum ada pertemuan</h5>
                            <p class="empty-subtitle">Silakan tambah pertemuan terlebih dahulu</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Pertemuan</th>
                                        <th>Tanggal</th>
                                        <th>Topik</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pertemuan as $p): ?>
                                    <tr>
                                        <td><?= esc($p['kelas_id']) ?></td>
                                        <td><?= esc($p['nama_pertemuan']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                                        <td><?= esc($p['topik']) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('guru/pertemuan/edit/'.$p['id']) ?>" class="btn-modern btn-modern-outline btn-modern-sm"><i class="fas fa-edit"></i></a>
                                            <a href="<?= base_url('guru/pertemuan/delete/'.$p['id']) ?>" class="btn-modern btn-modern-outline btn-modern-sm btn-danger" onclick="return confirm('Hapus pertemuan ini?')"><i class="fas fa-trash"></i></a>
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
.btn-modern { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border: none; cursor: pointer; }
.btn-modern-primary { background: var(--primary-color); color: white; }
.btn-modern-primary:hover { background: #283593; color: white; transform: translateY(-2px); }
.btn-modern-outline { background: transparent; color: var(--primary-color); border: 2px solid var(--primary-color); }
.btn-modern-outline:hover { background: var(--primary-color); color: white; }
.btn-modern-sm { padding: 0.5rem 1rem; font-size: 0.9rem; }
.empty-state { text-align: center; padding: 2.5rem 1rem; }
.empty-icon { width: 60px; height: 60px; background: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem; color: #6c757d; }
.empty-title { color: #6c757d; margin-bottom: 0.5rem; }
.empty-subtitle { color: #adb5bd; margin: 0; }
@media (max-width: 991px) { .row.g-4 > [class^='col-'] { margin-bottom: 2rem; } }
@media (max-width: 768px) { .welcome-content { flex-direction: column; text-align: center; gap: 1rem; } .welcome-title { font-size: 1.5rem; } }
</style>
<?= $this->endSection() ?> 