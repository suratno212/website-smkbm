<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas') ?>">E-Learning</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Upload Materi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-upload"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Upload Materi Pembelajaran</h4>
                            <p class="header-subtitle">Upload materi pembelajaran untuk siswa</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('guru/materitugas/uploadMateri') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                        <?= csrf_field() ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mapel_id" class="form-label">
                                        <i class="fas fa-book me-2"></i>Mata Pelajaran <span class="text-danger">*</span>
                                    </label>
                                    <select name="mapel_id" id="mapel_id" class="form-select" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        <?php foreach ($mapel as $m): ?>
                                            <option value="<?= $m['id'] ?>" <?= old('mapel_id') == $m['id'] ? 'selected' : '' ?>>
                                                <?= $m['nama_mapel'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Mata pelajaran harus dipilih</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kelas_id" class="form-label">
                                        <i class="fas fa-users me-2"></i>Kelas <span class="text-danger">*</span>
                                    </label>
                                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $k): ?>
                                            <option value="<?= $k['id'] ?>" <?= old('kelas_id') == $k['id'] ? 'selected' : '' ?>>
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Kelas harus dipilih</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="judul" class="form-label">
                                        <i class="fas fa-heading me-2"></i>Judul Materi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="judul" id="judul" class="form-control" 
                                           value="<?= old('judul') ?>" placeholder="Masukkan judul materi" required>
                                    <div class="invalid-feedback">Judul materi harus diisi</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deskripsi" class="form-label">
                                        <i class="fas fa-align-left me-2"></i>Deskripsi Materi
                                    </label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" 
                                              placeholder="Masukkan deskripsi materi (opsional)"><?= old('deskripsi') ?></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="file" class="form-label">
                                        <i class="fas fa-file me-2"></i>File Materi <span class="text-danger">*</span>
                                    </label>
                                    <div class="file-upload-container">
                                        <input type="file" name="file" id="file" class="form-control" 
                                               accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar" required>
                                        <div class="file-info mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Format yang diizinkan: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR
                                                <br>Ukuran maksimal: 10MB
                                            </small>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">File materi harus dipilih</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_siswa" name="notify_siswa" value="1">
                                        <label class="form-check-label" for="notify_siswa">
                                            <i class="fas fa-bell me-2"></i>Beritahu siswa tentang materi baru
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= base_url('guru/materitugas') ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-upload me-2"></i>Upload Materi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="col-lg-4">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-eye"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Preview</h4>
                            <p class="header-subtitle">Informasi materi yang akan diupload</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div id="preview-content">
                        <div class="preview-placeholder">
                            <div class="preview-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h6>Belum ada data</h6>
                            <p class="text-muted">Isi form untuk melihat preview</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="modern-card mt-3">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Tips Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <ul class="tips-list">
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Gunakan judul yang jelas dan deskriptif
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Pastikan file tidak rusak sebelum upload
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Kompres file besar untuk mempercepat upload
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Berikan deskripsi yang informatif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.card-header-modern {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 40px;
    height: 40px;
    background: #007bff;
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
    color: #495057;
}

.header-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.card-body-modern {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.file-upload-container {
    position: relative;
}

.file-info {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 0.75rem;
    border-left: 4px solid #007bff;
}

.form-actions {
    border-top: 1px solid #e9ecef;
    padding-top: 1.5rem;
}

.btn {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background: #0056b3;
    border-color: #0056b3;
    transform: translateY(-2px);
}

.btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
}

.preview-placeholder {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.preview-icon {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tips-list li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.tips-list li:last-child {
    border-bottom: none;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

@media (max-width: 768px) {
    .card-body-modern {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const fileInput = document.getElementById('file');
    const previewContent = document.getElementById('preview-content');

    // Preview functionality
    function updatePreview() {
        const judul = document.getElementById('judul').value;
        const mapelSelect = document.getElementById('mapel_id');
        const kelasSelect = document.getElementById('kelas_id');
        const deskripsi = document.getElementById('deskripsi').value;
        const file = fileInput.files[0];

        if (judul || mapelSelect.value || kelasSelect.value || deskripsi || file) {
            let previewHTML = '<div class="preview-item">';
            
            if (judul) {
                previewHTML += `<h6><i class="fas fa-heading me-2"></i>Judul</h6>`;
                previewHTML += `<p class="mb-3">${judul}</p>`;
            }
            
            if (mapelSelect.value) {
                const mapelText = mapelSelect.options[mapelSelect.selectedIndex].text;
                previewHTML += `<h6><i class="fas fa-book me-2"></i>Mata Pelajaran</h6>`;
                previewHTML += `<p class="mb-3">${mapelText}</p>`;
            }
            
            if (kelasSelect.value) {
                const kelasText = kelasSelect.options[kelasSelect.selectedIndex].text;
                previewHTML += `<h6><i class="fas fa-users me-2"></i>Kelas</h6>`;
                previewHTML += `<p class="mb-3">${kelasText}</p>`;
            }
            
            if (deskripsi) {
                previewHTML += `<h6><i class="fas fa-align-left me-2"></i>Deskripsi</h6>`;
                previewHTML += `<p class="mb-3">${deskripsi}</p>`;
            }
            
            if (file) {
                previewHTML += `<h6><i class="fas fa-file me-2"></i>File</h6>`;
                previewHTML += `<p class="mb-3"><span class="badge bg-primary">${file.name}</span></p>`;
                previewHTML += `<small class="text-muted">Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB</small>`;
            }
            
            previewHTML += '</div>';
            previewContent.innerHTML = previewHTML;
        } else {
            previewContent.innerHTML = `
                <div class="preview-placeholder">
                    <div class="preview-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h6>Belum ada data</h6>
                    <p class="text-muted">Isi form untuk melihat preview</p>
                </div>
            `;
        }
    }

    // Add event listeners for preview
    document.getElementById('judul').addEventListener('input', updatePreview);
    document.getElementById('mapel_id').addEventListener('change', updatePreview);
    document.getElementById('kelas_id').addEventListener('change', updatePreview);
    document.getElementById('deskripsi').addEventListener('input', updatePreview);
    fileInput.addEventListener('change', updatePreview);

    // Form validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = ['mapel_id', 'kelas_id', 'judul', 'file'];
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi');
        } else {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
        }
    });
});
</script>
<?= $this->endSection() ?> 