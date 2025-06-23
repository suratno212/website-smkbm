<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('kepalasekolah/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Profil Kepala Sekolah</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <?php if (isset($user['foto']) && $user['foto']) : ?>
                        <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" alt="Profile" class="img-fluid rounded-circle mb-3 profile-preview" style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else : ?>
                        <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Profile" class="img-fluid rounded-circle mb-3 profile-preview" style="width: 150px; height: 150px; object-fit: cover;">
                    <?php endif; ?>
                    <h5 class="mb-0 mt-2"><?= $user['username'] ?></h5>
                    <p class="text-muted">Kepala Sekolah</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('kepalasekolah/profile/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= old('username', $user['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= old('email', $user['email'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="<?= base_url('kepalasekolah/dashboard') ?>" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('.profile-preview');
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
<?= $this->endSection() ?> 