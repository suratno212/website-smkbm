<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Agama</h3>
                    <a href="<?= base_url('admin/master/agama/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Agama
                    </a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Agama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($agama as $a) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($a['nama_agama']) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/master/agama/edit/' . $a['id']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="<?= base_url('admin/master/agama/delete/' . $a['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
</div>
<?= $this->endSection() ?> 