<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Kelas</h3>
                    <a href="<?= base_url('admin/kelas/create') ?>" class="btn btn-primary btn-sm float-end">Tambah Kelas</a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
                                    <th>Wali Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($kelas)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($kelas as $k) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($k['nama_kelas']) ?></td>
                                            <td><?= esc($k['tingkat']) ?></td>
                                            <td><?= esc($k['nama_jurusan'] ?? '-') ?></td>
                                            <td><?= esc($k['nama_wali'] ?? '-') ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/kelas/edit/' . $k['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="<?= base_url('admin/kelas/delete/' . $k['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr><td colspan="6" class="text-center">Tidak ada data kelas</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 