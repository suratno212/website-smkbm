<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Ekstrakurikuler</h1>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('admin/master/ekstrakurikuler/update/'.$ekstrakurikuler['id']) ?>" method="post">
        <div class="form-group">
            <label>Nama Ekstrakurikuler</label>
            <input type="text" name="nama_ekstrakurikuler" class="form-control" value="<?= old('nama_ekstrakurikuler', $ekstrakurikuler['nama_ekstrakurikuler']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('admin/master/ekstrakurikuler') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?> 