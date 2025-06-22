<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Ekstrakurikuler</h1>
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('message') ?> </div>
    <?php endif; ?>
    <a href="<?= base_url('admin/master/ekstrakurikuler/create') ?>" class="btn btn-primary mb-3">Tambah Ekstrakurikuler</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($ekstrakurikuler as $e): ?>
                <tr>
                    <td style="width:50px;"><?= $no++ ?></td>
                    <td><?= esc($e['nama_ekstrakurikuler']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/master/ekstrakurikuler/edit/'.$e['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= base_url('admin/master/ekstrakurikuler/delete/'.$e['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?> 