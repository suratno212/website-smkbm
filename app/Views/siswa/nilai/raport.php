<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">e-Raport</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/nilai') ?>">Nilai</a></li>
                        <li class="breadcrumb-item active">e-Raport</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Raport -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-primary mb-3">
                        <i class="fas fa-file-alt me-2"></i>
                        E-RAPORT SISWA
                    </h2>
                    <h5 class="text-muted">SMK BINA MANDIRI</h5>
                    <p class="text-muted mb-0">Tahun Akademik <?= esc($tahunAkademik['tahun']) ?> - Semester <?= $semester ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Siswa -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-graduate text-primary me-2"></i>
                        Data Siswa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Nama Lengkap:</strong></td>
                                    <td><?= esc($siswa['nama']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>NIS:</strong></td>
                                    <td><?= esc($siswa['nisn']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kelas:</strong></td>
                                    <td><?= esc($kelas['nama_kelas']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jurusan:</strong></td>
                                    <td><?= esc($kelas['nama_jurusan']) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Semester:</strong></td>
                                    <td><span class="badge bg-info"><?= $semester ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Akademik:</strong></td>
                                    <td><?= esc($tahunAkademik['tahun']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Wali Kelas:</strong></td>
                                    <td><?= esc($kelas['nama_wali_kelas'] ?? 'Belum ditentukan') ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <?php if ($rataRata >= 70): ?>
                                            <span class="badge bg-success">Lulus</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Tidak Lulus</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai Akademik -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-book text-primary me-2"></i>
                        Nilai Akademik
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($nilai)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada nilai untuk semester <?= $semester ?></p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle">No</th>
                                        <th rowspan="2" class="text-center align-middle">Mata Pelajaran</th>
                                        <th colspan="3" class="text-center">Komponen Nilai</th>
                                        <th rowspan="2" class="text-center align-middle">Nilai Akhir</th>
                                        <th rowspan="2" class="text-center align-middle">Grade</th>
                                        <th rowspan="2" class="text-center align-middle">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">UTS (30%)</th>
                                        <th class="text-center">UAS (40%)</th>
                                        <th class="text-center">Tugas (30%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalNilai = 0;
                                    $jumlahMapel = 0;
                                    foreach ($nilai as $i => $n): 
                                        if ($n['akhir'] !== null) {
                                            $totalNilai += $n['akhir'];
                                            $jumlahMapel++;
                                        }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><strong><?= esc($n['nama_mapel']) ?></strong></td>
                                        <td class="text-center">
                                            <?php if ($n['uts'] !== null): ?>
                                                <span class="badge bg-info"><?= $n['uts'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($n['uas'] !== null): ?>
                                                <span class="badge bg-warning"><?= $n['uas'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($n['tugas'] !== null): ?>
                                                <span class="badge bg-success"><?= $n['tugas'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($n['akhir'] !== null): ?>
                                                <?php
                                                $grade = '';
                                                $gradeClass = '';
                                                if ($n['akhir'] >= 90) {
                                                    $grade = 'A';
                                                    $gradeClass = 'bg-success';
                                                } elseif ($n['akhir'] >= 80) {
                                                    $grade = 'B';
                                                    $gradeClass = 'bg-info';
                                                } elseif ($n['akhir'] >= 70) {
                                                    $grade = 'C';
                                                    $gradeClass = 'bg-warning';
                                                } elseif ($n['akhir'] >= 60) {
                                                    $grade = 'D';
                                                    $gradeClass = 'bg-danger';
                                                } else {
                                                    $grade = 'E';
                                                    $gradeClass = 'bg-dark';
                                                }
                                                ?>
                                                <span class="badge <?= $gradeClass ?> fs-6"><?= $n['akhir'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($n['akhir'] !== null): ?>
                                                <span class="badge <?= $gradeClass ?>"><?= $grade ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($n['akhir'] !== null): ?>
                                                <?php if ($n['akhir'] >= 70): ?>
                                                    <span class="badge bg-success">Lulus</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Tidak Lulus</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Rata-rata Nilai:</strong></td>
                                        <td class="text-center">
                                            <strong class="text-primary">
                                                <?= $jumlahMapel > 0 ? number_format($totalNilai / $jumlahMapel, 2) : '-' ?>
                                            </strong>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Absensi -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check text-primary me-2"></i>
                        Data Absensi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h3 text-success mb-1"><?= $absensi['hadir'] ?></div>
                                <div class="text-muted">Hadir</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h3 text-warning mb-1"><?= $absensi['sakit'] ?></div>
                                <div class="text-muted">Sakit</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h3 text-info mb-1"><?= $absensi['izin'] ?></div>
                                <div class="text-muted">Izin</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h3 text-danger mb-1"><?= $absensi['alpha'] ?></div>
                                <div class="text-muted">Alpha</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <?php 
                            $totalAbsensi = $absensi['hadir'] + $absensi['sakit'] + $absensi['izin'] + $absensi['alpha'];
                            $persentaseHadir = $totalAbsensi > 0 ? ($absensi['hadir'] / $totalAbsensi) * 100 : 0;
                            ?>
                            <div class="text-center">
                                <div class="h4 text-primary mb-1"><?= number_format($persentaseHadir, 1) ?>%</div>
                                <div class="text-muted">Persentase Kehadiran</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ekstrakurikuler -->
    <?php if (!empty($ekskul)): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-running text-primary me-2"></i>
                        Ekstrakurikuler
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ekstrakurikuler</th>
                                    <th>Nilai</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ekskul as $i => $e): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($e['nama_ekstrakurikuler']) ?></td>
                                    <td>
                                        <?php if ($e['nilai']): ?>
                                            <span class="badge bg-info"><?= $e['nilai'] ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($e['keterangan'] ?? '-') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Ringkasan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Ringkasan Akademik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-primary mb-1"><?= number_format($rataRata, 2) ?></h4>
                                <p class="text-muted mb-0">Rata-rata Nilai</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-success mb-1"><?= $peringkat ?></h4>
                                <p class="text-muted mb-0">Peringkat Kelas</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-info mb-1"><?= count($nilai) ?></h4>
                                <p class="text-muted mb-0">Total Mapel</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-warning mb-1"><?= number_format($persentaseHadir, 1) ?>%</h4>
                                <p class="text-muted mb-0">Kehadiran</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert <?= $rataRata >= 70 ? 'alert-success' : 'alert-warning' ?> mb-0">
                                <h6 class="alert-heading">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Status Akademik
                                </h6>
                                <?php if ($rataRata >= 80): ?>
                                    <p class="mb-0">Selamat! Anda memiliki prestasi akademik yang sangat baik dengan rata-rata nilai <?= number_format($rataRata, 2) ?>. Pertahankan semangat belajar Anda!</p>
                                <?php elseif ($rataRata >= 70): ?>
                                    <p class="mb-0">Bagus! Nilai akademik Anda sudah memenuhi standar kelulusan dengan rata-rata <?= number_format($rataRata, 2) ?>. Tingkatkan lagi untuk hasil yang lebih baik.</p>
                                <?php else: ?>
                                    <p class="mb-0">Perlu peningkatan dalam pembelajaran. Rata-rata nilai Anda <?= number_format($rataRata, 2) ?>. Fokus pada mata pelajaran yang nilainya rendah.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <a href="<?= base_url('siswa/nilai/cetakRaport') ?>" class="btn btn-success btn-lg me-2" target="_blank">
                        <i class="fas fa-print me-2"></i>
                        Cetak Raport
                    </a>
                    <a href="<?= base_url('siswa/nilai/generate-pdf') ?>" class="btn btn-danger btn-lg me-2" target="_blank">
                        <i class="fas fa-file-pdf me-2"></i>
                        Download PDF
                    </a>
                    <a href="<?= base_url('siswa/nilai') ?>" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Nilai
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 