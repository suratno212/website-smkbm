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
        <a href="<?= base_url('admin/absensi/rekap-guru?guru_id='.$filter_guru.'&tanggal_mulai='.$tanggal_mulai.'&tanggal_akhir='.$tanggal_akhir) ?>" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="text-center mb-4">
        <h3 class="mb-0">REKAP ABSENSI GURU</h3>
        <div>Periode: <?= date('d/m/Y', strtotime($tanggal_mulai)) ?> s/d <?= date('d/m/Y', strtotime($tanggal_akhir)) ?></div>
        <?php if ($filter_guru): ?>
            <div>Guru: <strong><?= esc(array_values(array_filter($guru, fn($g) => $g['id'] == $filter_guru))[0]['nama'] ?? '-') ?></strong></div>
        <?php endif; ?>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekap as $i => $r): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                <td class="fw-bold <?= $r['status']=='Hadir'?'text-success':($r['status']=='Izin'?'text-info':($r['status']=='Sakit'?'text-warning':'text-danger')) ?>">
                    <?= esc($r['status']) ?>
                </td>
                <td><?= esc($r['keterangan']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 