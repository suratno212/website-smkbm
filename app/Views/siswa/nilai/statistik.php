<?= $this->extend('layout/siswa') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Statistik Nilai</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('siswa/nilai') ?>">Nilai</a></li>
                        <li class="breadcrumb-item active">Statistik</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Siswa -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <i class="fas fa-chart-bar text-primary me-2"></i>
                                Statistik Nilai Akademik
                            </h5>
                            <p class="text-muted mb-0">
                                Semester <?= $semester ?> - Tahun Akademik <?= esc($tahunAkademik['tahun']) ?>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="<?= base_url('siswa/nilai') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Rata-rata Nilai</p>
                            <h4 class="mb-0"><?= number_format($rataRata, 2) ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                <span class="avatar-title">
                                    <i class="fas fa-chart-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Peringkat Kelas</p>
                            <h4 class="mb-0"><?= $peringkat ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center">
                                <span class="avatar-title">
                                    <i class="fas fa-trophy font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Mapel</p>
                            <h4 class="mb-0"><?= count($nilai) ?></h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-info align-self-center">
                                <span class="avatar-title">
                                    <i class="fas fa-book font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Status</p>
                            <h4 class="mb-0">
                                <?php if ($rataRata >= 70): ?>
                                    <span class="badge bg-success">Lulus</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Tidak Lulus</span>
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle <?= $rataRata >= 70 ? 'bg-success' : 'bg-danger' ?> align-self-center">
                                <span class="avatar-title">
                                    <i class="fas <?= $rataRata >= 70 ? 'fa-check' : 'fa-times' ?> font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Nilai -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Grafik Nilai Mata Pelajaran
                    </h4>
                </div>
                <div class="card-body">
                    <canvas id="nilaiChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Distribusi Grade
                    </h4>
                </div>
                <div class="card-body">
                    <canvas id="gradeChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Analisis Nilai -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-list text-primary me-2"></i>
                        Kategori Nilai
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Grade</th>
                                    <th>Rentang Nilai</th>
                                    <th>Jumlah Mapel</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalMapel = count($nilai);
                                $gradeLabels = ['A', 'B', 'C', 'D', 'E'];
                                $gradeRanges = ['90-100', '80-89', '70-79', '60-69', '<60'];
                                $gradeColors = ['success', 'info', 'warning', 'danger', 'dark'];
                                
                                foreach ($gradeLabels as $i => $grade): 
                                    $count = $kategoriNilai[$grade];
                                    $persentase = $totalMapel > 0 ? ($count / $totalMapel) * 100 : 0;
                                ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-<?= $gradeColors[$i] ?>"><?= $grade ?></span>
                                    </td>
                                    <td><?= $gradeRanges[$i] ?></td>
                                    <td><?= $count ?></td>
                                    <td><?= number_format($persentase, 1) ?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-trophy text-primary me-2"></i>
                        Pencapaian Akademik
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Mata Pelajaran Terbaik</h6>
                        <?php 
                        $nilaiTerbaik = array_filter($nilai, function($n) { return $n['akhir'] !== null; });
                        if (!empty($nilaiTerbaik)) {
                            $terbaik = max($nilaiTerbaik, function($a, $b) { return $a['akhir'] <=> $b['akhir']; });
                        ?>
                        <div class="alert alert-success">
                            <h5 class="mb-1"><?= esc($terbaik['nama_mapel']) ?></h5>
                            <p class="mb-0">Nilai: <strong><?= $terbaik['akhir'] ?></strong></p>
                        </div>
                        <?php } else { ?>
                        <div class="alert alert-warning">
                            <p class="mb-0">Belum ada data nilai</p>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="mb-4">
                        <h6>Mata Pelajaran Perlu Perbaikan</h6>
                        <?php 
                        $nilaiRendah = array_filter($nilai, function($n) { return $n['akhir'] !== null && $n['akhir'] < 70; });
                        if (!empty($nilaiRendah)) {
                            $terendah = min($nilaiRendah, function($a, $b) { return $a['akhir'] <=> $b['akhir']; });
                        ?>
                        <div class="alert alert-warning">
                            <h5 class="mb-1"><?= esc($terendah['nama_mapel']) ?></h5>
                            <p class="mb-0">Nilai: <strong><?= $terendah['akhir'] ?></strong></p>
                        </div>
                        <?php } else { ?>
                        <div class="alert alert-success">
                            <p class="mb-0">Semua nilai sudah memenuhi standar</p>
                        </div>
                        <?php } ?>
                    </div>

                    <div>
                        <h6>Rekomendasi</h6>
                        <?php if ($rataRata >= 80): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-thumbs-up me-2"></i>
                            <strong>Excellent!</strong> Pertahankan performa akademik yang luar biasa ini.
                        </div>
                        <?php elseif ($rataRata >= 70): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Good!</strong> Tingkatkan lagi untuk hasil yang lebih baik.
                        </div>
                        <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perlu Perbaikan!</strong> Fokus pada mata pelajaran yang nilainya rendah.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Perbandingan dengan Kelas -->
    <?php if ($statistik): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-users text-primary me-2"></i>
                        Perbandingan dengan Kelas
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-primary"><?= number_format($rataRata, 2) ?></h4>
                                <p class="text-muted mb-0">Rata-rata Anda</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-info"><?= number_format($statistik['rata_rata'], 2) ?></h4>
                                <p class="text-muted mb-0">Rata-rata Kelas</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-success"><?= $statistik['nilai_tertinggi'] ?></h4>
                                <p class="text-muted mb-0">Nilai Tertinggi</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 border rounded">
                                <h4 class="text-danger"><?= $statistik['nilai_terendah'] ?></h4>
                                <p class="text-muted mb-0">Nilai Terendah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grafik Nilai Mata Pelajaran
    const ctxNilai = document.getElementById('nilaiChart').getContext('2d');
    const nilaiChart = new Chart(ctxNilai, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($nilai, 'nama_mapel')) ?>,
            datasets: [{
                label: 'Nilai Akhir',
                data: <?= json_encode(array_column($nilai, 'akhir')) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 3,
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // Grafik Distribusi Grade
    const ctxGrade = document.getElementById('gradeChart').getContext('2d');
    const gradeChart = new Chart(ctxGrade, {
        type: 'doughnut',
        data: {
            labels: ['A', 'B', 'C', 'D', 'E'],
            datasets: [{
                data: [
                    <?= $kategoriNilai['A'] ?>,
                    <?= $kategoriNilai['B'] ?>,
                    <?= $kategoriNilai['C'] ?>,
                    <?= $kategoriNilai['D'] ?>,
                    <?= $kategoriNilai['E'] ?>
                ],
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#ffc107',
                    '#dc3545',
                    '#343a40'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?> 