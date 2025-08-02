<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jadwal Ujian</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('guru/pengumuman') ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali ke Pengumuman
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($pengumuman)) : ?>
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada jadwal ujian</h5>
                            <p class="text-muted">Admin belum mengupload jadwal ujian</p>
                        </div>
                    <?php else : ?>
                        <?php foreach ($pengumuman as $p) : ?>
                            <div class="card mb-3 border-danger">
                                <div class="card-header bg-danger text-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-calendar-alt"></i> <?= $p['judul'] ?>
                                        </h5>
                                        <small><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if ($p['isi']) : ?>
                                        <p class="card-text"><?= nl2br($p['isi']) ?></p>
                                    <?php endif; ?>

                                    <?php if ($p['file']) : ?>
                                        <div class="mt-3">
                                            <a href="<?= base_url('guru/pengumuman/download/' . $p['kd_pengumuman']) ?>" class="btn btn-danger btn-lg">
                                                <i class="fas fa-download"></i> Download Jadwal Ujian
                                            </a>
                                            <small class="text-muted d-block mt-2">Klik tombol di atas untuk mengunduh file jadwal ujian</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>