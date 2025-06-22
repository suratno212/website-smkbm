<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <h2>Status Pendaftaran PPDB</h2>
    <div class="card mt-4">
        <div class="card-body">
            <h4>Nomor Pendaftaran: <span class="text-primary"><?= esc($pendaftar['no_pendaftaran']) ?></span></h4>
            <p><b>Nama:</b> <?= esc($pendaftar['nama_lengkap']) ?></p>
            <p><b>Jurusan Pilihan:</b> <?= esc($pendaftar['jurusan_pilihan']) ?></p>
            <p><b>Status:</b> <span class="badge badge-info"><?= esc($pendaftar['status_pendaftaran']) ?></span></p>
            <?php if (!empty($pendaftar['catatan'])): ?>
                <p><b>Catatan:</b> <?= esc($pendaftar['catatan']) ?></p>
            <?php endif; ?>
        </div>
    </div>
    <a href="<?= base_url('ppdb/cek-status') ?>" class="btn btn-secondary mt-3">Cek Pendaftar Lain</a>
</div>
<?= $this->endSection() ?> 