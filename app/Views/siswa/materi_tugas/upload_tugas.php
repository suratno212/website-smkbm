<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Upload Tugas</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/materitugas') ?>">E-Learning</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/materitugas/tugas') ?>">Tugas</a></li>
                        <li class="breadcrumb-item active">Upload</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-upload text-success me-2"></i>
                                Upload Tugas
                            </h4>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/materitugas/detailTugas/' . $tugas['kd_tugas']) ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informasi Tugas -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Tugas
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Mata Pelajaran:</strong> <?= esc($tugas['nama_mapel']) ?><br>
                                <strong>Guru:</strong> <?= esc($tugas['nama_guru']) ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Deadline:</strong>
                                <?php
                                $deadline = new DateTime($tugas['deadline']);
                                $now = new DateTime();
                                $isOverdue = $deadline < $now;
                                ?>
                                <span class="<?= $isOverdue ? 'text-danger' : 'text-success' ?>">
                                    <?= $deadline->format('d/m/Y H:i') ?>
                                </span>
                                <?php if ($isOverdue): ?>
                                    <br><small class="text-danger">Deadline sudah lewat!</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Tugas -->
                    <div class="mb-4">
                        <h5><i class="fas fa-file-alt text-primary me-2"></i>Deskripsi Tugas</h5>
                        <div class="p-3 bg-light rounded">
                            <?= nl2br(esc($tugas['deskripsi'])) ?>
                        </div>
                    </div>

                    <?php if ($tugas['file']): ?>
                        <!-- Lampiran Tugas -->
                        <div class="mb-4">
                            <h5><i class="fas fa-paperclip text-primary me-2"></i>Lampiran Tugas</h5>
                            <div class="p-3 bg-light rounded">
                                <a href="<?= base_url('siswa/materitugas/downloadTugas/' . $tugas['kd_tugas']) ?>"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>
                                    Download Lampiran
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <hr>

                    <?php if ($isOverdue): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Peringatan!</strong> Deadline tugas sudah lewat. Tugas tidak dapat dikumpulkan lagi.
                        </div>
                    <?php else: ?>
                        <!-- Form Upload -->
                        <form action="<?= base_url('siswa/materitugas/uploadTugas/' . $tugas['kd_tugas']) ?>"
                            method="post" enctype="multipart/form-data" id="uploadForm">
                            <?= csrf_field() ?>

                            <!-- Debug info -->
                            <?php if (session('errors')): ?>
                                <div class="alert alert-danger">
                                    <h6>Validation Errors:</h6>
                                    <ul>
                                        <?php foreach (session('errors') as $error): ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if (session('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session('error') ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">File Tugas <span class="text-danger">*</span></label>
                                <input type="file" name="file_tugas" class="form-control" id="fileInput" required>
                                <div class="form-text">
                                    <strong>Format yang diizinkan:</strong> PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR<br>
                                    <strong>Ukuran maksimal:</strong> 10MB
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="catatan" class="form-control" rows="3"
                                    placeholder="Tambahkan catatan atau keterangan tambahan untuk tugas Anda..."></textarea>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Perhatian!</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Pastikan file yang diupload sesuai dengan format yang diminta</li>
                                    <li>Ukuran file tidak boleh melebihi 10MB</li>
                                    <li>File yang sudah diupload tidak dapat diubah setelah dikumpulkan</li>
                                    <li>Upload sebelum deadline untuk menghindari keterlambatan</li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                    <i class="fas fa-upload me-2"></i>
                                    Upload Tugas
                                </button>
                                <a href="<?= base_url('siswa/materitugas/detailTugas/' . $tugas['kd_tugas']) ?>"
                                    class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Batal
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const submitBtn = document.getElementById('submitBtn');
        const uploadForm = document.getElementById('uploadForm');

        // Validasi file saat dipilih
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validasi ukuran file (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 10MB.');
                    this.value = '';
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'zip', 'rar'];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (!allowedTypes.includes(fileExtension)) {
                    alert('Tipe file tidak diizinkan! Format yang diizinkan: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR');
                    this.value = '';
                    return;
                }
            }
        });

        // Konfirmasi sebelum submit
        uploadForm.addEventListener('submit', function(e) {
            if (!fileInput.files[0]) {
                alert('Pilih file terlebih dahulu!');
                e.preventDefault();
                return;
            }

            // Log form submission for debugging
            console.log('Form submitting...');
            console.log('File:', fileInput.files[0]);
            console.log('Form action:', uploadForm.action);
            console.log('Form method:', uploadForm.method);

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';

            // Allow form to submit normally
        });
    });
</script>
<?= $this->endSection() ?>