<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">e-Raport Siswa</h1>
    <div class="card mb-3">
        <div class="card-body">
            <strong>Nama:</strong> <?= esc($siswa['nama']) ?><br>
            <strong>NIS:</strong> <?= esc($siswa['nisn']) ?><br>
            <strong>Kelas:</strong> <?= esc($kelas['nama_kelas']) ?><br>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">Nilai Akademik</div>
        <div class="card-body">
            <table class="table table-bordered">
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
                // Kelompok mapel per jurusan
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
                foreach ($mapel as $m) {
                    $mapelByKelompok[$m['kelompok']][] = $m;
                }
                function getNilaiByMapel($nilai, $mapel_id) {
                    foreach ($nilai as $n) if ($n['mapel_id'] == $mapel_id) return $n;
                    return null;
                }
                $no=1; $totalNilai=0; $totalMapel=0; $jumlahKelompok=[];
                foreach ($kelompokMapel as $kode => $kelompok): ?>
                    <tr>
                        <td colspan="6" style="text-align:left; font-weight:bold; background:#e3e3e3;"> <?= $kelompok['label'] ?> </td>
                    </tr>
                    <?php $jumlahKelompok[$kode]=0; foreach ($kelompok['sub'] as $namaMapel): ?>
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
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-info text-white">Absensi</div>
        <div class="card-body">
            <table class="table table-bordered">
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
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-success text-white">Ekstrakurikuler</div>
        <div class="card-body">
            <table class="table table-bordered">
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
        </div>
    </div>
    <a href="<?= base_url('guru/raport/preview/'.$siswa['id']) ?>" class="btn btn-info" target="_blank"><i class="fas fa-eye"></i> Preview e-Raport</a>
    <a href="<?= base_url('guru/raport/cetak/'.$siswa['id']) ?>" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
    <a href="<?= base_url('guru/raport/siswa/'.$kelas['id']) ?>" class="btn btn-secondary">Kembali ke Daftar Siswa</a>
</div>
<?= $this->endSection() ?> 