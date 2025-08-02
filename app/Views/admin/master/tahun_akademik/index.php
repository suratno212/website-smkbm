<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Tahun Akademik</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/master/tahun_akademik/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Tahun Akademik
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tahun</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($tahun_akademik as $ta) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $ta['kd_tahun_akademik'] ?></td>
                                    <td><?= $ta['tahun'] ?></td>
                                    <td><?= $ta['semester'] ?></td>
                                    <td><?= $ta['status'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/master/tahun_akademik/edit/' . $ta['kd_tahun_akademik']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <form action="<?= base_url('admin/master/tahun_akademik/delete/' . $ta['kd_tahun_akademik']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>