<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <h2 class="mb-4">Absensi Guru</h2>
    <!-- Stat Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-success h-100">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">Hadir</h5>
                    <h2><?= $stat['hadir'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-warning h-100">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">Izin</h5>
                    <h2><?= $stat['izin'] ?? 0 ?></h2>
                </div>
                        </div>
                    </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-info h-100">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">Sakit</h5>
                    <h2><?= $stat['sakit'] ?? 0 ?></h2>
                </div>
                        </div>
                    </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-danger h-100">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">Alfa</h5>
                    <h2><?= $stat['alfa'] ?? 0 ?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Grafik Kehadiran Bulanan -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">Grafik Kehadiran Bulanan</div>
                <div class="card-body">
                    <canvas id="absenChart"></canvas>
                        </div>
                        </div>
                    </div>
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">Quick Actions</div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="<?= base_url('guru/absensi-guru/create') ?>" class="btn btn-primary w-100 mb-2"><i class="fas fa-plus"></i> Input Absensi Hari Ini</a>
                    <a href="<?= base_url('guru/absensi/rekap') ?>" class="btn btn-outline-info w-100 mb-2"><i class="fas fa-table"></i> Lihat Rekap Bulanan</a>
                    <a href="<?= base_url('guru/absensi/cetak') ?>" class="btn btn-outline-success w-100"><i class="fas fa-print"></i> Cetak Rekap</a>
                </div>
                        </div>
                            </div>
                        </div>
    <!-- Tabel Riwayat Absensi -->
    <div class="card mb-4">
        <div class="card-header bg-light"><b>Riwayat Absensi</b></div>
        <div class="card-body">
                        <div class="table-responsive">
                <table class="table table-bordered table-hover" id="absensiTable">
                    <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                        <?php if (!empty($riwayat)): foreach ($riwayat as $a): ?>
                                        <tr>
                            <td><?= date('d/m/Y', strtotime($a['tanggal'])) ?></td>
                                            <td>
                                                <?php
                                $badge = 'secondary';
                                if ($a['status'] == 'hadir') $badge = 'success';
                                elseif ($a['status'] == 'izin') $badge = 'warning';
                                elseif ($a['status'] == 'sakit') $badge = 'info';
                                elseif ($a['status'] == 'alfa') $badge = 'danger';
                                                ?>
                                <span class="badge bg-<?= $badge ?> text-capitalize"><?= $a['status'] ?></span>
                                            </td>
                            <td><?= esc($a['keterangan'] ?? '-') ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="3" class="text-center">Belum ada data absensi</td></tr>
                                                <?php endif; ?>
                                </tbody>
                            </table>
            </div>
        </div>
    </div>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('absenChart').getContext('2d');
const absenChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($chart['labels'] ?? []) ?>,
        datasets: [
            {
                label: 'Hadir',
                data: <?= json_encode($chart['hadir'] ?? []) ?>,
                backgroundColor: 'rgba(40, 167, 69, 0.7)'
            },
            {
                label: 'Izin',
                data: <?= json_encode($chart['izin'] ?? []) ?>,
                backgroundColor: 'rgba(255, 193, 7, 0.7)'
            },
            {
                label: 'Sakit',
                data: <?= json_encode($chart['sakit'] ?? []) ?>,
                backgroundColor: 'rgba(23, 162, 184, 0.7)'
            },
            {
                label: 'Alfa',
                data: <?= json_encode($chart['alfa'] ?? []) ?>,
                backgroundColor: 'rgba(220, 53, 69, 0.7)'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
    }
}
});
</script>
<?= $this->endSection() ?> 