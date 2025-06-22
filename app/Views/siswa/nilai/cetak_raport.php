<?php helper('url'); ?>
<?php
// Ganti logo sekolah dan yayasan dengan gambar PNG/JPG dari internet bebas (Unsplash)
$logoSekolah = 'https://scontent.ftkg1-1.fna.fbcdn.net/v/t39.30808-6/509840812_1187690260039281_1073171614447097024_n.jpg?stp=dst-jpg_p526x296_tt6&_nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeELHT_qcCFUizj2_Gv-UylyRICmpduDlhNEgKal24OWE8lEftBwlgJrXUmryuTxLa8vOFAAFWMm-AQwLCxJAB08&_nc_ohc=E7Rt4Clt5-AQ7kNvwF_oEif&_nc_oc=Adn8YlBSdH-1lUcuJN82UEUDknvShpKmJ2n2osbrNDr_jK8O2fdUvQcVw1jmh_oI5W4&_nc_zt=23&_nc_ht=scontent.ftkg1-1.fna&_nc_gid=YvVQShVIj5qBU677HOXEXQ&oh=00_AfPtzPGat860lHSCGpcxILZeNtudSsUi7x68oP8R5XNT3A&oe=685DC721';
$logoYayasan = 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/640px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png';
// Deteksi jika sedang dicetak Dompdf (CLI atau HTTP_USER_AGENT mengandung Dompdf)
$isDompdf = (php_sapi_name() === 'cli' || (isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'dompdf') !== false));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>e-Raport Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, h3, h4 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background: #1a237e; color: #fff; }
        .section-title { background: #e3e3e3; font-weight: bold; text-align: left; padding: 6px; }
        .identitas-table td { border: none; text-align: left; padding: 2px 8px; }
        .header-logo { width: 70px; }
        .header-table { width: 100%; border: none; margin-bottom: 0; }
        .header-table td { border: none; text-align: center; }
        .garis { border-bottom: 2px solid #000; margin: 8px 0 16px 0; }
        .catatan-box { border: 1px solid #aaa; padding: 10px; margin-bottom: 16px; background: #f8f8f8; }
    </style>
</head>
<body>
    <?php // ================= HEADER KOP SEKOLAH & YAYASAN ================= ?>
    <table class="header-table">
        <tr>
            <td style="width:80px; text-align:left;">
                <img src="<?= $logoSekolah ?>" class="header-logo">
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
                <img src="<?= $logoYayasan ?>" class="header-logo">
            </td>
        </tr>
    </table>
    <div class="garis"></div>
    <h4 style="margin-bottom:10px;">LAPORAN HASIL BELAJAR (E-RAPORT)</h4>

    <?php if ($isDompdf): ?>
        <div style="font-size:10px; color:#888;">Path logo sekolah: <?= $logoSekolah ?></div>
        <div style="font-size:10px; color:#888;">Path logo yayasan: <?= $logoYayasan ?></div>
    <?php endif; ?>

    <?php // ================= IDENTITAS SISWA & WALI KELAS ================= ?>
    <table class="identitas-table" style="width:70%; margin-bottom:10px;">
        <tr><td><b>Nama Siswa</b></td><td>: <?= esc($siswa['nama']) ?></td><td><b>Jurusan</b></td><td>: <?= esc($kelas['nama_jurusan'] ?? '-') ?></td></tr>
        <tr><td><b>NIS</b></td><td>: <?= esc($siswa['nisn']) ?></td><td><b>Kelas</b></td><td>: <?= esc($kelas['nama_kelas']) ?></td></tr>
        <tr><td><b>Nama Sekolah</b></td><td>: SMK Bhakti Mulya BNS</td><td><b>Semester</b></td><td>: <?= esc($semester) ?></td></tr>
        <tr><td><b>Alamat</b></td><td colspan="3">: Gunung Ratu BNS</td></tr>
        <tr><td><b>Wali Kelas</b></td><td>: <?= esc($kelas['nama_wali_kelas'] ?? ($wali_kelas['nama'] ?? '-')) ?></td><td><b>Tahun Ajaran</b></td><td>: <?= esc($tahunAkademik['tahun'] ?? (date('Y').'/'.(date('Y')+1))) ?></td></tr>
        <tr><td><b>NIP/NUPTK Wali Kelas</b></td><td>: <?= esc($wali_kelas['nip_nuptk'] ?? '-') ?></td><td><b>Peringkat</b></td><td>: <?= $ranking ?? '-' ?></td></tr>
    </table>

    <?php // ================= TABEL NILAI AKADEMIK ================= ?>
    <div class="section-title">Nilai Akademik</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Tugas</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=1; $total=0; $count=0;
            foreach($nilai as $n): ?>
            <?php $mapelNama = ''; foreach($mapel as $m) { if($m['id']==$n['mapel_id']) $mapelNama=$m['nama_mapel']; } ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($mapelNama) ?></td>
                <td><?= esc($n['uts']) ?></td>
                <td><?= esc($n['uas']) ?></td>
                <td><?= esc($n['tugas']) ?></td>
                <td><?= esc($n['akhir']) ?></td>
            </tr>
            <?php $total += $n['akhir']; $count++; endforeach; ?>
        </tbody>
    </table>
    <table style="width:40%; margin-bottom:10px;">
        <tr>
            <td style="text-align:right;"><b>Total Nilai</b></td>
            <td style="text-align:center;">: <?= $total ?></td>
        </tr>
        <tr>
            <td style="text-align:right;"><b>Rata-rata</b></td>
            <td style="text-align:center;">: <?= $count ? number_format($total/$count,2) : 0 ?></td>
        </tr>
    </table>

    <?php // ================= TABEL EKSTRAKURIKULER ================= ?>
    <div class="section-title">Kegiatan Ekstrakurikuler</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Ekstrakurikuler</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($ekskul as $e): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($e['nama_ekstrakurikuler']) ?></td>
                <td><?= esc($e['nilai']) ?></td>
                <td><?= esc($e['keterangan']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php // ================= TABEL ABSENSI ================= ?>
    <div class="section-title">Absensi</div>
    <table>
        <thead>
            <tr>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpha</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= count(array_filter($absensi, fn($a)=>$a['status']=='Hadir')) ?></td>
                <td><?= count(array_filter($absensi, fn($a)=>$a['status']=='Sakit')) ?></td>
                <td><?= count(array_filter($absensi, fn($a)=>$a['status']=='Izin')) ?></td>
                <td><?= count(array_filter($absensi, fn($a)=>$a['status']=='Alpha')) ?></td>
            </tr>
        </tbody>
    </table>

    <?php // ================= CATATAN WALI KELAS OTOMATIS ================= ?>
    <div class="section-title">Catatan Wali Kelas</div>
    <div class="catatan-box">
        <?= $catatan ?? '' ?>
    </div>
    <br><br>

    <?php // ================= TANDA TANGAN & PENGESAHAN ================= ?>
    <table style="width:100%; border:none;">
        <tr>
            <td colspan="3" style="border:none; text-align:right; padding-right:40px;">
                Mengetahui,<br>
                Lampung Barat, <?= date('d-m-Y') ?>
            </td>
        </tr>
        <tr>
            <td style="border:none; text-align:center;">Wali Kelas</td>
            <td style="border:none; text-align:center;">Orang Tua/Wali</td>
            <td style="border:none; text-align:center;">Siswa</td>
        </tr>
        <tr><td colspan="3" style="border:none; height:40px;"></td></tr>
        <tr>
            <td style="border:none; text-align:center; line-height:1.2;">
                <?= esc($wali_kelas['nama'] ?? ($kelas['nama_wali_kelas'] ?? '-')) ?><br>
                ____________________<br>
                <?= esc($wali_kelas['nip_nuptk'] ?? '-') ?>
            </td>
            <td style="border:none; text-align:center; line-height:1.2;">
                <br>____________________<br>
            </td>
            <td style="border:none; text-align:center; line-height:1.2;">
                <?= esc($siswa['nama']) ?><br>
                ____________________<br>
                <?= esc($siswa['nisn']) ?>
            </td>
        </tr>
    </table>
</body>
</html> 