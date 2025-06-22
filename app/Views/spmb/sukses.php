<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>
<div class="container py-5 text-center">
    <h2>Pendaftaran Berhasil!</h2>
    <p>Nomor Pendaftaran Anda:</p>
    <h3 class="text-primary"><?= esc($no_pendaftaran) ?></h3>
    <p>Simpan nomor ini untuk cek status pendaftaran atau konfirmasi ke panitia.</p>
    <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Kembali ke Beranda</a>
</div>
<?= $this->endSection() ?> 