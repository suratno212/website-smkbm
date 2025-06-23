<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah User</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= base_url('admin/users/store') ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" value="<?= old('username') ?>" required>
                                    <?php if (session('errors.username')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.username') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" value="<?= old('email') ?>" required>
                                    <?php if (session('errors.email')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" required>
                                    <?php if (session('errors.password')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control <?= session('errors.role') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Role</option>
                                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="guru" <?= old('role') == 'guru' ? 'selected' : '' ?>>Guru</option>
                                        <option value="siswa" <?= old('role') == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                                        <option value="kepala_sekolah" <?= old('role') == 'kepala_sekolah' ? 'selected' : '' ?>>Kepala Sekolah</option>
                                    </select>
                                    <?php if (session('errors.role')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.role') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="foto">Foto Profile</label>
                                    <div class="custom-file">
                                        <input type="file" name="foto" id="foto" class="custom-file-input <?= session('errors.foto') ? 'is-invalid' : '' ?>" accept="image/*">
                                        <label class="custom-file-label" for="foto">Pilih file</label>
                                    </div>
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 1MB</small>
                                    <?php if (session('errors.foto')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.foto') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Update nama file yang dipilih
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
<?= $this->endSection() ?> 