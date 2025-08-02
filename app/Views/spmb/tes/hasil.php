<?= $this->extend('layout/calonsiswa') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h2>Hasil Tes SPMB</h2>
            <p>Nilai Anda: <span class="display-4"><?= $ujian['skor'] ?></span></p>
            <p>Nilai Minimal Lulus: <span class="display-6 text-primary"><?= $nilai_minimal ?></span></p>
            <p>Status Kelulusan:
                <?php if ($lulus): ?>
                    <span class="badge bg-success">Lulus</span>
                <?php else: ?>
                    <span class="badge bg-danger">Belum Lulus</span>
                <?php endif; ?>
            </p>
            <?php if (!$lulus): ?>
                <form action="<?= base_url('spmbtes/mulaiTes') ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-warning mt-3">Tes Susulan</button>
                </form>
            <?php else: ?>
                <a href="<?= base_url('spmbtes/mulai') ?>" class="btn btn-primary mt-3">Ulangi Tes</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 