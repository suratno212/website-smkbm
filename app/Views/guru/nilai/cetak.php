<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nilai - <?= $kelas['nama_kelas'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-before: always;
            }
            body {
                margin: 0;
                padding: 20px;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
        
        .print-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1a237e;
            padding-bottom: 20px;
        }
        
        .school-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }
        
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a237e;
            margin-bottom: 5px;
        }
        
        .school-address {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .document-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            text-align: center;
        }
        
        .info-table {
            margin-bottom: 30px;
        }
        
        .info-table td {
            padding: 8px 15px;
            border: 1px solid #ddd;
        }
        
        .info-table td:first-child {
            font-weight: bold;
            background-color: #f8f9fa;
            width: 200px;
        }
        
        .grade-table {
            margin-bottom: 30px;
        }
        
        .grade-table th {
            background-color: #1a237e;
            color: white;
            text-align: center;
            padding: 12px 8px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        
        .grade-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
        }
        
        .grade-table td:nth-child(1),
        .grade-table td:nth-child(2),
        .grade-table td:nth-child(3) {
            text-align: left;
        }
        
        .nilai-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
        }
        
        .nilai-a { background-color: #28a745; color: white; }
        .nilai-b { background-color: #007bff; color: white; }
        .nilai-c { background-color: #ffc107; color: black; }
        .nilai-d { background-color: #17a2b8; color: white; }
        .nilai-e { background-color: #dc3545; color: white; }
        
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin-top: 50px;
            text-align: center;
        }
        
        .stats-summary {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 6px;
            border: 1px solid #ddd;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #1a237e;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Print Controls -->
        <div class="no-print mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Cetak Nilai Siswa</h4>
                <div>
                    <button onclick="window.print()" class="btn btn-primary me-2">
                        <i class="fas fa-print me-2"></i>Cetak
                    </button>
                    <button onclick="window.close()" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Print Header -->
        <div class="print-header">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Sekolah" class="school-logo">
            <div class="school-name">SMK BHAKTI MULYA BNS</div>
            <div class="school-address">Jl. Raya BNS No. 123, Bekasi Utara, Jawa Barat</div>
            <div class="school-address">Telp: (021) 1234567 | Email: info@smkbm.edu.id</div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            REKAPITULASI NILAI SISWA<br>
            SEMESTER <?= $semester ?> TAHUN AJARAN 2024/2025
        </div>

        <!-- Class Information -->
        <div class="info-table">
            <table class="table table-bordered">
                <tr>
                    <td>Kelas</td>
                    <td><?= $kelas['nama_kelas'] ?> - <?= $kelas['nama_jurusan'] ?></td>
                    <td>Semester</td>
                    <td><?= $semester ?></td>
                </tr>
                <tr>
                    <td>Tahun Ajaran</td>
                    <td>2024/2025</td>
                    <td>Tanggal Cetak</td>
                    <td><?= date('d/m/Y H:i') ?></td>
                </tr>
                <tr>
                    <td>Wali Kelas</td>
                    <td><?= $user['username'] ?? 'N/A' ?></td>
                    <td>Total Siswa</td>
                    <td><?= count($siswaList) ?> orang</td>
                </tr>
            </table>
        </div>

        <!-- Statistics Summary -->
        <div class="stats-summary">
            <h6 class="mb-3"><i class="fas fa-chart-bar me-2"></i>Ringkasan Statistik</h6>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value" id="rataRataKelas">0.00</div>
                    <div class="stat-label">Rata-rata Kelas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="nilaiTertinggi">0.00</div>
                    <div class="stat-label">Nilai Tertinggi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="nilaiTerendah">0.00</div>
                    <div class="stat-label">Nilai Terendah</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="siswaLulus">0</div>
                    <div class="stat-label">Siswa Lulus (≥70)</div>
                </div>
            </div>
        </div>

        <!-- Kelompok mapel per jurusan
        $jurusan = strtolower($kelas['nama_jurusan'] ?? '');
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
        // Index mapel berdasarkan kelompok
        $mapelByKelompok = [];
        foreach ($mapelList as $m) {
            $mapelByKelompok[$m['kelompok']][] = $m;
        }
        ?>
        <div class="grade-table-wrapper">
            <table class="table grade-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <?php foreach ($kelompokMapel as $kode => $kelompok): ?>
                            <th colspan="<?= count($kelompok['sub']) ?>" class="text-center"> <?= $kelompok['label'] ?> </th>
                        <?php endforeach; ?>
                        <th class="text-center">Rata-rata</th>
                        <th class="text-center">Ranking</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <?php foreach ($kelompokMapel as $kode => $kelompok): ?>
                            <?php foreach ($kelompok['sub'] as $namaMapel): ?>
                                <th class="text-center" style="font-size:11px;"> <?= $namaMapel ?> </th>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($siswaList as $index => $siswa) : 
                        $totalNilai = 0;
                        $countNilai = 0;
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                        <td><?= $siswa['nisn'] ?></td>
                            <td><?= $siswa['nama'] ?></td>
                        <?php foreach ($kelompokMapel as $kode => $kelompok): ?>
                            <?php foreach ($kelompok['sub'] as $namaMapel): ?>
                                <?php 
                                $mapelObj = null;
                                foreach (($mapelByKelompok[$kode] ?? []) as $m) {
                                    if (trim(strtolower($m['nama_mapel'])) == trim(strtolower($namaMapel))) {
                                        $mapelObj = $m;
                                        break;
                                    }
                                }
                                $nilai = $mapelObj ? ($nilaiData[$siswa['id']][$mapelObj['id']] ?? null) : null;
                                $nilaiAkhir = $nilai ? $nilai['akhir'] : 0;
                                if ($nilaiAkhir > 0) {
                                    $totalNilai += $nilaiAkhir;
                                    $countNilai++;
                                }
                                ?>
                                <td class="text-center align-middle">
                                    <?= $nilaiAkhir > 0 ? number_format($nilaiAkhir, 2) : '-' ?>
                                </td>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <td class="text-center align-middle"> <?= $countNilai ? number_format($totalNilai/$countNilai,2) : '-' ?> </td>
                        <td class="text-center align-middle"> <?= $ranking[$siswa['id']] ?? '-' ?> </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Grade Legend -->
        <div class="row mb-4">
            <div class="col-12">
                <h6>Keterangan Nilai:</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="nilai-badge nilai-a">A (90-100)</span>
                    <span class="nilai-badge nilai-b">B (80-89)</span>
                    <span class="nilai-badge nilai-c">C (70-79)</span>
                    <span class="nilai-badge nilai-d">D (60-69)</span>
                    <span class="nilai-badge nilai-e">E (0-59)</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>Bekasi, <?= date('d F Y') ?></div>
            <div>Wali Kelas,</div>
            <div class="signature-line">
                <br><br>
                <strong><?= $user['username'] ?? 'Nama Wali Kelas' ?></strong><br>
                NIP. -
            </div>
        </div>
    </div>

    <script>
    // Calculate rankings and statistics
    document.addEventListener('DOMContentLoaded', function() {
        const rankingData = <?= json_encode($rankingData) ?>;
        const allNilai = <?= json_encode($allNilai) ?>;
        
        // Sort by average score (descending)
        const sortedData = [...rankingData].sort((a, b) => b.rata_rata - a.rata_rata);
        
        // Update ranking badges
        sortedData.forEach((data, index) => {
            const badge = document.querySelector(`.ranking-badge[data-siswa="${data.siswa_id}"]`);
            if (badge && data.rata_rata > 0) {
                badge.textContent = index + 1;
            }
        });
        
        // Calculate and update statistics
        if (allNilai.length > 0) {
            const rataRataKelas = allNilai.reduce((sum, nilai) => sum + nilai, 0) / allNilai.length;
            const nilaiTertinggi = Math.max(...allNilai);
            const nilaiTerendah = Math.min(...allNilai);
            const siswaLulus = allNilai.filter(nilai => nilai >= 70).length;
            
            document.getElementById('rataRataKelas').textContent = rataRataKelas.toFixed(2);
            document.getElementById('nilaiTertinggi').textContent = nilaiTertinggi.toFixed(2);
            document.getElementById('nilaiTerendah').textContent = nilaiTerendah.toFixed(2);
            document.getElementById('siswaLulus').textContent = siswaLulus;
        }
    });
    
    <?php
    function getNilaiClass($nilai) {
        if ($nilai >= 90) return 'nilai-a';
        if ($nilai >= 80) return 'nilai-b';
        if ($nilai >= 70) return 'nilai-c';
        if ($nilai >= 60) return 'nilai-d';
        return 'nilai-e';
    }
    ?>
    </script>
</body>
</html> 