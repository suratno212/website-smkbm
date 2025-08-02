<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kelola Calon Siswa</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/calon-siswa/export') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Export CSV
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

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="calonSiswaTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jurusan Pilihan</th>
                                    <th>Status Pendaftaran</th>
                                    <th>Status Tes</th>
                                    <th>Nilai Tes</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($calon_siswa as $cs) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $cs['nama'] ?></td>
                                        <td><?= $cs['email'] ?></td>
                                        <td>
                                            <span class="badge badge-info"><?= $cs['jurusan_pilihan'] ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = '';
                                            switch ($cs['status_pendaftaran']) {
                                                case 'terdaftar':
                                                    $statusClass = 'badge-warning';
                                                    break;
                                                case 'diterima':
                                                    $statusClass = 'badge-success';
                                                    break;
                                                case 'ditolak':
                                                    $statusClass = 'badge-danger';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $statusClass ?>">
                                                <?= ucfirst($cs['status_pendaftaran']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $tesClass = '';
                                            switch ($cs['status_tes']) {
                                                case 'belum_tes':
                                                    $tesClass = 'badge-secondary';
                                                    break;
                                                case 'sedang_tes':
                                                    $tesClass = 'badge-warning';
                                                    break;
                                                case 'sudah_tes':
                                                    $tesClass = 'badge-info';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $tesClass ?>">
                                                <?= ucfirst(str_replace('_', ' ', $cs['status_tes'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($cs['nilai_tes']) : ?>
                                                <span class="badge badge-primary"><?= $cs['nilai_tes'] ?></span>
                                            <?php else : ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('admin/calon-siswa/detail/' . $cs['id']) ?>" 
                                                   class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <?php if ($cs['status_pendaftaran'] == 'terdaftar') : ?>
                                                    <a href="<?= base_url('admin/calon-siswa/terima/' . $cs['id']) ?>" 
                                                       class="btn btn-success btn-sm" title="Terima"
                                                       onclick="return confirm('Terima calon siswa ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/calon-siswa/tolak/' . $cs['id']) ?>" 
                                                       class="btn btn-danger btn-sm" title="Tolak"
                                                       onclick="return confirm('Tolak calon siswa ini?')">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <a href="<?= base_url('admin/calon-siswa/hapus/' . $cs['id']) ?>" 
                                                   class="btn btn-danger btn-sm" title="Hapus"
                                                   onclick="return confirm('Hapus data calon siswa ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
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

<script>
$(document).ready(function() {
    $('#calonSiswaTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#calonSiswaTable_wrapper .col-md-6:eq(0)');
});
</script>
<?= $this->endSection() ?> 
 
 