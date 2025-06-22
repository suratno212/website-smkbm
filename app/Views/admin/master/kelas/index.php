<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Kelas</h3>
                    <div>
                        <a href="<?= base_url('admin/master/kelas/create') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Kelas</a>
                        <a href="<?= base_url('admin/master/kelas/cetak?' . http_build_query($_GET)) ?>" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak</a>
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
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form method="get" class="mb-3 d-flex flex-wrap gap-2 align-items-end">
                        <div class="form-group mr-2">
                            <label for="jurusan_id">Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="form-control form-control-sm">
                                <option value="">Semua Jurusan</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($_GET['jurusan_id']) && $_GET['jurusan_id'] == $j['id']) ? 'selected' : '' ?>><?= $j['nama_jurusan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <label for="tingkat">Tingkat</label>
                            <select name="tingkat" id="tingkat" class="form-control form-control-sm">
                                <option value="">Semua Tingkat</option>
                                <?php for ($t = 10; $t <= 12; $t++) : ?>
                                    <option value="<?= $t ?>" <?= (isset($_GET['tingkat']) && $_GET['tingkat'] == $t) ? 'selected' : '' ?>><?= $t ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm mr-2">Filter</button>
                        <a href="<?= base_url('admin/master/kelas') ?>" class="btn btn-secondary btn-sm">Reset</a>
                    </form>
                    <form id="form-mass-delete" action="<?= base_url('admin/master/kelas/mass_delete') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-2">
                            <button type="button" class="btn btn-secondary btn-sm" id="btn-multi-select"><i class="fas fa-check-square"></i> Pilih Beberapa Data</button>
                            <button type="submit" class="btn btn-danger btn-sm d-none" id="btn-mass-delete" onclick="return confirm('Yakin hapus data terpilih?')"><i class="fas fa-trash"></i> Hapus Terpilih</button>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><input type="checkbox" id="checkAll"></th>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
                                    <th>Wali Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($kelas as $k) : ?>
                                    <tr>
                                        <td class="col-checkbox d-none"><input type="checkbox" name="ids[]" value="<?= $k['id'] ?>"></td>
                                        <td><?= $i++ ?></td>
                                        <td><?= $k['nama_kelas'] ?></td>
                                        <td><?= $k['tingkat'] ?></td>
                                        <td><?= $k['nama_jurusan'] ?></td>
                                        <td><?= $k['nama_wali_kelas'] ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/master/kelas/edit/' . $k['id']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="<?= base_url('admin/master/kelas/delete/' . $k['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                    <script>
                        document.getElementById('btn-multi-select').onclick = function() {
                            var checkCols = document.querySelectorAll('.col-checkbox');
                            var btnMassDelete = document.getElementById('btn-mass-delete');
                            for (var col of checkCols) col.classList.toggle('d-none');
                            btnMassDelete.classList.toggle('d-none');
                        };
                        document.getElementById('checkAll').onclick = function() {
                            var checkboxes = document.querySelectorAll('input[name="ids[]"]');
                            for (var checkbox of checkboxes) {
                                checkbox.checked = this.checked;
                            }
                        };
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 