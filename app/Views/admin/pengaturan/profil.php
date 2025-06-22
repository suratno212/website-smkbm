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
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Profil Admin</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Profil</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/pengaturan/update-profil') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="<?= old('username', $user['username']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= old('email', $user['email']) ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                                            <small class="form-text text-muted">Minimal 6 karakter</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   placeholder="Konfirmasi password baru">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                                   value="<?= old('nama_lengkap', $user['nama_lengkap'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="no_hp" class="form-label">No. HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp" 
                                                   value="<?= old('no_hp', $user['no_hp'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= old('alamat', $user['alamat'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <?php if ($user['foto']) : ?>
                                            <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" 
                                                 alt="Foto Profil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/images/default-avatar.png') ?>" 
                                                 alt="Foto Profil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Upload Foto</label>
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                    </div>
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
                                        <i class="fas fa-save"></i> Simpan Perubahan
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
    // Preview foto sebelum upload
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('.rounded-circle');
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Validasi password
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        if (password && confirmPassword && password !== confirmPassword) {
            this.setCustomValidity('Password tidak cocok');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
<?= $this->endSection() ?> 