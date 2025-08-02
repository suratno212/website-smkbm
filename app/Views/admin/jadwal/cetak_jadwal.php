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
    <div class="row align-items-center mb-2">
        <div class="col-2 text-center">
            <img src="<?= base_url('public/assets/images/logo.png') ?>" alt="Logo" style="max-width:80px;max-height:80px;">
        </div>
        <div class="col-10 text-center">
            <h4 class="mb-0" style="font-weight:bold;">SMK BHAKTI MULYA BNS</h4>
            <div style="font-size:1.1rem;">Jl. Contoh Alamat No. 123, Kota, Provinsi</div>
            <div style="font-size:1rem;">Telp. (021) 12345678 | Website: www.smkbmbns.sch.id</div>
        </div>
    </div>
    <hr style="border:2px solid #000; margin-top:0; margin-bottom:1.5rem;">
    <div class="no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
        <a href="<?= base_url('admin/jadwal') ?>" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="text-center mb-4">
        <h3 class="mb-0">JADWAL PELAJARAN</h3>
        <?php if ($kelas): ?>
            <div>Kelas: <strong><?= esc($kelas['nama_kelas']) ?></strong></div>
        <?php endif; ?>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jadwal as $i => $j): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= esc($j['hari']) ?></td>
                <td><?= esc($j['jam_mulai']) ?> - <?= esc($j['jam_selesai']) ?></td>
                <td><?= esc($j['nama_mapel']) ?></td>
                <td><?= esc($j['nama_guru']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 