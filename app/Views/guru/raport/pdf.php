<?php helper('url'); ?>
<?php
// Ganti logo sekolah dan yayasan dengan gambar yang sama seperti siswa
$logoSekolah = 'https://scontent.ftkg1-1.fna.fbcdn.net/v/t39.30808-6/509840812_1187690260039281_1073171614447097024_n.jpg?stp=dst-jpg_p526x296_tt6&_nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeELHT_qcCFUizj2_Gv-UylyRICmpduDlhNEgKal24OWE8lEftBwlgJrXUmryuTxLa8vOFAAFWMm-AQwLCxJAB08&_nc_ohc=E7Rt4Clt5-AQ7kNvwF_oEif&_nc_oc=Adn8YlBSdH-1lUcuJN82UEUDknvShpKmJ2n2osbrNDr_jK8O2fdUvQcVw1jmh_oI5W4&_nc_zt=23&_nc_ht=scontent.ftkg1-1.fna&_nc_gid=YvVQShVIj5qBU677HOXEXQ&oh=00_AfPtzPGat860lHSCGpcxILZeNtudSsUi7x68oP8R5XNT3A&oe=685DC721';
$logoYayasan = 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/640px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png';
$isDompdf = (php_sapi_name() === 'cli' || (isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'dompdf') !== false));

// Deteksi jurusan
$jurusan = strtolower($kelas['nama_jurusan'] ?? '');

// Kelompok mapel per jurusan
$kelompokMapel = [];
if (strpos($jurusan, 'tkj') !== false) {
    $kelompokMapel = [
        'A' => [
            'label' => 'A. Muatan Nasional',
            'sub' => [
                'Pendidikan Agama dan Budi Pekerti',
                'Pendidikan Pancasila dan Kewarganegaraan',
                'Bahasa Indonesia',
                'Matematika',
                'Sejarah Indonesia',
                'Bahasa Inggris dan Bahasa Asing Lainnya',
            ]
        ],
        'B' => [
            'label' => 'B. Muatan Kewilayahan',
            'sub' => [
                'Seni Budaya',
                'Pendidikan Jasmani, Olahraga dan Kesehatan',
            ]
        ],
        'C1' => [
            'label' => 'C1. Dasar Bidang Keahlian',
            'sub' => [
                'Simulasi dan Komunikasi Digital',
                'Fisika',
                'Kimia',
            ]
        ],
        'C2' => [
            'label' => 'C2. Dasar Program Keahlian',
            'sub' => [
                'Sistem Komputer',
                'Komputer dan Jaringan Dasar',
                'Pemrograman Dasar',
                'Dasar Desain Grafis',
            ]
        ],
        'C3' => [
            'label' => 'C3. Kompetensi Keahlian',
            'sub' => [
                'Teknologi Jaringan Berbasis Luas (WAN)',
                'Administrasi Infrastruktur Jaringan',
                'Administrasi Sistem Jaringan',
                'Teknologi Layanan Jaringan',
                'Produk Kreatif dan Kewirausahaan',
            ]
        ],
    ];
} elseif (strpos($jurusan, 'tbsm') !== false) {
    $kelompokMapel = [
        'A' => [
            'label' => 'A. Muatan Nasional',
            'sub' => [
                'Pendidikan Agama dan Budi Pekerti',
                'Pendidikan Pancasila dan Kewarganegaraan',
                'Bahasa Indonesia',
                'Matematika',
                'Sejarah Indonesia',
                'Bahasa Inggris dan Bahasa Asing Lainnya',
            ]
        ],
        'B' => [
            'label' => 'B. Muatan Kewilayahan',
            'sub' => [
                'Seni Budaya',
                'Pendidikan Jasmani, Olahraga dan Kesehatan',
            ]
        ],
        'C1' => [
            'label' => 'C1. Dasar Bidang Keahlian',
            'sub' => [
                'Simulasi dan Komunikasi Digital',
                'Fisika',
                'Kimia',
            ]
        ],
        'C2' => [
            'label' => 'C2. Dasar Program Keahlian',
            'sub' => [
                'Gambar Teknik Otomotif',
                'Teknologi Dasar Otomotif',
                'Pekerjaan Dasar Teknik Otomotif',
            ]
        ],
        'C3' => [
            'label' => 'C3. Kompetensi Keahlian',
            'sub' => [
                'Pemeliharaan Mesin Sepeda Motor',
                'Pemeliharaan Sasis Sepeda Motor',
                'Pemeliharaan Kelistrikan Sepeda Motor',
                'Pengelolaan Bengkel Sepeda Motor',
                'Produk Kreatif dan Kewirausahaan',
            ]
        ],
    ];
}

// Index mapel berdasarkan kelompok dan urutan
$mapelByKelompok = [];
foreach ($mapel as $m) {
    $mapelByKelompok[$m['kelompok']][] = $m;
}

// Ambil nilai per mapel
function getNilaiByMapel($nilai, $mapel_id) {
    foreach ($nilai as $n) if ($n['mapel_id'] == $mapel_id) return $n;
    return null;
}

$totalNilai = 0;
$totalMapel = 0;
$jumlahKelompok = [];
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

    <table class="identitas-table" style="width:70%; margin-bottom:10px;">
        <tr><td><b>Nama Siswa</b></td><td>: <?= esc($siswa['nama']) ?></td><td><b>Jurusan</b></td><td>: <?= esc($kelas['nama_jurusan'] ?? '-') ?></td></tr>
        <tr><td><b>NIS</b></td><td>: <?= esc($siswa['nis']) ?></td><td><b>Kelas</b></td><td>: <?= esc($kelas['nama_kelas']) ?></td></tr>
        <tr><td><b>Nama Sekolah</b></td><td>: SMK Bhakti Mulya BNS</td><td><b>Semester</b></td><td>: <?= esc($semester) ?></td></tr>
        <tr><td><b>Alamat</b></td><td colspan="3">: Gunung Ratu BNS</td></tr>
        <tr><td><b>Wali Kelas</b></td><td>: <?= esc($kelas['nama_wali_kelas'] ?? ($wali_kelas['nama'] ?? '-')) ?></td><td><b>Tahun Ajaran</b></td><td>: <?= esc($tahunAkademik['tahun'] ?? (date('Y').'/'.(date('Y')+1))) ?></td></tr>
        <tr><td><b>NIK/NIP Wali Kelas</b></td><td>: <?= esc($wali_kelas['nik_nip'] ?? '-') ?></td><td><b>Peringkat</b></td><td>: <?= $ranking ?? '-' ?></td></tr>
    </table>

    <div class="section-title">Nilai Akademik</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th style="text-align:left;">Mata Pelajaran</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Tugas</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach ($kelompokMapel as $kode => $kelompok): ?>
            <tr>
                <td colspan="6" style="text-align:left; font-weight:bold; background:#e3e3e3;"> <?= $kelompok['label'] ?> </td>
            </tr>
            <?php $jumlahKelompok[$kode] = 0; foreach ($kelompok['sub'] as $namaMapel): ?>
            <?php 
                $mapelObj = null;
                foreach (($mapelByKelompok[$kode] ?? []) as $m) {
                    if (trim(strtolower($m['nama_mapel'])) == trim(strtolower($namaMapel))) {
                        $mapelObj = $m;
                        break;
                    }
                }
                $nilaiMapel = $mapelObj ? getNilaiByMapel($nilai, $mapelObj['id']) : null;
                ?>
            <tr>
                <td><?= $no++ ?></td>
                    <td style="text-align:left;"><?= esc($namaMapel) ?></td>
                    <td><?= $nilaiMapel ? esc($nilaiMapel['uts']) : '-' ?></td>
                    <td><?= $nilaiMapel ? esc($nilaiMapel['uas']) : '-' ?></td>
                    <td><?= $nilaiMapel ? esc($nilaiMapel['tugas']) : '-' ?></td>
                    <td><?= $nilaiMapel ? esc($nilaiMapel['akhir']) : '-' ?></td>
                </tr>
                <?php if ($nilaiMapel) { $totalNilai += $nilaiMapel['akhir']; $jumlahKelompok[$kode] += $nilaiMapel['akhir']; $totalMapel++; } ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="5" style="text-align:right; font-weight:bold;">Total Jumlah Nilai <?= ltrim(strstr($kelompok['label'], '. '), '. ') ?></td>
                <td style="font-weight:bold;"> <?= $jumlahKelompok[$kode] ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <table style="width:40%; margin-bottom:10px;">
        <tr>
            <td style="text-align:right;"><b>Total Nilai Akademik</b></td>
            <td style="text-align:center;">: <?= $totalNilai ?></td>
        </tr>
        <tr>
            <td style="text-align:right;"><b>Rata-rata Akademik</b></td>
            <td style="text-align:center;">: <?= $totalMapel ? number_format($totalNilai/$totalMapel,2) : 0 ?></td>
        </tr>
    </table>

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
            <?php $no=1; $totalEkskul=0; foreach($ekskul as $e): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($e['nama_ekstrakurikuler']) ?></td>
                <td><?= esc($e['nilai']) ?></td>
                <td><?= esc($e['keterangan']) ?></td>
            </tr>
            <?php $totalEkskul += (float)($e['nilai'] ?? 0); endforeach; ?>
        </tbody>
    </table>
    <table style="width:40%; margin-bottom:10px;">
        <tr>
            <td style="text-align:right;"><b>Total Nilai Ekstrakurikuler</b></td>
            <td style="text-align:center;">: <?= $totalEkskul ?></td>
        </tr>
        <tr>
            <td style="text-align:right;"><b>Total Nilai Keseluruhan</b></td>
            <td style="text-align:center;">: <?= $totalNilai + $totalEkskul ?></td>
        </tr>
        <tr>
            <td style="text-align:right;"><b>Rata-rata Keseluruhan</b></td>
            <td style="text-align:center;">: <?= ($totalMapel+count($ekskul)) ? number_format(($totalNilai+$totalEkskul)/($totalMapel+count($ekskul)),2) : 0 ?></td>
        </tr>
    </table>

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

    <div class="section-title">Catatan Wali Kelas</div>
    <div class="catatan-box">
        <?= $catatan ?? '' ?>
    </div>
    <br><br>

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
                <?= esc($wali_kelas['nik_nip'] ?? '-') ?>
            </td>
            <td style="border:none; text-align:center; line-height:1.2;">
                <br>____________________<br>
            </td>
            <td style="border:none; text-align:center; line-height:1.2;">
                <?= esc($siswa['nama']) ?><br>
                ____________________<br>
                <?= esc($siswa['nis']) ?>
            </td>
        </tr>
    </table>
</body>
</html> 