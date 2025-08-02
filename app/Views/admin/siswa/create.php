<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Siswa</h3>
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

                    <form action="<?= base_url('admin/siswa/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis" value="<?= old('nis') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kd_kelas">Kelas</label>
                            <select class="form-control" id="kd_kelas" name="kd_kelas" required>
                                <option value="">- Pilih Kelas -</option>
                                <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k['kd_kelas'] ?>" <?= old('kd_kelas') == $k['kd_kelas'] ? 'selected' : '' ?>><?= $k['nama_kelas'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kd_jurusan">Jurusan</label>
                            <select class="form-control" id="kd_jurusan" name="kd_jurusan" required>
                                <option value="">- Pilih Jurusan -</option>
                                <?php foreach ($jurusan as $j): ?>
                                    <option value="<?= $j['kd_jurusan'] ?>" <?= old('kd_jurusan') == $j['kd_jurusan'] ? 'selected' : '' ?>><?= $j['nama_jurusan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="agama_id">Agama</label>
                            <select class="form-control" id="agama_id" name="agama_id" required>
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $a) : ?>
                                    <option value="<?= $a['id'] ?>" <?= old('agama_id') == $a['id'] ? 'selected' : '' ?>>
                                        <?= $a['nama_agama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('admin/siswa') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 