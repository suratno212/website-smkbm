<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </div>
                <h4 class="page-title">Pengaturan Sistem</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-cog fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Profil Admin</h5>
                                    <p class="card-text">Kelola profil admin dan informasi akun</p>
                                    <a href="<?= base_url('admin/pengaturan/profil') ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-cogs fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Pengaturan Umum</h5>
                                    <p class="card-text">Konfigurasi informasi sekolah dan sistem</p>
                                    <a href="<?= base_url('admin/pengaturan/umum') ?>" class="btn btn-success">
                                        <i class="fas fa-cog"></i> Pengaturan
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="fas fa-database fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Backup Database</h5>
                                    <p class="card-text">Backup dan restore database sistem</p>
                                    <a href="<?= base_url('admin/pengaturan/backup') ?>" class="btn btn-info">
                                        <i class="fas fa-download"></i> Backup
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Log Sistem</h5>
                                    <p class="card-text">Lihat dan kelola log sistem</p>
                                    <a href="<?= base_url('admin/pengaturan/logs') ?>" class="btn btn-warning">
                                        <i class="fas fa-list"></i> Lihat Log
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-danger">
                                <div class="card-body text-center">
                                    <i class="fas fa-shield-alt fa-3x text-danger mb-3"></i>
                                    <h5 class="card-title">Keamanan</h5>
                                    <p class="card-text">Pengaturan keamanan sistem</p>
                                    <a href="#" class="btn btn-danger" onclick="alert('Fitur dalam pengembangan')">
                                        <i class="fas fa-lock"></i> Keamanan
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-secondary">
                                <div class="card-body text-center">
                                    <i class="fas fa-tools fa-3x text-secondary mb-3"></i>
                                    <h5 class="card-title">Maintenance</h5>
                                    <p class="card-text">Mode maintenance sistem</p>
                                    <a href="#" class="btn btn-secondary" onclick="alert('Fitur dalam pengembangan')">
                                        <i class="fas fa-wrench"></i> Maintenance
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Sistem -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Sistem</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>Nama Sekolah:</strong></td>
                                    <td><?= $pengaturan['nama_sekolah'] ?? 'SMK Bhakti Mulya BNS' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td><?= $pengaturan['alamat_sekolah'] ?? 'Jl. Contoh No. 123, Jakarta' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Telepon:</strong></td>
                                    <td><?= $pengaturan['telepon_sekolah'] ?? '(021) 1234567' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td><?= $pengaturan['email_sekolah'] ?? 'info@smkbm.sch.id' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>Tahun Akademik:</strong></td>
                                    <td><?= $pengaturan['tahun_akademik_aktif'] ?? '2024/2025' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester:</strong></td>
                                    <td><?= $pengaturan['semester_aktif'] ?? 'Ganjil' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kepala Sekolah:</strong></td>
                                    <td><?= $pengaturan['kepala_sekolah'] ?? 'Drs. Kepala Sekolah' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Versi Sistem:</strong></td>
                                    <td>v1.0.0</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 