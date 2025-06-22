<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pengumuman</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/pengumuman/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Pengumuman
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                            <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>File</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($pengumuman as $p) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $p['judul'] ?></td>
                                        <td>
                                            <span class="badge badge-<?= $p['jenis'] == 'Jadwal Ujian' ? 'danger' : ($p['jenis'] == 'Kegiatan' ? 'warning' : 'info') ?>">
                                                <?= $p['jenis'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($p['file']) : ?>
                                                <a href="<?= base_url('admin/pengumuman/download/' . $p['id']) ?>" class="btn btn-success btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">Tidak ada file</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $p['status'] == 'Aktif' ? 'success' : 'secondary' ?>">
                                                <?= $p['status'] ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/pengumuman/edit/' . $p['id']) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('admin/pengumuman/delete/' . $p['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
<?= $this->endSection() ?> 