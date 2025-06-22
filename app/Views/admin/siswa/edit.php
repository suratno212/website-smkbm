<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Siswa</h3>
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

                    <form action="<?= base_url('admin/siswa/update/' . $siswa['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="nisn">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="<?= old('nisn', $siswa['nisn']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $siswa['nama']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $siswa['tanggal_lahir']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['id'] ?>" <?= old('kelas_id', $siswa['kelas_id']) == $k['id'] ? 'selected' : '' ?>>
                                        <?= $k['nama_kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jurusan_id">Jurusan</label>
                            <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                <option value="">Pilih Jurusan</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j['id'] ?>" <?= old('jurusan_id', $siswa['jurusan_id']) == $j['id'] ? 'selected' : '' ?>>
                                        <?= $j['nama_jurusan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $siswa['alamat']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp', $siswa['no_hp']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="agama_id">Agama</label>
                            <select class="form-control" id="agama_id" name="agama_id" required>
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $a) : ?>
                                    <option value="<?= $a['id'] ?>" <?= old('agama_id', $siswa['agama_id'] ?? '') == $a['id'] ? 'selected' : '' ?>>
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