<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Wali Kelas</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Wali Kelas</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('admin/wali_kelas/create') ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Wali Kelas
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= session()->getFlashdata('success') ?>
                                </div>
                            <?php endif; ?>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Tahun Akademik</th>
                                            <th>Nama Kelas</th>
                                            <th>Nama Wali Kelas</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($wali_kelas as $wk) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $wk['tahun'] ?> - Semester <?= $wk['semester'] ?></td>
                                                <td><?= $wk['nama_kelas'] ?></td>
                                                <td><?= $wk['nama_guru'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/wali_kelas/edit/' . $wk['id']) ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="<?= base_url('admin/wali_kelas/delete/' . $wk['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
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
    </section>
</div>
<?= $this->endSection() ?> 