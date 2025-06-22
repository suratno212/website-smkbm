<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #e3e3e3; }
        h2 { margin-bottom: 20px; }
    </style>
</head>
<body onload="window.print()">
    <h2><?= $title ?></h2>
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
            <?php $i = 1; foreach ($kelas as $k) : ?>
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