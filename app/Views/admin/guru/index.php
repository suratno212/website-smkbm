<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Guru</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/guru/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Guru
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
                    <form action="<?= base_url('admin/guru') ?>" method="get" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nip_nuptk">NIP/NUPTK</label>
                                    <input type="text" class="form-control" id="nip_nuptk" name="nip_nuptk" value="<?= $filters['nip_nuptk'] ?? '' ?>" placeholder="Cari NIP/NUPTK...">
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
                                    <label for="mapel_id">Mata Pelajaran</label>
                                    <select class="form-control" id="mapel_id" name="mapel_id">
                                        <option value="">Semua Mapel</option>
                                        <?php foreach ($mapel as $m) : ?>
                                            <option value="<?= $m['id'] ?>" <?= ($filters['mapel_id'] ?? '') == $m['id'] ? 'selected' : '' ?>>
                                                <?= $m['nama_mapel'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="<?= base_url('admin/guru') ?>" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP/NUPTK</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Agama</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Alamat</th>
                                    <th>No. HP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($guru as $g) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $g['nip_nuptk']; ?></td>
                                        <td><?= $g['nama']; ?></td>
                                        <td><?= $g['jenis_kelamin']; ?></td>
                                        <td><?= $g['agama']; ?></td>
                                        <td><?= $g['tempat_lahir']; ?></td>
                                        <td><?= date('d-m-Y', strtotime($g['tanggal_lahir'])); ?></td>
                                        <td><?= $g['nama_mapel']; ?></td>
                                        <td><?= $g['alamat']; ?></td>
                                        <td><?= $g['no_hp']; ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/guru/edit/' . $g['id']); ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('admin/guru/delete/' . $g['id']); ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 