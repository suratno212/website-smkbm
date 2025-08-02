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
    <div class="row mb-4 g-4 align-items-stretch">
        <div class="col-lg-6 col-md-12 d-flex">
            <div class="card shadow-sm flex-fill w-100 mb-3 mb-lg-0">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fas fa-user-graduate me-2"></i>Pendaftar SPMB per Jurusan</h5>
                    <canvas id="chartSpmbJurusan" height="80" style="max-height:220px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 d-flex">
            <div class="card shadow-sm flex-fill w-100">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fas fa-chart-line me-2"></i>Status Pendaftaran SPMB</h5>
                    <canvas id="chartSpmbStatus" height="80" style="max-height:220px;"></canvas>
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

// Data untuk grafik SPMB
const spmbJurusanLabels = <?= json_encode(array_column($spmb_per_jurusan, 'jurusan_pilihan')) ?>;
const spmbJurusanData = <?= json_encode(array_map('intval', array_column($spmb_per_jurusan, 'total'))) ?>;
const spmbStatusLabels = <?= json_encode(array_column($spmb_status, 'status_pendaftaran')) ?>;
const spmbStatusData = <?= json_encode(array_map('intval', array_column($spmb_status, 'total'))) ?>;

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
// Bar Chart Kelas
const ctxKelas = document.getElementById('chartKelas').getContext('2d');
new Chart(ctxKelas, {
    type: 'bar',
    data: {
        labels: kelasLabels,
        datasets: [{
            label: 'Jumlah Siswa',
            data: kelasData,
            backgroundColor: '#3949ab',
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

// Bar Chart SPMB per Jurusan
const ctxSpmbJurusan = document.getElementById('chartSpmbJurusan').getContext('2d');
new Chart(ctxSpmbJurusan, {
    type: 'bar',
    data: {
        labels: spmbJurusanLabels,
        datasets: [{
            label: 'Jumlah Pendaftar',
            data: spmbJurusanData,
            backgroundColor: '#8e24aa',
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

// Doughnut Chart Status SPMB
const ctxSpmbStatus = document.getElementById('chartSpmbStatus').getContext('2d');
new Chart(ctxSpmbStatus, {
    type: 'doughnut',
    data: {
        labels: spmbStatusLabels,
        datasets: [{
            data: spmbStatusData,
            backgroundColor: [
                '#4caf50', '#ff9800', '#f44336', '#2196f3', '#9c27b0', '#607d8b'
            ],
            borderWidth: 2,
            borderColor: '#fff'
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
body, .container-fluid {
    font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #e3e9f7 0%, #f5f7fa 100%);
}
.stats-card {
    position: relative;
    background: linear-gradient(120deg, #fff 60%, #e3e9f7 100%);
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(26,35,126,0.10);
    padding: 32px 24px 28px 24px;
    overflow: hidden;
    min-height: 150px;
    transition: box-shadow 0.25s, transform 0.18s;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    border: 1.5px solid #f0f0f0;
}
.stats-card:hover {
    box-shadow: 0 10px 32px rgba(26,35,126,0.18);
    transform: translateY(-4px) scale(1.04);
    border-color: #b3b3e6;
}
.stats-icon {
    font-size: 1.8rem;
    color: #fff;
    background: linear-gradient(135deg, #1a237e 60%, #3949ab 100%);
    border-radius: 50%;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    box-shadow: 0 2px 12px rgba(26,35,126,0.13);
    border: 2px solid #fff;
}
.stats-card-success .stats-icon, .stats-card-success .stats-bg { background: linear-gradient(135deg, #43a047 60%, #66bb6a 100%) !important; }
.stats-card-warning .stats-icon, .stats-card-warning .stats-bg { background: linear-gradient(135deg, #fbc02d 60%, #ffd54f 100%) !important; }
.stats-card-danger .stats-icon, .stats-card-danger .stats-bg { background: linear-gradient(135deg, #e53935 60%, #ff7043 100%) !important; }
.stats-card-primary .stats-icon, .stats-card-primary .stats-bg { background: linear-gradient(135deg, #1a237e 60%, #3949ab 100%) !important; }
.stats-content { z-index: 2; }
.stats-number { font-size: 2.3rem; font-weight: 700; color: #1a237e; margin-bottom: 0; letter-spacing: 1px; }
.stats-label { color: #888; font-size: 1.08rem; margin-bottom: 0; font-weight: 500; }
.stats-bg {
    position: absolute;
    right: 18px;
    bottom: 18px;
    font-size: 3.2rem;
    color: rgba(26,35,126,0.10);
    z-index: 1;
    pointer-events: none;
}
.stats-card-success .stats-number { color: #43a047; }
.stats-card-warning .stats-number { color: #fbc02d; }
.stats-card-danger .stats-number { color: #e53935; }
.stats-card-primary .stats-number { color: #1a237e; }
.card {
    border-radius: 18px !important;
    border: none;
    box-shadow: 0 2px 12px rgba(26,35,126,0.07);
    background: #fff;
}
.card-title {
    font-weight: 600;
    color: #1a237e;
    letter-spacing: 0.5px;
}
.btn {
    font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
    font-weight: 500;
    border-radius: 12px;
    padding: 12px 0;
    font-size: 1.08rem;
    transition: background 0.18s, box-shadow 0.18s, transform 0.15s;
    box-shadow: 0 2px 8px rgba(26,35,126,0.07);
}
.btn:hover {
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 6px 18px rgba(26,35,126,0.13);
}
.alert-info {
    border-radius: 14px;
    font-size: 1.08rem;
    background: linear-gradient(90deg, #e3e9f7 60%, #fff 100%);
    color: #1a237e;
    border: 1.5px solid #b3b3e6;
    margin-bottom: 28px;
}
@media (max-width: 991px) {
    .stats-card { min-height: 120px; padding: 18px 10px 14px 10px; }
    .stats-icon { font-size: 1.4rem; width: 32px; height: 32px; }
    .stats-bg { font-size: 2.2rem; right: 8px; bottom: 8px; }
    .stats-number { font-size: 1.2rem; }
    .card { border-radius: 12px !important; }
}
@media (max-width: 767px) {
    .row.mb-4 { flex-direction: column; }
    .stats-card { min-height: 100px; padding: 12px 6px 10px 6px; }
    .stats-icon { font-size: 1rem; width: 26px; height: 26px; }
    .stats-bg { font-size: 1.1rem; right: 4px; bottom: 4px; }
    .stats-number { font-size: 1.1rem; }
    .card { border-radius: 8px !important; }
}
.row.g-4 > [class^='col-'] {
    margin-bottom: 0 !important;
}
.card {
    margin-bottom: 0 !important;
}
@media (max-width: 991px) {
    .row.g-4 > [class^='col-'] {
        margin-bottom: 1.5rem !important;
    }
}
</style>
<?= $this->endSection() ?> 