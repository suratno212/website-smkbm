<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Siswa</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/siswa/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Filter -->
                    <form action="<?= base_url('admin/siswa') ?>" method="get" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nis">NISN</label>
                                    <input type="text" class="form-control" id="nis" name="nis" value="<?= $filters['nis'] ?? '' ?>" placeholder="Cari NISN...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $filters['nama'] ?? '' ?>" placeholder="Cari nama...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select class="form-control" id="kelas_id" name="kelas_id">
                                        <option value="">Semua Kelas</option>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['id'] ?>" <?= ($filters['kelas_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jurusan_id">Jurusan</label>
                                    <select class="form-control" id="jurusan_id" name="jurusan_id">
                                        <option value="">Semua Jurusan</option>
                                        <?php foreach ($jurusan as $j) : ?>
                                            <option value="<?= $j['id'] ?>" <?= ($filters['jurusan_id'] ?? '') == $j['id'] ? 'selected' : '' ?>>
                                                <?= $j['nama_jurusan'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12 d-flex gap-2 align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="<?= base_url('admin/siswa') ?>" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                                <a href="<?= base_url('admin/siswa/cetak?'.http_build_query($filters)) ?>" target="_blank" class="btn btn-success ms-auto"><i class="fas fa-print"></i> Cetak</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Agama</th>
                                    <th>Alamat</th>
                                    <th>No. HP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($siswa as $s) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $s['nisn']; ?></td>
                                        <td><?= $s['nama']; ?></td>
                                        <td><?= $s['nama_kelas']; ?></td>
                                        <td><?= $s['nama_jurusan']; ?></td>
                                        <td><?= $s['jenis_kelamin']; ?></td>
                                        <td><?= $s['nama_agama'] ?? '-'; ?></td>
                                        <td><?= $s['alamat']; ?></td>
                                        <td><?= $s['no_hp']; ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/siswa/edit/' . $s['id']); ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('admin/siswa/delete/' . $s['id']); ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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