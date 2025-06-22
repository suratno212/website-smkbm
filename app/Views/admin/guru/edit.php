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

                    <form action="<?= base_url('admin/guru/update/' . $guru['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="nip_nuptk">NIP/NUPTK</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nip_nuptk')) ? 'is-invalid' : '' ?>" id="nip_nuptk" name="nip_nuptk" value="<?= old('nip_nuptk', $guru['nip_nuptk']) ?>" placeholder="Masukkan NIP/NUPTK">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nip_nuptk') ?>
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
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '' ?>" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" <?= old('jenis_kelamin', $guru['jenis_kelamin']) == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= old('jenis_kelamin', $guru['jenis_kelamin']) == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('jenis_kelamin') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <select class="form-control <?= ($validation->hasError('agama')) ? 'is-invalid' : '' ?>" id="agama" name="agama" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" <?= old('agama', $guru['agama']) == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                <option value="Kristen" <?= old('agama', $guru['agama']) == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                <option value="Katolik" <?= old('agama', $guru['agama']) == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                <option value="Hindu" <?= old('agama', $guru['agama']) == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                <option value="Buddha" <?= old('agama', $guru['agama']) == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                <option value="Konghucu" <?= old('agama', $guru['agama']) == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('agama') ?>
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
                            <label for="mapel_id">Mata Pelajaran</label>
                            <select class="form-control <?= ($validation->hasError('mapel_id')) ? 'is-invalid' : '' ?>" id="mapel_id" name="mapel_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php foreach ($mapel as $m) : ?>
                                    <option value="<?= $m['id'] ?>" <?= old('mapel_id', $guru['mapel_id']) == $m['id'] ? 'selected' : '' ?>><?= $m['nama_mapel'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('mapel_id') ?>
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