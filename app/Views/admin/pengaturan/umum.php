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
                        <li class="breadcrumb-item active">Pengaturan Umum</li>
                    </ol>
                </div>
                <h4 class="page-title">Pengaturan Umum</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Sekolah</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/pengaturan/update-umum') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-3">Data Sekolah</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" 
                                                   value="<?= old('nama_sekolah', $pengaturan['nama_sekolah']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telepon_sekolah" class="form-label">Telepon</label>
                                            <input type="text" class="form-control" id="telepon_sekolah" name="telepon_sekolah" 
                                                   value="<?= old('telepon_sekolah', $pengaturan['telepon_sekolah']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat_sekolah" class="form-label">Alamat Sekolah</label>
                                    <textarea class="form-control" id="alamat_sekolah" name="alamat_sekolah" rows="3"><?= old('alamat_sekolah', $pengaturan['alamat_sekolah']) ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email_sekolah" class="form-label">Email Sekolah</label>
                                            <input type="email" class="form-control" id="email_sekolah" name="email_sekolah" 
                                                   value="<?= old('email_sekolah', $pengaturan['email_sekolah']) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="website_sekolah" class="form-label">Website Sekolah</label>
                                            <input type="url" class="form-control" id="website_sekolah" name="website_sekolah" 
                                                   value="<?= old('website_sekolah', $pengaturan['website_sekolah']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-3 mt-4">Data Kepala Sekolah</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="kepala_sekolah" class="form-label">Nama Kepala Sekolah</label>
                                            <input type="text" class="form-control" id="kepala_sekolah" name="kepala_sekolah" 
                                                   value="<?= old('kepala_sekolah', $pengaturan['kepala_sekolah']) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nip_kepala_sekolah" class="form-label">NIP Kepala Sekolah</label>
                                            <input type="text" class="form-control" id="nip_kepala_sekolah" name="nip_kepala_sekolah" 
                                                   value="<?= old('nip_kepala_sekolah', $pengaturan['nip_kepala_sekolah']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mb-3 mt-4">Pengaturan Akademik</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tahun_akademik_aktif" class="form-label">Tahun Akademik Aktif</label>
                                            <select class="form-control" id="tahun_akademik_aktif" name="tahun_akademik_aktif">
                                                <?php 
                                                $currentYear = date('Y');
                                                for ($i = 0; $i < 5; $i++) {
                                                    $year = $currentYear - 2 + $i;
                                                    $academicYear = $year . '/' . ($year + 1);
                                                    $selected = ($academicYear == $pengaturan['tahun_akademik_aktif']) ? 'selected' : '';
                                                    echo "<option value=\"$academicYear\" $selected>$academicYear</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="semester_aktif" class="form-label">Semester Aktif</label>
                                            <select class="form-control" id="semester_aktif" name="semester_aktif">
                                                <option value="Ganjil" <?= ($pengaturan['semester_aktif'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                                                <option value="Genap" <?= ($pengaturan['semester_aktif'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h5 class="mb-3">Logo & Favicon</h5>
                                
                                <div class="mb-3">
                                    <label for="logo_file" class="form-label">Logo Sekolah</label>
                                    <?php if ($pengaturan['logo_sekolah']) : ?>
                                        <div class="mb-2">
                                            <img src="<?= base_url('uploads/logo/' . $pengaturan['logo_sekolah']) ?>" 
                                                 alt="Logo Sekolah" class="img-fluid" style="max-height: 100px;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" id="logo_file" name="logo_file" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                </div>

                                <div class="mb-3">
                                    <label for="favicon_file" class="form-label">Favicon</label>
                                    <?php if ($pengaturan['favicon_sekolah']) : ?>
                                        <div class="mb-2">
                                            <img src="<?= base_url('uploads/favicon/' . $pengaturan['favicon_sekolah']) ?>" 
                                                 alt="Favicon" class="img-fluid" style="max-height: 32px;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" id="favicon_file" name="favicon_file" accept="image/*">
                                    <small class="form-text text-muted">Format: ICO, PNG. Maksimal 1MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="<?= base_url('admin/pengaturan') ?>" class="btn btn-secondary me-2">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Pengaturan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview logo sebelum upload
    document.getElementById('logo_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'img-fluid mb-2';
                preview.style.maxHeight = '100px';
                
                const container = document.getElementById('logo_file').parentElement;
                const existingPreview = container.querySelector('img');
                if (existingPreview) {
                    existingPreview.remove();
                }
                container.insertBefore(preview, document.getElementById('logo_file'));
            }
            reader.readAsDataURL(file);
        }
    });

    // Preview favicon sebelum upload
    document.getElementById('favicon_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'img-fluid mb-2';
                preview.style.maxHeight = '32px';
                
                const container = document.getElementById('favicon_file').parentElement;
                const existingPreview = container.querySelector('img');
                if (existingPreview) {
                    existingPreview.remove();
                }
                container.insertBefore(preview, document.getElementById('favicon_file'));
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
<?= $this->endSection() ?> 