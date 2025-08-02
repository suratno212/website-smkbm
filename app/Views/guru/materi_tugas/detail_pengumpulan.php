<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas') ?>">E-Learning</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas/tugas') ?>">Daftar Tugas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pengumpulan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Pengumpulan Tugas</h4>
                    <h6 class="text-muted"><?= $tugas['judul'] ?></h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informasi Tugas</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Judul:</strong></td>
                                    <td><?= $tugas['judul'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi:</strong></td>
                                    <td><?= $tugas['deskripsi'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Deadline:</strong></td>
                                    <td><?= date('d/m/Y H:i', strtotime($tugas['deadline'])) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>File:</strong></td>
                                    <td>
                                        <?php if ($tugas['file']): ?>
                                            <a href="<?= base_url('uploads/tugas/' . $tugas['file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download File
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada file</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Statistik Pengumpulan</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h4><?= count($pengumpulan) ?></h4>
                                            <small>Total Pengumpulan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4><?= count(array_filter($pengumpulan, function ($p) {
                                                    return $p['status'] == 'dikumpulkan';
                                                })) ?></h4>
                                            <small>Sudah Dikumpulkan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5>Daftar Pengumpulan Siswa</h5>
                    <?php if (empty($pengumpulan)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada siswa yang mengumpulkan tugas ini.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Status</th>
                                        <th>Tanggal Pengumpulan</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pengumpulan as $index => $p): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $p['nama_siswa'] ?></td>
                                            <td><?= $p['nis'] ?></td>
                                            <td>
                                                <?php
                                                $statusClass = '';
                                                $statusText = '';

                                                switch ($p['status']) {
                                                    case 'dikumpulkan':
                                                        $statusClass = 'bg-success';
                                                        $statusText = 'Dikumpulkan';
                                                        break;
                                                    case 'belum_dikumpulkan':
                                                        $statusClass = 'bg-warning';
                                                        $statusText = 'Belum Dikumpulkan';
                                                        break;
                                                    case 'terlambat':
                                                        $statusClass = 'bg-danger';
                                                        $statusText = 'Terlambat';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-secondary';
                                                        $statusText = 'Tidak Diketahui';
                                                }
                                                ?>
                                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                            </td>
                                            <td>
                                                <?php if ($p['tanggal_pengumpulan']): ?>
                                                    <?= date('d/m/Y H:i', strtotime($p['tanggal_pengumpulan'])) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($p['file']): ?>
                                                    <a href="<?= base_url('uploads/pengumpulan/' . $p['file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada file</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('guru/materitugas/nilaiTugas/' . $p['kd_pengumpulan']) ?>"
                                                        class="btn btn-sm btn-outline-warning" title="Beri Nilai">
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                    <a href="<?= base_url('uploads/pengumpulan/' . $p['file']) ?>"
                                                        target="_blank" class="btn btn-sm btn-outline-info" title="Download File">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('guru/materitugas/tugas') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tugas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>