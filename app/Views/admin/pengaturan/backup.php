<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/pengaturan') ?>">Pengaturan</a></li>
                        <li class="breadcrumb-item active">Backup Database</li>
                    </ol>
                </div>
                <h4 class="page-title">Backup Database</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Buat Backup Database</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle"></i> Informasi Backup</h5>
                                <ul class="mb-0">
                                    <li>Backup akan menyimpan seluruh data database</li>
                                    <li>File backup akan disimpan dalam format .sql</li>
                                    <li>Nama file: backup_YYYY-MM-DD_HH-MM-SS.sql</li>
                                    <li>Pastikan server memiliki ruang penyimpanan yang cukup</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <a href="<?= base_url('admin/pengaturan/create-backup') ?>" 
                                   class="btn btn-primary btn-lg" 
                                   onclick="return confirm('Apakah Anda yakin ingin membuat backup database?')">
                                    <i class="fas fa-download"></i> Buat Backup Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Riwayat Backup</h4>
                </div>
                <div class="card-body">
                    <?php
                    $backupPath = ROOTPATH . 'backups/';
                    $backups = [];
                    
                    if (is_dir($backupPath)) {
                        $files = scandir($backupPath);
                        foreach ($files as $file) {
                            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                                $filepath = $backupPath . $file;
                                $backups[] = [
                                    'filename' => $file,
                                    'size' => filesize($filepath),
                                    'modified' => date('Y-m-d H:i:s', filemtime($filepath))
                                ];
                            }
                        }
                    }
                    
                    // Sort by modified date (newest first)
                    usort($backups, function($a, $b) {
                        return strtotime($b['modified']) - strtotime($a['modified']);
                    });
                    ?>

                    <?php if (empty($backups)) : ?>
                        <div class="text-center py-4">
                            <i class="fas fa-database fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada file backup</h5>
                            <p class="text-muted">Buat backup pertama untuk melihat riwayat di sini</p>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama File</th>
                                        <th>Ukuran</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($backups as $index => $backup) : ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <i class="fas fa-file-archive text-primary"></i>
                                                <?= $backup['filename'] ?>
                                            </td>
                                            <td><?= number_format($backup['size'] / 1024, 2) ?> KB</td>
                                            <td><?= $backup['modified'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/pengaturan/download-backup/' . $backup['filename']) ?>" 
                                                   class="btn btn-sm btn-success" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <a href="<?= base_url('admin/pengaturan/delete-backup/' . $backup['filename']) ?>" 
                                                   class="btn btn-sm btn-danger" title="Hapus"
                                                   onclick="return confirm('Apakah Anda yakin ingin menghapus file backup ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
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

    <!-- Informasi Database -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Database</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>Nama Database:</strong></td>
                                    <td><?= \Config\Database::connect()->database ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Host:</strong></td>
                                    <td><?= \Config\Database::connect()->hostname ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Port:</strong></td>
                                    <td><?= \Config\Database::connect()->port ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Username:</strong></td>
                                    <td><?= \Config\Database::connect()->username ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="200"><strong>Driver:</strong></td>
                                    <td><?= \Config\Database::connect()->DBDriver ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Charset:</strong></td>
                                    <td><?= \Config\Database::connect()->charset ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Timezone:</strong></td>
                                    <td><?= \Config\Database::connect()->timezone ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><span class="badge bg-success">Connected</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh page after backup creation
    <?php if (session()->getFlashdata('message')) : ?>
        setTimeout(function() {
            location.reload();
        }, 2000);
    <?php endif; ?>
});
</script>
<?= $this->endSection() ?> 