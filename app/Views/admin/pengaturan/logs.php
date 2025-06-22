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
                        <li class="breadcrumb-item active">Log Sistem</li>
                    </ol>
                </div>
                <h4 class="page-title">Log Sistem</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar File Log</h4>
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

                    <?php if (empty($logs)) : ?>
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada file log</h5>
                            <p class="text-muted">File log akan muncul di sini setelah aplikasi berjalan</p>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama File</th>
                                        <th>Ukuran</th>
                                        <th>Terakhir Diubah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $index => $log) : ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <i class="fas fa-file-alt text-primary"></i>
                                                <?= $log['filename'] ?>
                                            </td>
                                            <td><?= number_format($log['size'] / 1024, 2) ?> KB</td>
                                            <td><?= $log['modified'] ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/pengaturan/view-log/' . $log['filename']) ?>" 
                                                   class="btn btn-sm btn-info" title="Lihat Log">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/pengaturan/clear-log/' . $log['filename']) ?>" 
                                                   class="btn btn-sm btn-warning" title="Bersihkan Log"
                                                   onclick="return confirm('Apakah Anda yakin ingin membersihkan log ini?')">
                                                    <i class="fas fa-broom"></i>
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

    <!-- Informasi Log -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Log</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Tentang Log Sistem</h6>
                                <ul class="mb-0">
                                    <li>Log sistem mencatat aktivitas aplikasi</li>
                                    <li>File log disimpan di folder writable/logs/</li>
                                    <li>Format nama: log-YYYY-MM-DD.log</li>
                                    <li>Log berisi error, warning, dan info aplikasi</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle"></i> Peringatan</h6>
                                <ul class="mb-0">
                                    <li>Jangan hapus file log secara manual</li>
                                    <li>Gunakan fitur "Bersihkan Log" untuk membersihkan</li>
                                    <li>Log yang dibersihkan tidak dapat dikembalikan</li>
                                    <li>Backup log penting sebelum dibersihkan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 