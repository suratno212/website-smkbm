<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Rekap Nilai Siswa</h1>
    <form class="row mb-3">
        <div class="col-md-3">
            <label>Kelas</label>
            <select class="form-select"><option>Semua Kelas</option></select>
        </div>
        <div class="col-md-3">
            <label>Jurusan</label>
            <select class="form-select"><option>Semua Jurusan</option></select>
        </div>
        <div class="col-md-3">
            <label>Semester</label>
            <select class="form-select"><option>Ganjil</option><option>Genap</option></select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead><tr><th>No</th><th>Nama Siswa</th><th>Kelas</th><th>Jurusan</th><th>Nilai</th></tr></thead>
            <tbody><tr><td colspan="5" class="text-center text-muted">Data rekap nilai akan tampil di sini</td></tr></tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?> 