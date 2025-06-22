<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal Pelajaran</h1>
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
                            <h3 class="card-title">Daftar Jadwal Pelajaran</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('admin/jadwal/create') ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Jadwal
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

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <form class="form-inline" method="get">
                                        <div class="input-group">
                                            <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                                                <option value="">Pilih Kelas</option>
                                                <?php foreach ($kelas as $k): ?>
                                                    <option value="<?= $k['id'] ?>" <?= (isset($filter_kelas) && $filter_kelas == $k['id']) ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end">
                                    <?php if (isset($filter_kelas) && $filter_kelas): ?>
                                        <a href="<?= base_url('admin/jadwal/cetak?kelas_id='.$filter_kelas) ?>" target="_blank" class="btn btn-success"><i class="fas fa-print"></i> Cetak Jadwal</a>
                                    <?php else: ?>
                                        <button class="btn btn-success" disabled><i class="fas fa-print"></i> Cetak Jadwal</button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Tahun Akademik</th>
                                            <th>Kelas</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($jadwal as $j) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $j['tahun'] ?> - Semester <?= $j['semester'] ?></td>
                                                <td><?= $j['nama_kelas'] ?></td>
                                                <td><?= $j['nama_mapel'] ?></td>
                                                <td><?= $j['nama_guru'] ?></td>
                                                <td><?= $j['hari'] ?></td>
                                                <td><?= $j['jam_mulai'] ?> - <?= $j['jam_selesai'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/jadwal/edit/' . $j['id']) ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="<?= base_url('admin/jadwal/delete/' . $j['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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