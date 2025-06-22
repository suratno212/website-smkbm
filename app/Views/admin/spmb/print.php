<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan SPMB</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body { font-size: 14px; }
        table { font-size: 13px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-3">
            <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" style="height:70px; margin-right:20px;">
            <div>
                <h5 class="mb-0">SMK Bhakti Mulya BNS</h5>
                <small class="text-muted">Jl. Sukabumi Sanggi No. 72, Desa Gunung Ratu, dengan kode pos 34882, Telp: 082249883990, Email: smkbm.suoh@gmail.com</small>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Laporan Rekapitulasi SPMB</h4>
            <button class="btn btn-primary no-print" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Pendaftaran</th>
                    <th>Nama Lengkap</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($spmb)) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($spmb as $p) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $p['no_pendaftaran']; ?></td>
                            <td><?= $p['nama_lengkap']; ?></td>
                            <td><?= $p['jurusan_pilihan']; ?></td>
                            <td><?= $p['status_pendaftaran']; ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pendaftar</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!--TANDA TANGAN KEPSEK-->
        <div style="width: 100%; margin-top: 60px;">
            <div style="width: 300px; float: right; text-align: center;">
                <div>Mengetahui,<br>Kepala Sekolah</div>
                <br><br><br>
                <div style="font-weight: bold; text-decoration: underline;">Joni Haryanto, S.T</div>
                <div>NIP: 012345</div>
            </div>
        </div>
    </div>
</body>
</html> 