<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Detail Tugas</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/materitugas') ?>">E-Learning</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/materitugas/tugas') ?>">Tugas</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-tasks text-warning me-2"></i>
                                Detail Tugas
                            </h4>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/materitugas/tugas') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Mata Pelajaran:</strong></td>
                                    <td><span class="badge bg-warning"><?= esc($tugas['nama_mapel']) ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Guru:</strong></td>
                                    <td><?= esc($tugas['nama_guru']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Deadline:</strong></td>
                                    <td>
                                        <?php 
                                        $deadline = new DateTime($tugas['deadline']);
                                        $now = new DateTime();
                                        $isOverdue = $deadline < $now;
                                        ?>
                                        <span class="<?= $isOverdue ? 'text-danger' : 'text-success' ?>">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= $deadline->format('d/m/Y H:i') ?>
                                        </span>
                                        <?php if ($isOverdue): ?>
                                            <br><small class="text-danger">Deadline sudah lewat!</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Status:</strong></td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = $pengumpulan ? $pengumpulan['status'] : 'Belum dikumpulkan';
                                        
                                        if ($pengumpulan && $pengumpulan['status'] === 'Dikumpulkan') {
                                            $statusClass = 'bg-success';
                                        } elseif ($isOverdue) {
                                            $statusClass = 'bg-danger';
                                            $statusText = 'Terlambat';
                                        } else {
                                            $statusClass = 'bg-warning';
                                        }
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                    </td>
                                </tr>
                                <?php if ($pengumpulan && $pengumpulan['nilai'] !== null): ?>
                                <tr>
                                    <td><strong>Nilai:</strong></td>
                                    <td><span class="badge bg-info"><?= $pengumpulan['nilai'] ?></span></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td><strong>Waktu Upload:</strong></td>
                                    <td>
                                        <?php if ($pengumpulan): ?>
                                            <?= date('d/m/Y H:i', strtotime($pengumpulan['created_at'])) ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h5><i class="fas fa-file-alt text-primary me-2"></i>Deskripsi Tugas</h5>
                        <div class="p-3 bg-light rounded">
                            <?= nl2br(esc($tugas['deskripsi'])) ?>
                        </div>
                    </div>

                    <?php if ($tugas['file']): ?>
                    <div class="mb-4">
                        <h5><i class="fas fa-paperclip text-primary me-2"></i>Lampiran Tugas</h5>
                        <div class="p-3 bg-light rounded">
                            <a href="<?= base_url('siswa/materitugas/downloadTugas/' . $tugas['id']) ?>" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-download me-1"></i>
                                Download Lampiran
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($pengumpulan && $pengumpulan['catatan']): ?>
                    <div class="mb-4">
                        <h5><i class="fas fa-comment text-primary me-2"></i>Catatan Guru</h5>
                        <div class="p-3 bg-light rounded">
                            <?= nl2br(esc($pengumpulan['catatan'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Upload Tugas -->
            <?php if (!$pengumpulan || $pengumpulan['status'] !== 'Dikumpulkan'): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-upload text-success me-2"></i>
                        Upload Tugas
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($isOverdue): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Peringatan!</strong> Deadline tugas sudah lewat. Tugas tidak dapat dikumpulkan lagi.
                        </div>
                    <?php else: ?>
                        <form action="<?= base_url('siswa/materitugas/uploadTugas/' . $tugas['id']) ?>" 
                              method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label class="form-label">File Tugas <span class="text-danger">*</span></label>
                                <input type="file" name="file_tugas" class="form-control" required>
                                <small class="text-muted">
                                    Format: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR<br>
                                    Maksimal: 10MB
                                </small>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-upload me-1"></i>
                                Upload Tugas
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- File Tugas yang Sudah Diupload -->
            <?php if ($pengumpulan && $pengumpulan['file_tugas']): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file text-info me-2"></i>
                        File Tugas Anda
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center p-3 bg-light rounded">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">File Tugas</h6>
                            <small class="text-muted">
                                Upload: <?= date('d/m/Y H:i', strtotime($pengumpulan['created_at'])) ?>
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('uploads/tugas_siswa/' . $pengumpulan['file_tugas']) ?>" 
                               target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Informasi Penting -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Informasi Penting
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Pastikan file yang diupload sesuai dengan format yang diminta
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Ukuran file maksimal 10MB
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Upload sebelum deadline untuk menghindari keterlambatan
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Anda dapat mengupload ulang jika diperlukan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 