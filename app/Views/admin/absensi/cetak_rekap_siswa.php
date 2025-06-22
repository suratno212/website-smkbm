<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="container my-4">
    <div class="no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
        <a href="<?= base_url('admin/absensi/rekap-siswa?kelas_id='.$filter_kelas.'&tanggal_mulai='.$tanggal_mulai.'&tanggal_akhir='.$tanggal_akhir) ?>" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="text-center mb-4">
        <h3 class="mb-0">REKAP ABSENSI SISWA</h3>
        <div>Periode: <?= date('d/m/Y', strtotime($tanggal_mulai)) ?> s/d <?= date('d/m/Y', strtotime($tanggal_akhir)) ?></div>
        <?php if ($filter_kelas): ?>
            <div>Kelas: <strong><?= esc(array_values(array_filter($kelas, fn($k) => $k['id'] == $filter_kelas))[0]['nama_kelas'] ?? '-') ?></strong></div>
        <?php endif; ?>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekap as $i => $r): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= esc($r['nisn']) ?></td>
                <td><?= esc($r['nama']) ?></td>
                <td class="text-success fw-bold"><?= $r['hadir'] ?></td>
                <td class="text-warning fw-bold"><?= $r['sakit'] ?></td>
                <td class="text-info fw-bold"><?= $r['izin'] ?></td>
                <td class="text-danger fw-bold"><?= $r['alpha'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 