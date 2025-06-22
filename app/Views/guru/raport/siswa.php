<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">e-Raport - Pilih Siswa (<?= esc($kelas['nama_kelas']) ?>)</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($siswa as $s): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($s['nisn']) ?></td>
                        <td><?= esc($s['nama']) ?></td>
                        <td>
                            <a href="<?= base_url('guru/raport/detail/'.$s['id']) ?>" class="btn btn-primary btn-sm">Lihat Raport</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="<?= base_url('guru/raport') ?>" class="btn btn-secondary mt-3">Kembali ke Pilih Kelas</a>
</div>
<?= $this->endSection() ?> 