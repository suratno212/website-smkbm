<?= $this->extend('layout/calonsiswa') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h2>Ujian Masuk SPMB</h2>
            <p>Tekan tombol di bawah ini untuk memulai tes seleksi SPMB.</p>
            <form action="<?= base_url('spmbtes/mulaiTes') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-primary btn-lg">Mulai Tes</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 