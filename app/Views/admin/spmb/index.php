<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-primary">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['total'] ?? 0 ?></div>
                            <small>Total Pendaftar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-success">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['diterima'] ?? 0 ?></div>
                            <small>Diterima</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-warning">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['menunggu'] ?? 0 ?></div>
                            <small>Menunggu</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-danger">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['ditolak'] ?? 0 ?></div>
                            <small>Ditolak</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-info">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['bersyarat'] ?? 0 ?></div>
                            <small>Bersyarat</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Data SPMB</h3>
                    <a href="<?= base_url('admin/spmb/print') ?>" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-print"></i> Cetak Laporan</a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($spmb)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($spmb as $p) : ?>
                                        <?php
                                            // Cek apakah user sudah ada
                                            $userModel = new \App\Models\UserModel();
                                            $userSiswa = $userModel->where('username', $p['no_pendaftaran'])->first();
                                        ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $p['no_pendaftaran']; ?></td>
                                            <td><?= $p['nama_lengkap']; ?></td>
                                            <td><?= $p['jurusan_pilihan']; ?></td>
                                            <td>
                                                <span class="badge badge-<?=
                                                    $p['status_pendaftaran'] == 'Menunggu' ? 'warning' :
                                                    ($p['status_pendaftaran'] == 'Diterima' ? 'success' :
                                                    ($p['status_pendaftaran'] == 'Diterima Bersyarat' ? 'info' :
                                                    ($p['status_pendaftaran'] == 'Sudah Jadi Siswa' ? 'primary' : 'danger')))
                                                ?>">
                                                    <?= $p['status_pendaftaran'] == 'Sudah Jadi Siswa' ? 'Sudah Jadi Siswa' : $p['status_pendaftaran']; ?>
                                                </span>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])); ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/spmb/' . $p['id']); ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($p['status_pendaftaran'] == 'Menunggu') : ?>
                                                    <a href="<?= base_url('admin/spmb/terima/' . $p['id']); ?>" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/spmb/tolak/' . $p['id']); ?>" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                <?php elseif ($p['status_pendaftaran'] == 'Diterima' && !$userSiswa) : ?>
                                                    <a href="<?= base_url('admin/spmb/jadikanSiswa/' . $p['id']); ?>" class="btn btn-primary btn-sm" onclick="return confirm('Jadikan pendaftar ini sebagai siswa?')">
                                                        <i class="fas fa-user-plus"></i> Jadikan Siswa
                                                    </a>
                                                <?php elseif ($p['status_pendaftaran'] == 'Sudah Jadi Siswa' || $userSiswa) : ?>
                                                    <span class="badge badge-success">Sudah Jadi Siswa</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pendaftar</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 