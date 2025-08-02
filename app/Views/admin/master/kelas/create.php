<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kelas</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('admin/master/kelas/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="kd_kelas">Kode Kelas</label>
                            <input type="text" class="form-control" id="kd_kelas" name="kd_kelas" value="<?= old('kd_kelas') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?= old('nama_kelas') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tingkat">Tingkat</label>
                            <select name="tingkat" id="tingkat" class="form-control" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="X" <?= old('tingkat') == 'X' ? 'selected' : '' ?>>X</option>
                                <option value="XI" <?= old('tingkat') == 'XI' ? 'selected' : '' ?>>XI</option>
                                <option value="XII" <?= old('tingkat') == 'XII' ? 'selected' : '' ?>>XII</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kd_jurusan">Jurusan</label>
                            <select name="kd_jurusan" id="kd_jurusan" class="form-control" required>
                                <option value="">Pilih Jurusan</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j['kd_jurusan'] ?>" <?= old('kd_jurusan') == $j['kd_jurusan'] ? 'selected' : '' ?>><?= $j['nama_jurusan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wali_kelas_nik_nip">Wali Kelas</label>
                            <select name="wali_kelas_nik_nip" id="wali_kelas_nik_nip" class="form-control" required>
                                <option value="">Pilih Wali Kelas</option>
                                <?php if (isset($wali_kelas) && is_array($wali_kelas)) : ?>
                                    <?php foreach ($wali_kelas as $g) : ?>
                                        <option value="<?= $g['nik_nip'] ?>" <?= old('wali_kelas_nik_nip') == $g['nik_nip'] ? 'selected' : '' ?>><?= $g['nama'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kuota">Kuota</label>
                            <input type="number" class="form-control" id="kuota" name="kuota" value="<?= old('kuota', 36) ?>" required>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a href="<?= base_url('admin/master/kelas') ?>" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>