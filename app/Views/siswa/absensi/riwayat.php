<?= $this->extend('layout/siswa') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="header-text">
                            <h4 class="header-title">Riwayat Absensi</h4>
                            <p class="header-subtitle">Lihat riwayat kehadiran Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($riwayat)): ?>
                                    <tr><td colspan="4" class="text-center">Belum ada data absensi</td></tr>
                                <?php else: ?>
                                    <?php $no=1; foreach ($riwayat as $absen): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($absen['tanggal'])) ?></td>
                                        <td>
                                            <?php if ($absen['status'] == 'hadir'): ?>
                                                <span class="badge bg-success">Hadir</span>
                                            <?php elseif ($absen['status'] == 'sakit'): ?>
                                                <span class="badge bg-warning text-dark">Sakit</span>
                                            <?php elseif ($absen['status'] == 'izin'): ?>
                                                <span class="badge bg-info text-dark">Izin</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Tidak Hadir</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= isset($absen['keterangan']) ? ($absen['keterangan'] ?: '-') : '-' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="<?= base_url('siswa/absensi') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Absensi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 