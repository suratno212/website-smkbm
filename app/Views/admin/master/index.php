<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<style>
    /* =============================
       Interaktif & Profesional Card Data Master
       ============================= */

    /* Style dasar card agar modern dan lembut */
    .row .card {
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
        transition: box-shadow 0.35s cubic-bezier(.4,2,.3,1), transform 0.35s cubic-bezier(.4,2,.3,1);
        cursor: pointer;
        border: none;
        min-height: 170px;
    }
    /* Efek hover: hanya bayangan membesar dan scaling, warna tetap */
    .row .card:hover {
        box-shadow: 0 12px 32px rgba(44, 62, 80, 0.18);
        transform: translateY(-4px) scale(1.025);
    }
    /* Transisi warna teks judul & deskripsi agar smooth (tidak berubah warna) */
    .row .card .card-title,
    .row .card .card-text {
        transition: color 0.3s;
    }
    /* Tidak ada perubahan warna teks saat hover, tetap gunakan warna asli card */
    /* Efek transisi pada tombol agar responsif dan modern */
    .row .card .btn {
        transition: background 0.2s, color 0.2s;
    }
    .row .card .btn:hover {
        background: #283593;
        color: #fff;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Master</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Mata Pelajaran</h5>
                                    <p class="card-text text-white">Kelola data mata pelajaran</p>
                                    <a href="<?= base_url('admin/master/mapel') ?>" class="btn btn-light btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Kelas</h5>
                                    <p class="card-text text-white">Kelola data kelas</p>
                                    <a href="<?= base_url('admin/master/kelas') ?>" class="btn btn-light btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Jurusan</h5>
                                    <p class="card-text text-white">Kelola data jurusan</p>
                                    <a href="<?= base_url('admin/master/jurusan') ?>" class="btn btn-light btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Tahun Akademik</h5>
                                    <p class="card-text text-white">Kelola data tahun akademik</p>
                                    <a href="<?= base_url('admin/master/tahun_akademik') ?>" class="btn btn-light btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="card bg-secondary">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Agama</h5>
                                    <p class="card-text text-white">Kelola data agama</p>
                                    <a href="<?= base_url('admin/master/agama') ?>" class="btn btn-light btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Ekstrakurikuler</h5>
                                    <p class="card-text text-white">Kelola data ekstrakurikuler</p>
                                    <a href="<?= base_url('admin/master/ekstrakurikuler') ?>" class="btn btn-light btn-sm">Kelola</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 
