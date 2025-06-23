<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Statistik Siswa & Guru</h3>
    <div class="mb-3">Login sebagai: <strong><?= esc($user['username'] ?? '-') ?></strong></div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <h2 class="card-text"><?= esc($total_siswa) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Guru</h5>
                    <h2 class="card-text"><?= esc($total_guru) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Kelas</h5>
                    <h2 class="card-text"><?= esc($total_kelas) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Jurusan</h5>
                    <h2 class="card-text"><?= esc($total_jurusan) ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 