<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Nilai Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2,
        h4 {
            margin-bottom: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px 10px;
            text-align: center;
        }

        th {
            background: #eee;
        }

        .info {
            margin-bottom: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <?php
    $logoSekolah = 'https://scontent.ftkg1-1.fna.fbcdn.net/v/t39.30808-6/509840812_1187690260039281_1073171614447097024_n.jpg?stp=dst-jpg_p526x296_tt6&_nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeELHT_qcCFUizj2_Gv-UylyRICmpduDlhNEgKal24OWE8lEftBwlgJrXUmryuTxLa8vOFAAFWMm-AQwLCxJAB08&_nc_ohc=E7Rt4Clt5-AQ7kNvwF_oEif&_nc_oc=Adn8YlBSdH-1lUcuJN82UEUDknvShpKmJ2n2osbrNDr_jK8O2fdUvQcVw1jmh_oI5W4&_nc_zt=23&_nc_ht=scontent.ftkg1-1.fna&_nc_gid=YvVQShVIj5qBU677HOXEXQ&oh=00_AfPtzPGat860lHSCGpcxILZeNtudSsUi7x68oP8R5XNT3A&oe=685DC721';
    $logoYayasan = 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/640px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png';
    ?>
    <table class="header-table" style="width:100%; border:none; margin-bottom:0;">
        <tr>
            <td style="width:80px; text-align:left;">
                <img src="<?= $logoSekolah ?>" style="width:70px;">
            </td>
            <td style="text-align:center;">
                <h4 style="margin-bottom:2px;">PEMERINTAH PROVINSI LAMPUNG</h4>
                <h4 style="margin-bottom:2px;">DINAS PENDIDIKAN DAN KEBUDAYAAN LAMPUNG BARAT</h4>
                <div style="font-weight:bold; font-size:15px; margin-bottom:2px;">YAYASAN PENDIDIKAN BHAKTI MULYA (YPBM)</div>
                <h3 style="font-size:20px; letter-spacing:1px; margin-bottom:2px;">SMK BHAKTI MULYA BNS</h3>
                <div style="font-size:13px;">Gunung Ratu BNS</div>
                <div style="font-size:12px;">Telp: (0728) 123456 | Email: info@smkbhaktimulya.sch.id</div>
            </td>
            <td style="width:80px; text-align:right;">
                <img src="<?= $logoYayasan ?>" style="width:70px;">
            </td>
        </tr>
    </table>
    <div style="border-bottom:2px solid #000; margin:8px 0 16px 0;"></div>
    <h4 style="margin-bottom:10px; text-align:center;">DAFTAR NILAI SISWA</h4>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Print</button>
        <button onclick="window.close()">Tutup</button>
    </div>
    <h2>Daftar Nilai Siswa</h2>
    <div class="info">
        <strong>Kelas:</strong> <?= esc($kelas['nama_kelas'] ?? '-') ?><br>
        <strong>Mata Pelajaran:</strong> <?= esc($mapel['nama_mapel'] ?? '-') ?><br>
        <strong>Semester:</strong> <?= esc($semester) ?><br>
        <strong>Tahun Akademik:</strong> <?= esc($tahun_akademik['nama'] ?? ($tahun_akademik['kd_tahun_akademik'] ?? '-')) ?>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($nilai_list)): foreach ($nilai_list as $i => $n): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($n['nama_siswa']) ?></td>
                        <td><?= esc($n['nis']) ?></td>
                        <td><?= esc($n['nilai_tugas']) ?></td>
                        <td><?= esc($n['nilai_uts']) ?></td>
                        <td><?= esc($n['nilai_uas']) ?></td>
                        <td><?= esc($n['nilai_akhir']) ?></td>
                    </tr>
                <?php endforeach;
            else: ?>
                <tr>
                    <td colspan="7">Tidak ada data nilai.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>