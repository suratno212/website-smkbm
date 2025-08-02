<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #e3e3e3;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body onload="window.print()">
    <table class="header-table" style="margin-bottom: 0; width:100%; border:none;">
        <tr>
            <td style="width:70px; text-align:left; vertical-align:top; border:none;">
                <img src="<?= base_url('assets/images/logo.png') ?>" class="header-logo" style="width:60px; border-radius:8px;">
            </td>
            <td style="text-align:center; vertical-align:top; border:none;">
                <div style="font-size:13px; font-weight:600; letter-spacing:1px;">PEMERINTAH PROVINSI LAMPUNG</div>
                <div style="font-size:12px; font-weight:600;">DINAS PENDIDIKAN DAN KEBUDAYAAN LAMPUNG BARAT</div>
                <div style="font-size:14px; font-weight:bold; margin-bottom:2px;">YAYASAN PENDIDIKAN BHAKTI MULYA (YPBM)</div>
                <div style="font-size:18px; font-weight:bold; letter-spacing:1px; color:#1a237e;">SMK BHAKTI MULYA BNS</div>
                <div style="font-size:12px;">Gunung Ratu BNS</div>
                <div style="font-size:11px;">Telp: (0728) 123456 | Email: info@smkbhaktimulya.sch.id</div>
            </td>
            <td style="width:70px; text-align:right; vertical-align:top; border:none;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/640px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png" class="header-logo" style="width:60px; border-radius:8px;">
            </td>
        </tr>
    </table>
    <div class="garis" style="border-bottom:2.5px solid #1a237e; margin:8px 0 18px 0;"></div>
    <h2 style="text-align:center; margin-bottom:20px;">DAFTAR KELAS</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Tingkat</th>
                <th>Jurusan</th>
                <th>Wali Kelas</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($kelas as $k) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $k['nama_kelas'] ?></td>
                    <td><?= $k['tingkat'] ?></td>
                    <td><?= $k['nama_jurusan'] ?></td>
                    <td><?= $k['nama_wali_kelas'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>