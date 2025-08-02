<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Ekstrakurikuler</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/master/ekstrakurikuler/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Ekstrakurikuler
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ekstrakurikuler</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($ekstrakurikuler)) : ?>
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data.</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($ekstrakurikuler as $i => $e) : ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $e['nama_ekstrakurikuler'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/master/ekstrakurikuler/edit/' . $e['kd_ekstrakurikuler']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="<?= base_url('admin/master/ekstrakurikuler/delete/' . $e['kd_ekstrakurikuler']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>