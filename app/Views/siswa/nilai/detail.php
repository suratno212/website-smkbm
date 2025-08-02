<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Detail Nilai</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/nilai') ?>">Nilai</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-book text-primary me-2"></i>
                                Detail Nilai <?= esc($nilai['nama_mapel']) ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?= base_url('siswa/nilai') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informasi Siswa -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Nama:</strong></td>
                                    <td><?= esc($siswa['nama']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>NIS:</strong></td>
                                    <td><?= esc($siswa['nis']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kelas:</strong></td>
                                    <td><?= esc($kelas['nama_kelas']) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Jurusan:</strong></td>
                                    <td><?= esc($kelas['nama_jurusan']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester:</strong></td>
                                    <td><span class="badge bg-info"><?= $semester ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun:</strong></td>
                                    <td><?= esc($tahunAkademik['tahun']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Detail Nilai -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-pie me-2"></i>
                                        Komponen Nilai
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="border rounded p-3">
                                                <h4 class="text-info mb-1"><?= $nilai['uts'] ?? '-' ?></h4>
                                                <small class="text-muted">UTS</small>
                                                <div class="mt-2">
                                                    <small class="text-muted">30%</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-3">
                                                <h4 class="text-warning mb-1"><?= $nilai['uas'] ?? '-' ?></h4>
                                                <small class="text-muted">UAS</small>
                                                <div class="mt-2">
                                                    <small class="text-muted">40%</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border rounded p-3">
                                                <h4 class="text-success mb-1"><?= $nilai['tugas'] ?? '-' ?></h4>
                                                <small class="text-muted">Tugas</small>
                                                <div class="mt-2">
                                                    <small class="text-muted">30%</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-star me-2"></i>
                                        Nilai Akhir
                                    </h5>
                                </div>
                                <div class="card-body text-center">
                                    <?php
                                    $grade = '';
                                    $gradeClass = '';
                                    $gradeText = '';
                                    if ($nilai['akhir'] >= 90) {
                                        $grade = 'A';
                                        $gradeClass = 'bg-success';
                                        $gradeText = 'Sangat Baik';
                                    } elseif ($nilai['akhir'] >= 80) {
                                        $grade = 'B';
                                        $gradeClass = 'bg-info';
                                        $gradeText = 'Baik';
                                    } elseif ($nilai['akhir'] >= 70) {
                                        $grade = 'C';
                                        $gradeClass = 'bg-warning';
                                        $gradeText = 'Cukup';
                                    } elseif ($nilai['akhir'] >= 60) {
                                        $grade = 'D';
                                        $gradeClass = 'bg-danger';
                                        $gradeText = 'Kurang';
                                    } else {
                                        $grade = 'E';
                                        $gradeClass = 'bg-dark';
                                        $gradeText = 'Sangat Kurang';
                                    }
                                    ?>
                                    <h1 class="display-4 text-success mb-2"><?= $nilai['akhir'] ?? '-' ?></h1>
                                    <h3 class="mb-2">
                                        <span class="badge <?= $gradeClass ?> fs-5"><?= $grade ?></span>
                                    </h3>
                                    <p class="text-muted mb-0"><?= $gradeText ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perbandingan dengan Rata-rata Kelas -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-line text-primary me-2"></i>
                                        Perbandingan dengan Rata-rata Kelas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-6">
                                            <h4 class="text-primary"><?= number_format($nilai['akhir'], 2) ?></h4>
                                            <p class="text-muted">Nilai Anda</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="text-info"><?= number_format($rataRataKelas, 2) ?></h4>
                                            <p class="text-muted">Rata-rata Kelas</p>
                                        </div>
                                    </div>
                                    <div class="progress mt-3" style="height: 25px;">
                                        <?php 
                                        $selisih = $nilai['akhir'] - $rataRataKelas;
                                        $progressClass = $selisih >= 0 ? 'bg-success' : 'bg-danger';
                                        $progressWidth = min(100, max(0, ($nilai['akhir'] / 100) * 100));
                                        ?>
                                        <div class="progress-bar <?= $progressClass ?>" 
                                             style="width: <?= $progressWidth ?>%">
                                            <?= number_format($selisih, 2) ?> 
                                            <?= $selisih >= 0 ? 'di atas rata-rata' : 'di bawah rata-rata' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informasi Mata Pelajaran -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Informasi Mata Pelajaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="fas fa-book text-white"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1"><?= esc($nilai['nama_mapel']) ?></h6>
                            <small class="text-muted">Mata Pelajaran</small>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-calculator text-primary me-2"></i>Rumus Penilaian</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-1"><strong>Nilai Akhir = (UTS × 30%) + (UAS × 40%) + (Tugas × 30%)</strong></p>
                            <small class="text-muted">
                                UTS: Ujian Tengah Semester<br>
                                UAS: Ujian Akhir Semester
                            </small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fas fa-graduation-cap text-primary me-2"></i>Kriteria Kelulusan</h6>
                        <div class="p-3 bg-light rounded">
                            <div class="row text-center">
                                <div class="col-6">
                                    <span class="badge bg-success">≥ 70</span>
                                    <br><small class="text-muted">Lulus</small>
                                </div>
                                <div class="col-6">
                                    <span class="badge bg-danger">&lt; 70</span>
                                    <br><small class="text-muted">Tidak Lulus</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fas fa-chart-bar text-primary me-2"></i>Grading System</h6>
                        <div class="p-3 bg-light rounded">
                            <div class="row text-center">
                                <div class="col-4 mb-2">
                                    <span class="badge bg-success">A (90-100)</span>
                                </div>
                                <div class="col-4 mb-2">
                                    <span class="badge bg-info">B (80-89)</span>
                                </div>
                                <div class="col-4 mb-2">
                                    <span class="badge bg-warning">C (70-79)</span>
                                </div>
                                <div class="col-4 mb-2">
                                    <span class="badge bg-danger">D (60-69)</span>
                                </div>
                                <div class="col-4 mb-2">
                                    <span class="badge bg-dark">E (&lt;60)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saran Perbaikan -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Saran Perbaikan
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($nilai['akhir'] >= 80): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-thumbs-up me-2"></i>
                            <strong>Excellent!</strong> Nilai Anda sangat baik. Pertahankan semangat belajar dan terus tingkatkan kemampuan Anda.
                        </div>
                    <?php elseif ($nilai['akhir'] >= 70): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Good!</strong> Nilai Anda sudah memenuhi standar kelulusan. Tingkatkan lagi untuk hasil yang lebih baik.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perlu Perbaikan!</strong> Nilai Anda masih di bawah standar kelulusan. 
                            <ul class="mb-0 mt-2">
                                <li>Perbanyak latihan soal</li>
                                <li>Konsultasi dengan guru</li>
                                <li>Ikuti remedial jika ada</li>
                                <li>Perbaiki cara belajar</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 