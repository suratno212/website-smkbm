<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">e-Raport Siswa</h1>
    <div class="card mb-3">
        <div class="card-body">
            <strong>Nama:</strong> <?= esc($siswa['nama']) ?><br>
            <strong>NISN:</strong> <?= esc($siswa['nisn']) ?><br>
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
                    <?php $no=1; foreach($nilai as $n): ?>
                    <?php $mapelNama = ''; foreach($mapel as $m) { if($m['id']==$n['mapel_id']) $mapelNama=$m['nama_mapel']; } ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($mapelNama) ?></td>
                        <td><?= esc($n['uts']) ?></td>
                        <td><?= esc($n['uas']) ?></td>
                        <td><?= esc($n['tugas']) ?></td>
                        <td><?= esc($n['akhir']) ?></td>
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
    <a href="<?= base_url('guru/raport/cetak/'.$siswa['id']) ?>" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
    <a href="<?= base_url('guru/raport/siswa/'.$kelas['id']) ?>" class="btn btn-secondary">Kembali ke Daftar Siswa</a>
</div>
<?= $this->endSection() ?> 