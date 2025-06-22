<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Tambah Kelas</h3></div>
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
                            <label for="nama_kelas">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?= old('nama_kelas') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tingkat">Tingkat</label>
                            <select name="tingkat" id="tingkat" class="form-control" required>
                                <option value="">Pilih Tingkat</option>
                                <?php for ($t = 10; $t <= 12; $t++) : ?>
                                    <option value="<?= $t ?>" <?= old('tingkat') == $t ? 'selected' : '' ?>><?= $t ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jurusan_id">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                                <option value="">Pilih Jurusan</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j['id'] ?>" <?= old('jurusan_id') == $j['id'] ? 'selected' : '' ?>><?= $j['nama_jurusan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wali_kelas_id">Wali Kelas</label>
                            <select name="wali_kelas_id" id="wali_kelas_id" class="form-control" required>
                                <option value="">Pilih Wali Kelas</option>
                                <?php foreach ($guru as $g) : ?>
                                    <option value="<?= $g['id'] ?>" <?= old('wali_kelas_id') == $g['id'] ? 'selected' : '' ?>><?= $g['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
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