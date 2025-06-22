<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <h2>Cek Status Pendaftaran PPDB</h2>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"> <?= session()->getFlashdata('error') ?> </div>
    <?php endif; ?>
    <form action="<?= base_url('ppdb/cek-status') ?>" method="post" class="mt-4">
        <div class="form-group">
            <label for="no_pendaftaran">Nomor Pendaftaran</label>
            <input type="text" class="form-control" id="no_pendaftaran" name="no_pendaftaran" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Cek Status</button>
    </form>
</div>
<?= $this->endSection() ?> 