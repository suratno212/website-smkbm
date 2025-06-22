<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Agama</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('admin/master/agama/update/' . $agama['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="nama_agama">Nama Agama</label>
                            <input type="text" class="form-control" id="nama_agama" name="nama_agama" value="<?= old('nama_agama', $agama['nama_agama']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <a href="<?= base_url('admin/master/agama') ?>" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 