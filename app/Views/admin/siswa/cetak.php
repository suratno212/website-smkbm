<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - SMK BM</title>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: #fff; }
            .container { box-shadow: none !important; border-radius: 0; }
            .garis, .section-title, table, th, td { box-shadow: none !important; }
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            background: #f4f8fb;
            color: #222;
            margin: 0;
            padding: 20px;
        }
        
        .print-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 2px 8px #e3e3e3;
            padding: 18px 24px 8px 24px;
            border-radius: 10px;
        }
        
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 0;
        }
        
        .header-table td {
            border: none;
            text-align: center;
        }
        
        .header-logo {
            width: 60px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #e3e3e3;
        }
        
        .garis {
            border-bottom: 2px solid #1a237e;
            margin: 8px 0 12px 0;
        }
        
        .filters {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #1a237e;
        }
        
        .filters h4 {
            margin: 0 0 10px 0;
            color: #1a237e;
        }
        
        .section-title {
            background: #1a237e;
            color: #fff;
            font-weight: bold;
            text-align: left;
            padding: 7px 12px;
            border-radius: 4px 4px 0 0;
            margin-bottom: 0;
            font-size: 13px;
        }
        
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        
        .filter-label {
            font-weight: bold;
            color: #555;
        }
        
        .filter-value {
            color: #1a237e;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            background: #fff;
        }
        
        th, td {
            border: 1px solid #1a237e;
            padding: 5px 7px;
            text-align: left;
        }
        
        th {
            background: #1a237e !important;
            color: #fff !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: 1px solid #fff !important;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e9ecef;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        .print-btn {
            background: #1a237e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .print-btn:hover {
            background: #3949ab;
        }
        
        .back-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            margin-left: 10px;
            text-decoration: none;
            display: inline-block;
        }
        
        .back-btn:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }
        
        .summary {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2196f3;
        }
        
        .summary h4 {
            margin: 0 0 10px 0;
            color: #1976d2;
        }
        
        .summary p {
            margin: 5px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="no-print">
            <button class="print-btn" onclick="window.print()">🖨️ Cetak</button>
            <a href="<?= base_url('admin/siswa') ?>" class="back-btn">← Kembali</a>
        </div>
        
        <!-- HEADER SEKOLAH & YAYASAN -->
        <table class="header-table" style="margin-bottom: 0; width: 100%; border: none;">
            <tr>
                <td style="width:70px; text-align:left; vertical-align:top;">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQOvRXne5UoW788ugKsxXIhxMHiP9tQm5lIpQ&s" class="header-logo" style="width: 60px; border-radius: 8px; box-shadow: 0 2px 8px #e3e3e3;">
                </td>
                <td style="text-align:center; vertical-align:top;">
                    <div style="font-size:13px; font-weight:600; letter-spacing:1px;">PEMERINTAH PROVINSI LAMPUNG</div>
                    <div style="font-size:12px; font-weight:600;">DINAS PENDIDIKAN DAN KEBUDAYAAN LAMPUNG BARAT</div>
                    <div style="font-size:14px; font-weight:bold; margin-bottom:2px;">YAYASAN PENDIDIKAN BHAKTI MULYA (YPBM)</div>
                    <div style="font-size:18px; font-weight:bold; letter-spacing:1px; color:#1a237e;">SMK BHAKTI MULYA BNS</div>
                    <div style="font-size:12px;">Gunung Ratu BNS</div>
                    <div style="font-size:11px;">Telp: (0728) 123456 | Email: info@smkbhaktimulya.sch.id</div>
                </td>
                <td style="width:70px; text-align:right; vertical-align:top;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/640px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png" class="header-logo" style="width: 60px; border-radius: 8px; box-shadow: 0 2px 8px #e3e3e3;">
                </td>
            </tr>
        </table>
        <div class="garis" style="border-bottom: 2px solid #1a237e; margin: 8px 0 12px 0;"></div>
        <h4 style="margin-bottom:14px; margin-top:0; font-size:15px; letter-spacing:0.5px; text-align: center;"><?= $title ?></h4>
        <p style="margin-top: 10px; text-align: center; font-size: 12px;">Tanggal Cetak: <?= date('d/m/Y H:i') ?></p>
        
        <?php if (!empty($filters['nis']) || !empty($filters['nama']) || !empty($filters['kd_kelas']) || !empty($filters['kd_jurusan'])): ?>
        <div class="filters">
            <h4>Filter yang Diterapkan:</h4>
            <?php if (!empty($filters['nis'])): ?>
                <div class="filter-item">
                    <span class="filter-label">NIS:</span>
                    <span class="filter-value"><?= $filters['nis'] ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($filters['nama'])): ?>
                <div class="filter-item">
                    <span class="filter-label">Nama:</span>
                    <span class="filter-value"><?= $filters['nama'] ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($filters['kd_kelas'])): ?>
                <div class="filter-item">
                    <span class="filter-label">Kelas:</span>
                    <span class="filter-value">
                        <?php 
                        $kelas = array_filter($kelas, function($k) use ($filters) {
                            return $k['kd_kelas'] == $filters['kd_kelas'];
                        });
                        echo !empty($kelas) ? reset($kelas)['nama_kelas'] : $filters['kd_kelas'];
                        ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($filters['kd_jurusan'])): ?>
                <div class="filter-item">
                    <span class="filter-label">Jurusan:</span>
                    <span class="filter-value">
                        <?php 
                        $jurusan = array_filter($jurusan, function($j) use ($filters) {
                            return $j['kd_jurusan'] == $filters['kd_jurusan'];
                        });
                        echo !empty($jurusan) ? reset($jurusan)['nama_jurusan'] : $filters['kd_jurusan'];
                        ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="summary">
            <h4>Ringkasan Data:</h4>
            <p><strong>Total Siswa:</strong> <?= count($siswa) ?> orang</p>
            <?php if (!empty($siswa)): ?>
                <p><strong>Rentang NIS:</strong> <?= min(array_column($siswa, 'nis')) ?> - <?= max(array_column($siswa, 'nis')) ?></p>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($siswa)): ?>
        <div class="section-title">DATA SISWA</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($siswa as $s): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $s['nis'] ?></td>
                    <td><?= $s['nama'] ?></td>
                    <td><?= $s['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                    <td><?= date('d/m/Y', strtotime($s['tanggal_lahir'])) ?></td>
                    <td><?= $s['nama_kelas'] ?? '-' ?></td>
                    <td><?= $s['nama_jurusan'] ?? '-' ?></td>
                    <td><?= $s['alamat'] ?></td>
                    <td><?= $s['no_hp'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-data">
            <h3>Tidak ada data siswa yang ditemukan</h3>
            <p>Coba ubah filter pencarian Anda</p>
        </div>
        <?php endif; ?>
        
        <div style="margin-top: 40px; text-align: center; color: #666; font-size: 12px;">
            <p>Dicetak pada: <?= date('d/m/Y H:i:s') ?></p>
            <p>Oleh: <?= session()->get('name') ?? session()->get('username') ?></p>
        </div>
    </div>
</body>
</html> 