<?php helper('url'); ?>
<?php
// Ganti logo sekolah dan yayasan dengan gambar PNG/JPG dari internet bebas (Unsplash)
$logoSekolah = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQOvRXne5UoW788ugKsxXIhxMHiP9tQm5lIpQ&s';
$logoYayasan = 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/640px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png';
// Deteksi jika sedang dicetak Dompdf (CLI atau HTTP_USER_AGENT mengandung Dompdf)
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

// Mapping nama mapel ke kd_mapel
$namaToKodeMapel = [];
foreach ($mapel as $m) {
    $namaToKodeMapel[strtolower(trim($m['nama_mapel']))] = $m['kd_mapel'];
}

// Ambil nilai per mapel
function getNilaiByMapel($nilai, $kd_mapel) {
    foreach ($nilai as $n) if ($n['kd_mapel'] == $kd_mapel) return $n;
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
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; background: #f4f8fb; color: #222; margin: 0; padding: 0; }
        h2, h3, h4 { text-align: center; margin: 0; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; box-shadow: 0 2px 8px #e3e3e3; padding: 18px 24px 8px 24px; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; background: #fff; }
        th, td { border: 1px solid #1a237e; padding: 5px 7px; text-align: center; font-size: 12px; }
        th {
            background: #1a237e !important;
            color: #fff !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: 1px solid #fff !important;
        }
        .section-title { background: #1a237e; color: #fff; font-weight: bold; text-align: left; padding: 7px 12px; border-radius: 4px 4px 0 0; margin-bottom: 0; font-size: 13px; }
        .identitas-table td { border: none; text-align: left; padding: 2px 8px; font-size: 12px; }
        .header-logo { width: 60px; border-radius: 8px; box-shadow: 0 2px 8px #e3e3e3; }
        .header-table { width: 100%; border: none; margin-bottom: 0; }
        .header-table td { border: none; text-align: center; }
        .garis { border-bottom: 2px solid #1a237e; margin: 8px 0 12px 0; }
        .catatan-box { border: 1px solid #3949ab; padding: 10px; margin-bottom: 10px; background: #e8eaf6; border-radius: 6px; font-style: italic; font-size: 12px; }
        .ttd-table td { border: none; font-size: 12px; }
        .ttd-table { margin-top: 18px; margin-bottom: 0; width: 100%; }
        .ttd-nama { padding-top: 40px; font-weight: bold; }
        .ttd-ttd { padding-top: 20px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 8px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #43a047; color: #fff; }
        .badge-warning { background: #ffa000; color: #fff; }
        .badge-danger { background: #e53935; color: #fff; }
        .badge-info { background: #1e88e5; color: #fff; }
        @media print {
            body { background: #fff; }
            .container { box-shadow: none !important; border-radius: 0; }
            .garis, .section-title, table, th, td { box-shadow: none !important; }
        }
        /* Hindari page break pada tanda tangan */
        .avoid-break { page-break-inside: avoid; }
    </style>
</head>
<body>
<div class="container">
    <!-- HEADER SEKOLAH & YAYASAN -->
    <table class="header-table" style="margin-bottom: 0;">
        <tr>
            <td style="width:70px; text-align:left; vertical-align:top;">
                <img src="<?= $logoSekolah ?>" class="header-logo">
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
                <img src="<?= $logoYayasan ?>" class="header-logo">
            </td>
        </tr>
    </table>
    <div class="garis"></div>
    <h4 style="margin-bottom:14px; margin-top:0; font-size:15px; letter-spacing:0.5px;">LAPORAN HASIL BELAJAR (E-RAPORT)</h4>

    <!-- IDENTITAS SISWA & SEKOLAH -->
    <table class="identitas-table" style="width:100%; margin-bottom:14px;">
        <tr>
            <td style="width:25%;"><b>Nama Siswa</b></td><td style="width:30%;">: <?= esc($siswa['nama']) ?></td>
            <td style="width:20%;"><b>Jurusan</b></td><td>: <?= esc($kelas['nama_jurusan'] ?? '-') ?></td>
        </tr>
        <tr>
            <td><b>NIS</b></td><td>: <?= esc($siswa['nis']) ?></td>
            <td><b>Kelas</b></td><td>: <?= esc($kelas['nama_kelas']) ?></td>
        </tr>
        <tr>
            <td><b>Nama Sekolah</b></td><td>: SMK Bhakti Mulya BNS</td>
            <td><b>Semester</b></td><td>: <?= esc($semester) ?></td>
        </tr>
        <tr>
            <td><b>Alamat</b></td><td>: Gunung Ratu BNS</td>
            <td><b>Tahun Ajaran</b></td><td>: <?= esc($tahunAkademik['tahun'] ?? (date('Y').'/'.(date('Y')+1))) ?></td>
        </tr>
        <tr>
            <td><b>Wali Kelas</b></td><td>: <?= esc($kelas['nama_wali_kelas'] ?? ($wali_kelas['nama'] ?? '-')) ?></td>
            <td><b>Peringkat</b></td><td>: <?= $ranking ?? '-' ?></td>
        </tr>
        <tr>
            <td><b>NIK/NIP Wali Kelas</b></td><td>: <?= esc($wali_kelas['nik_nip'] ?? '-') ?></td>
            <td></td><td></td>
        </tr>
    </table>

    <?php // ================= TABEL NILAI AKADEMIK ================= ?>
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
        <?php 
        $no = 1;
        $totalNilai = 0;
        $totalMapel = 0;
        if (!empty($kelompokMapel)) {
            foreach ($kelompokMapel as $kode => $kelompok): 
                $subtotal = 0;
                $jumlahMapelKelompok = 0;
        ?>
            <tr>
                <td colspan="6" style="text-align:left; font-weight:bold; background:#e3e3e3; color:#1a237e;"> <?= $kelompok['label'] ?> </td>
            </tr>
            <?php foreach ($kelompok['sub'] as $namaMapel):
                $kd_mapel = $namaToKodeMapel[strtolower(trim($namaMapel))] ?? null;
                $nilaiMapel = $kd_mapel ? getNilaiByMapel($nilai, $kd_mapel) : null;
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td style="text-align:left;"> <?= esc($namaMapel) ?> </td>
                <td><?= $nilaiMapel ? esc($nilaiMapel['nilai_uts']) : '-' ?></td>
                <td><?= $nilaiMapel ? esc($nilaiMapel['nilai_uas']) : '-' ?></td>
                <td><?= $nilaiMapel ? esc($nilaiMapel['nilai_tugas']) : '-' ?></td>
                <td><?= $nilaiMapel ? esc($nilaiMapel['nilai_akhir']) : '-' ?></td>
            </tr>
            <?php 
                if ($nilaiMapel) {
                    $subtotal += $nilaiMapel['nilai_akhir'];
                    $totalNilai += $nilaiMapel['nilai_akhir'];
                    $jumlahMapelKelompok++;
                    $totalMapel++;
                }
            endforeach; ?>
            <tr>
                <td colspan="5" style="text-align:right; font-weight:bold; background:#1a237e; color:#fff;">Total Jumlah Nilai <?= ltrim(strstr($kelompok['label'], '. '), '. ') ?></td>
                <td style="font-weight:bold; background:#1a237e; color:#fff;"> <?= $subtotal ?> </td>
            </tr>
        <?php endforeach; } else {
            // Jika mapping kelompok gagal, tampilkan semua nilai yang ada
            foreach ($nilai as $n): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td style="text-align:left;"><?= $n['nama_mapel'] ?? $n['kd_mapel'] ?></td>
                <td><?= $n['nilai_uts'] ?? '-' ?></td>
                <td><?= $n['nilai_uas'] ?? '-' ?></td>
                <td><?= $n['nilai_tugas'] ?? '-' ?></td>
                <td><?= $n['nilai_akhir'] ?? '-' ?></td>
            </tr>
            <?php 
                if (isset($n['nilai_akhir']) && is_numeric($n['nilai_akhir'])) {
                    $totalNilai += $n['nilai_akhir'];
                    $totalMapel++;
                }
            endforeach; }
        ?>
        </tbody>
    </table>
    <?php if (count($nilai) < count($mapel)): ?>
    <div style="font-size:11px; color:#e53935; margin-bottom:8px;">Sebagian mata pelajaran belum ada nilai.</div>
    <?php endif; ?>
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

    <?php // ================= TABEL EKSTRAKURIKULER ================= ?>
    <div class="section-title">Kegiatan Ekstrakurikuler</div>
    <pre><?php print_r($ekskul); ?></pre>
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
</div>
</body>
</html> 