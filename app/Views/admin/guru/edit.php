<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Guru</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/guru/update/' . $guru['nik_nip']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="nik_nip">NIK/NIP</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nik_nip')) ? 'is-invalid' : '' ?>" id="nik_nip" name="nik_nip" value="<?= old('nik_nip', $guru['nik_nip']) ?>" placeholder="Masukkan NIK/NIP" readonly>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nik_nip') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama', $guru['nama']) ?>" placeholder="Masukkan nama" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email', $guru['email']) ?>" placeholder="Masukkan email" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '' ?>" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?= old('jenis_kelamin', $guru['jenis_kelamin']) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= old('jenis_kelamin', $guru['jenis_kelamin']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenis_kelamin') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="agama_id">Agama</label>
                            <select class="form-control <?= ($validation->hasError('agama_id')) ? 'is-invalid' : '' ?>" id="agama_id" name="agama_id" required>
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $a) : ?>
                                    <option value="<?= $a['id'] ?>" <?= old('agama_id', $guru['agama_id']) == $a['id'] ? 'selected' : '' ?>><?= $a['nama_agama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('agama_id') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control <?= ($validation->hasError('tanggal_lahir')) ? 'is-invalid' : '' ?>" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $guru['tanggal_lahir']) ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal_lahir') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kd_mapel">Mata Pelajaran</label>
                            <select class="form-control <?= ($validation->hasError('kd_mapel')) ? 'is-invalid' : '' ?>" id="kd_mapel" name="kd_mapel" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php foreach ($mapel as $m) : ?>
                                    <option value="<?= $m['kd_mapel'] ?>" <?= old('kd_mapel', $guru['kd_mapel']) == $m['kd_mapel'] ? 'selected' : '' ?>><?= $m['nama_mapel'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kd_mapel') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat"><?= old('alamat', $guru['alamat']) ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('alamat') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" class="form-control <?= ($validation->hasError('no_hp')) ? 'is-invalid' : '' ?>" id="no_hp" name="no_hp" value="<?= old('no_hp', $guru['no_hp']) ?>" placeholder="Masukkan nomor HP">
                            <div class="invalid-feedback">
                                <?= $validation->getError('no_hp') ?>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            <a href="<?= base_url('admin/guru') ?>" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 