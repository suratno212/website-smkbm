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
        <a href="<?= base_url('admin/siswa') ?>" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="text-center mb-4">
        <img src="<?= base_url('public/images/logo.png') ?>" alt="Logo" style="height:70px; margin-bottom:10px;">
        <h3 class="mb-0 mt-2">SMK BHAKTI MULYA</h3>
        <h4 class="mb-0">DAFTAR SISWA</h4>
        <div>Filter:
            <?php if (!empty($filters['kd_kelas'])): ?>
                Kelas: <strong><?= esc(array_values(array_filter($kelas, fn($k) => $k['kd_kelas'] == $filters['kd_kelas']))[0]['nama_kelas'] ?? '-') ?></strong>
            <?php endif; ?>
            <?php if (!empty($filters['kd_jurusan'])): ?>
                , Jurusan: <strong><?= esc(array_values(array_filter($jurusan, fn($j) => $j['kd_jurusan'] == $filters['kd_jurusan']))[0]['nama_jurusan'] ?? '-') ?></strong>
            <?php endif; ?>
            <?php if (!empty($filters['nis'])): ?>
                , NIS: <strong><?= esc($filters['nis']) ?></strong>
            <?php endif; ?>
            <?php if (!empty($filters['nama'])): ?>
                , Nama: <strong><?= esc($filters['nama']) ?></strong>
            <?php endif; ?>
        </div>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Alamat</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($siswa as $i => $s): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= esc($s['nis']) ?></td>
                <td><?= esc($s['nama']) ?></td>
                <td><?= esc($s['nama_kelas']) ?></td>
                <td><?= esc($s['nama_jurusan']) ?></td>
                <td><?= esc($s['jenis_kelamin']) ?></td>
                <td><?= esc($s['agama']) ?></td>
                <td><?= esc($s['alamat']) ?></td>
                <td><?= esc($s['no_hp']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 