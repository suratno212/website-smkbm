<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Tahun Akademik</h3>
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

                    <form action="<?= base_url('admin/master/tahun_akademik/update/' . $tahun_akademik['kd_tahun_akademik']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun" value="<?= old('tahun', $tahun_akademik['tahun']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="semester" name="semester" required>
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil" <?= old('semester', $tahun_akademik['semester']) == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                                <option value="Genap" <?= old('semester', $tahun_akademik['semester']) == 'Genap' ? 'selected' : '' ?>>Genap</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif" <?= old('status', $tahun_akademik['status']) == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= old('status', $tahun_akademik['status']) == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            <a href="<?= base_url('admin/master/tahun_akademik') ?>" class="btn btn-secondary btn-sm">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>