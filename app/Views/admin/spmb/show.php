<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h4>Detail Pendaftar SPMB</h4>
                </div>
                <div class="card-body">
                    <?php if ($pendaftar): ?>
                        <table class="table table-bordered">
                            <tr><th>No. Pendaftaran</th><td><?= esc($pendaftar['no_pendaftaran']) ?></td></tr>
                            <tr><th>Nama Lengkap</th><td><?= esc($pendaftar['nama_lengkap']) ?></td></tr>
                            <tr><th>Jenis Kelamin</th><td><?= esc($pendaftar['jenis_kelamin']) ?></td></tr>
                            <tr><th>Tempat, Tanggal Lahir</th><td><?= esc($pendaftar['tempat_lahir']) ?>, <?= date('d-m-Y', strtotime($pendaftar['tanggal_lahir'])) ?></td></tr>
                            <tr><th>Agama</th><td><?= esc($pendaftar['agama']) ?></td></tr>
                            <tr><th>Alamat</th><td><?= esc($pendaftar['alamat']) ?></td></tr>
                            <tr><th>Asal Sekolah</th><td><?= esc($pendaftar['asal_sekolah']) ?></td></tr>
                            <tr><th>Nama Orang Tua</th><td><?= esc($pendaftar['nama_ortu']) ?></td></tr>
                            <tr><th>No. HP Orang Tua</th><td><?= esc($pendaftar['no_hp_ortu']) ?></td></tr>
                            <tr><th>Email</th><td><?= esc($pendaftar['email']) ?></td></tr>
                            <tr><th>No. HP</th><td><?= esc($pendaftar['no_hp']) ?></td></tr>
                            <tr><th>Jurusan Pilihan</th><td><?= esc($pendaftar['jurusan_pilihan']) ?></td></tr>
                            <tr><th>Status Pendaftaran</th><td><?= esc($pendaftar['status_pendaftaran']) ?></td></tr>
                            <tr><th>Catatan</th><td><?= esc($pendaftar['catatan'] ?? '-') ?></td></tr>
                            <tr><th>Tanggal Daftar</th><td><?= date('d-m-Y H:i', strtotime($pendaftar['created_at'])) ?></td></tr>
                        </table>
                        <a href="<?= base_url('admin/spmb') ?>" class="btn btn-secondary">Kembali</a>
                    <?php else: ?>
                        <div class="alert alert-danger">Data pendaftar tidak ditemukan.</div>
                        <a href="<?= base_url('admin/spmb') ?>" class="btn btn-secondary">Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 