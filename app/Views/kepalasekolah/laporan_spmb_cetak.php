<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?> - <?= $tahun ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; color: #222; }
        h2, h4 { margin: 0 0 10px 0; }
        .stat { display: inline-block; margin-right: 30px; font-size: 1.1em; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px 10px; font-size: 13px; }
        th { background: #1a237e; color: #fff; }
        .text-center { text-align: center; }
        @media print {
            .no-print { display: none; }
            th, td { font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom:16px;">
        <button onclick="window.print()" style="padding:8px 18px; font-size:15px;">Cetak</button>
        <button onclick="window.close()" style="padding:8px 18px; font-size:15px;">Tutup</button>
    </div>
    <h2>Laporan SPMB Tahun <?= $tahun ?></h2>
    <div style="margin-bottom:18px;">
        <span class="stat"><strong>Total Pendaftar:</strong> <?= $totalPendaftar ?></span>
        <?php foreach($statStatus as $status => $jumlah): ?>
            <span class="stat"><strong><?= ucfirst($status) ?>:</strong> <?= $jumlah ?></span>
        <?php endforeach; ?>
    </div>
    <h4>Rekap Pendaftar per Jurusan</h4>
    <table style="width:400px; margin-bottom:20px;">
        <tr>
            <th>Jurusan</th>
            <th>Jumlah</th>
        </tr>
        <?php foreach($statJurusan as $j): ?>
        <tr>
            <td><?= esc($j['nama_jurusan']) ?></td>
            <td class="text-center"><?= $j['total'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h4>Data Pendaftar</h4>
    <table>
        <thead>
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
                <td class="text-center"><?= $i+1 ?></td>
                <td><?= esc($p['nama_lengkap'] ?? '-') ?></td>
                <td><?= esc($p['jurusan_pilihan'] ?? '-') ?></td>
                <td class="text-center"><?= esc($p['nilai'] ?? '-') ?></td>
                <td><?= esc($p['status_pendaftaran'] ?? '-') ?></td>
                <td><?= esc($p['asal_sekolah'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="margin-top:40px; text-align:right; font-size:13px;">
        Dicetak pada: <?= date('d-m-Y H:i') ?>
    </div>
</body>
</html> 