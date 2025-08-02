<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Ekstrakurikuler</h1>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('admin/master/ekstrakurikuler/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="kd_ekstrakurikuler">Kode Ekstrakurikuler</label>
            <input type="text" class="form-control" id="kd_ekstrakurikuler" name="kd_ekstrakurikuler" value="<?= old('kd_ekstrakurikuler') ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_ekstrakurikuler">Nama Ekstrakurikuler</label>
            <input type="text" class="form-control" id="nama_ekstrakurikuler" name="nama_ekstrakurikuler" value="<?= old('nama_ekstrakurikuler') ?>" required>
        </div>
        <div class="form-group" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            <a href="<?= base_url('admin/master/ekstrakurikuler') ?>" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>