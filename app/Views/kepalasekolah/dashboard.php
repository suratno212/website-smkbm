<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Kepala Sekolah</h1>
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-primary">
                <div class="stats-icon"><i class="fas fa-users"></i></div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_siswa ?></h3>
                    <p class="stats-label">Total Siswa</p>
                </div>
                <div class="stats-bg"><i class="fas fa-users"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-success">
                <div class="stats-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_guru ?></h3>
                    <p class="stats-label">Total Guru</p>
                </div>
                <div class="stats-bg"><i class="fas fa-chalkboard-teacher"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-warning">
                <div class="stats-icon"><i class="fas fa-door-open"></i></div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_kelas ?></h3>
                    <p class="stats-label">Total Kelas</p>
                </div>
                <div class="stats-bg"><i class="fas fa-door-open"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card stats-card-danger">
                <div class="stats-icon"><i class="fas fa-book"></i></div>
                <div class="stats-content">
                    <h3 class="stats-number"><?= $total_jurusan ?></h3>
                    <p class="stats-label">Total Jurusan</p>
                </div>
                <div class="stats-bg"><i class="fas fa-book"></i></div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-7 mb-4 d-flex justify-content-center">
            <div class="card shadow-sm h-100 w-100" style="max-width: 520px; margin: 0 auto;">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fas fa-chart-bar me-2"></i>Jumlah Siswa per Jurusan</h5>
                    <canvas id="chartJurusan" height="80" style="max-height:220px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4 d-flex justify-content-center">
            <div class="card shadow-sm h-100 w-100" style="max-width: 380px; margin: 0 auto;">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fas fa-chart-pie me-2"></i>Jumlah Siswa per Kelas</h5>
                    <canvas id="chartKelas" height="80" style="max-height:220px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-info">Selamat datang, Kepala Sekolah!<br>Gunakan menu di sidebar untuk melihat rekap nilai, absensi, raport, dan statistik.</div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('kepalasekolah/rekap-nilai') ?>" class="btn btn-primary w-100">Rekap Nilai Siswa</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('kepalasekolah/rekap-absensi') ?>" class="btn btn-success w-100">Rekap Absensi</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('kepalasekolah/raport') ?>" class="btn btn-info w-100">Laporan e-Raport</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="<?= base_url('kepalasekolah/statistik') ?>" class="btn btn-warning w-100">Statistik Siswa/Guru</a>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Data untuk grafik jurusan
const jurusanLabels = <?= json_encode(array_column($siswa_per_jurusan, 'nama_jurusan')) ?>;
const jurusanData = <?= json_encode(array_map('intval', array_column($siswa_per_jurusan, 'total'))) ?>;
// Data untuk grafik kelas
const kelasLabels = <?= json_encode(array_column($siswa_per_kelas, 'nama_kelas')) ?>;
const kelasData = <?= json_encode(array_map('intval', array_column($siswa_per_kelas, 'total'))) ?>;

// Bar Chart Jurusan
const ctxJurusan = document.getElementById('chartJurusan').getContext('2d');
new Chart(ctxJurusan, {
    type: 'bar',
    data: {
        labels: jurusanLabels,
        datasets: [{
            label: 'Jumlah Siswa',
            data: jurusanData,
            backgroundColor: '#1a237e',
            borderRadius: 8,
            maxBarThickness: 40
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});
// Pie Chart Kelas
const ctxKelas = document.getElementById('chartKelas').getContext('2d');
new Chart(ctxKelas, {
    type: 'pie',
    data: {
        labels: kelasLabels,
        datasets: [{
            data: kelasData,
            backgroundColor: [
                '#1a237e', '#43a047', '#fbc02d', '#e53935', '#3949ab', '#00897b', '#fb8c00', '#8e24aa', '#00acc1', '#c62828', '#6d4c41', '#f06292', '#7e57c2', '#d4e157', '#ff7043', '#26a69a', '#ec407a', '#ab47bc', '#ffa726', '#66bb6a'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: { enabled: true }
        }
    }
});
</script>
<style>
.stats-card {
    position: relative;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(26,35,126,0.08);
    padding: 24px 20px 20px 20px;
    overflow: hidden;
    min-height: 140px;
    transition: box-shadow 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}
.stats-card:hover {
    box-shadow: 0 6px 24px rgba(26,35,126,0.18);
    transform: translateY(-2px) scale(1.03);
}
.stats-icon {
    font-size: 2.2rem;
    color: #fff;
    background: #1a237e;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(26,35,126,0.12);
}
.stats-card-success .stats-icon, .stats-card-success .stats-bg { background: #43a047 !important; }
.stats-card-warning .stats-icon, .stats-card-warning .stats-bg { background: #fbc02d !important; }
.stats-card-danger .stats-icon, .stats-card-danger .stats-bg { background: #e53935 !important; }
.stats-card-primary .stats-icon, .stats-card-primary .stats-bg { background: #1a237e !important; }
.stats-content { z-index: 2; }
.stats-number { font-size: 2.2rem; font-weight: bold; color: #1a237e; margin-bottom: 0; }
.stats-label { color: #888; font-size: 1rem; margin-bottom: 0; }
.stats-bg {
    position: absolute;
    right: 16px;
    bottom: 16px;
    font-size: 3.5rem;
    color: rgba(26,35,126,0.08);
    z-index: 1;
    pointer-events: none;
}
.stats-card-success .stats-number { color: #43a047; }
.stats-card-warning .stats-number { color: #fbc02d; }
.stats-card-danger .stats-number { color: #e53935; }
.stats-card-primary .stats-number { color: #1a237e; }
@media (max-width: 767px) {
    .stats-card { min-height: 110px; padding: 16px 10px 14px 10px; }
    .stats-icon { font-size: 1.5rem; width: 36px; height: 36px; }
    .stats-bg { font-size: 2.2rem; right: 8px; bottom: 8px; }
    .stats-number { font-size: 1.3rem; }
}
</style>
<?= $this->endSection() ?> 