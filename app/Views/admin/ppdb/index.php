<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data PPDB</h3>
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
                                    <th>No. Pendaftaran</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ppdb)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ppdb as $p) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $p['no_pendaftaran']; ?></td>
                                            <td><?= $p['nama_lengkap']; ?></td>
                                            <td><?= $p['jurusan_pilihan']; ?></td>
                                            <td>
                                                <span class="badge badge-<?= $p['status_pendaftaran'] == 'Menunggu' ? 'warning' : ($p['status_pendaftaran'] == 'Diterima' ? 'success' : 'danger') ?>">
                                                    <?= $p['status_pendaftaran']; ?>
                                                </span>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])); ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/ppdb/' . $p['id']); ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($p['status_pendaftaran'] == 'Menunggu') : ?>
                                                    <a href="<?= base_url('admin/ppdb/terima/' . $p['id']); ?>" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/ppdb/tolak/' . $p['id']); ?>" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pendaftar</td>
                                    </tr>
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
