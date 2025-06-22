<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">e-Raport - Pilih Kelas</h1>
    <div class="row">
        <?php if (empty($kelas)): ?>
            <div class="col-12">
                <div class="alert alert-warning">Anda belum menjadi wali kelas manapun.</div>
            </div>
        <?php endif; ?>
        <?php foreach($kelas as $k): ?>
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Kelas <?= esc($k['nama_kelas']) ?></h5>
                    <p class="card-text">Tingkat: <?= esc($k['tingkat']) ?></p>
                    <a href="<?= base_url('guru/raport/siswa/'.$k['id']) ?>" class="btn btn-light btn-sm">Pilih Kelas</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?> 