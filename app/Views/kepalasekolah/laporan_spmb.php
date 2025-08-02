<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Laporan SPMB</h3>
    <form class="row g-3 align-items-end mb-4" method="get">
        <div class="col-md-3">
            <label class="form-label">Tahun</label>
            <select name="tahun" class="form-select" onchange="this.form.submit()">
                <?php for($y = date('Y')-3; $y <= date('Y')+1; $y++): ?>
                    <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </form>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Pendaftar</h5>
                    <h2><?= $totalPendaftar ?></h2>
                </div>
            </div>
        </div>
        <?php foreach($statStatus as $status => $jumlah): ?>
        <div class="col-md-2">
            <div class="card text-bg-light mb-3">
                <div class="card-body text-center">
                    <h6 class="card-title text-capitalize"><?= $status ?></h6>
                    <h4><?= $jumlah ?></h4>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <canvas id="barJurusan"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="pieStatus"></canvas>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Tabel Data Pendaftar</h5>
                <a href="<?= base_url('kepalasekolah/laporan-spmb/cetak?tahun=' . $tahun) ?>" target="_blank" class="btn btn-success"><i class="fas fa-print"></i> Cetak Laporan</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabelPendaftar">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Asal Sekolah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pendaftar as $i => $p): ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= esc($p['nama'] ?? '-') ?></td>
                            <td><?= esc($p['jurusan'] ?? '-') ?></td>
                            <td><?= esc($p['nilai'] ?? '-') ?></td>
                            <td><?= esc($p['status'] ?? '-') ?></td>
                            <td><?= esc($p['asal_sekolah'] ?? '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
<script>
$(document).ready(function() {
    $('#tabelPendaftar').DataTable();
});
// Bar Chart Jurusan
const ctxBar = document.getElementById('barJurusan').getContext('2d');
const barJurusan = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($statJurusan, 'nama_jurusan')) ?>,
        datasets: [{
            label: 'Jumlah Pendaftar',
            data: <?= json_encode(array_column($statJurusan, 'total')) ?>,
            backgroundColor: '#1a237e',
        }]
    },
    options: {responsive: true, plugins: {legend: {display: false}}}
});
// Pie Chart Status
const ctxPie = document.getElementById('pieStatus').getContext('2d');
const pieStatus = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_map('ucfirst', array_keys($statStatus))) ?>,
        datasets: [{
            data: <?= json_encode(array_values($statStatus)) ?>,
            backgroundColor: ['#1a237e','#1976d2','#43a047','#fbc02d','#e53935'],
        }]
    },
    options: {responsive: true}
});
</script>
<?= $this->endSection() ?> 