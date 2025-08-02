<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Mata Pelajaran</h3>
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

                    <form action="<?= base_url('admin/master/mapel/store') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="kd_mapel">Kode Mapel</label>
                            <input type="text" class="form-control" id="kd_mapel" name="kd_mapel" value="<?= old('kd_mapel') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_mapel">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="<?= old('nama_mapel') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kelompok">Kelompok</label>
                            <select class="form-control" id="kelompok" name="kelompok" required>
                                <option value="">Pilih Kelompok</option>
                                <option value="A" <?= old('kelompok') == 'A' ? 'selected' : '' ?>>A (Muatan Nasional)</option>
                                <option value="B" <?= old('kelompok') == 'B' ? 'selected' : '' ?>>B (Muatan Kewilayahan)</option>
                                <option value="C1" <?= old('kelompok') == 'C1' ? 'selected' : '' ?>>C1 (Dasar Bidang Keahlian)</option>
                                <option value="C2" <?= old('kelompok') == 'C2' ? 'selected' : '' ?>>C2 (Dasar Program Keahlian)</option>
                                <option value="C3" <?= old('kelompok') == 'C3' ? 'selected' : '' ?>>C3 (Kompetensi Keahlian)</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a href="<?= base_url('admin/master/mapel') ?>" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>