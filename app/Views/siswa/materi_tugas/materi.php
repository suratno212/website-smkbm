<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Materi Pembelajaran</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/materitugas') ?>">E-Learning</a></li>
                        <li class="breadcrumb-item active">Materi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-book text-primary me-2"></i>
                                Daftar Materi Pembelajaran
                            </h4>
                            <p class="text-muted mb-0">Kelas: <?= esc($siswa['nama_kelas'] ?? 'Tidak diketahui') ?></p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/materitugas') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($materi)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">Belum ada materi pembelajaran</h5>
                            <p class="text-muted">Materi akan muncul di sini setelah guru mengupload materi untuk kelas Anda.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($materi as $m): ?>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-sm rounded-circle bg-primary align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="fas fa-book font-size-18"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="card-title mb-1"><?= esc($m['judul']) ?></h6>
                                                <span class="badge bg-info"><?= esc($m['nama_mapel']) ?></span>
                                            </div>
                                        </div>
                                        
                                        <p class="card-text text-muted mb-3">
                                            <?= esc($m['deskripsi']) ?>
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>
                                                <?= esc($m['nama_guru']) ?>
                                            </small>
                                            <?php if ($m['file']): ?>
                                                <a href="<?= base_url('siswa/materitugas/downloadMateri/' . $m['id']) ?>" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download me-1"></i>
                                                    Download
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak ada file</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 