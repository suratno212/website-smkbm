<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengumuman</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('guru/pengumuman/jadwal-ujian') ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-calendar"></i> Jadwal Ujian
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($pengumuman)) : ?>
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pengumuman</h5>
                        </div>
                    <?php else : ?>
                        <?php foreach ($pengumuman as $p) : ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0"><?= $p['judul'] ?></h5>
                                        <div>
                                            <span class="badge badge-<?= $p['jenis'] == 'Jadwal Ujian' ? 'danger' : ($p['jenis'] == 'Kegiatan' ? 'warning' : 'info') ?>">
                                                <?= $p['jenis'] ?>
                                            </span>
                                            <small class="text-muted ml-2"><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if ($p['isi']) : ?>
                                        <p class="card-text"><?= nl2br($p['isi']) ?></p>
                                    <?php endif; ?>

                                    <?php if ($p['file']) : ?>
                                        <div class="mt-3">
                                            <a href="<?= base_url('guru/pengumuman/download/' . $p['kd_pengumuman']) ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-download"></i> Download File
                                            </a>
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