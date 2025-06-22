<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Mata Pelajaran</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/master/mapel/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Mata Pelajaran
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

                    <div class="mb-2">
                        <button type="button" class="btn btn-secondary btn-sm" id="btn-multi-select"><i class="fas fa-check-square"></i> Pilih Beberapa Data</button>
                        <button type="submit" class="btn btn-danger btn-sm d-none" id="btn-mass-delete" form="massDeleteForm" onclick="return confirm('Hapus semua mapel terpilih?')"><i class="fas fa-trash"></i> Hapus Terpilih</button>
                    </div>
                    <form id="massDeleteForm" action="<?= base_url('admin/master/mapel/mass_delete') ?>" method="post">
                        <?= csrf_field() ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><input type="checkbox" id="select-all"></th>
                                    <th>No</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($mapel as $m) : ?>
                                    <tr>
                                        <td class="col-checkbox d-none"><input type="checkbox" name="mapel_ids[]" value="<?= $m['id'] ?>"></td>
                                        <td><?= $i++ ?></td>
                                        <td><?= $m['nama_mapel'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/master/mapel/edit/' . $m['id']) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('admin/master/mapel/delete/' . $m['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('btn-multi-select').onclick = function() {
        var checkCols = document.querySelectorAll('.col-checkbox');
        var btnMassDelete = document.getElementById('btn-mass-delete');
        for (var col of checkCols) col.classList.toggle('d-none');
        btnMassDelete.classList.toggle('d-none');
    };
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="mapel_ids[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };
</script>
<?= $this->endSection() ?> 