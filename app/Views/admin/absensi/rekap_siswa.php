<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="mb-4">Rekap Absensi Siswa per Minggu</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end" method="get">
                <div class="col-md-4">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        <option value="all" <?= $filter_kelas === 'all' ? 'selected' : '' ?>>Semua Kelas</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['kd_kelas'] ?>" <?= $filter_kelas == $k['kd_kelas'] ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="<?= esc($tanggal_mulai) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="<?= esc($tanggal_akhir) ?>" required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search"></i> Tampilkan</button>
                </div>
            </form>
        </div>
    </div>
    <?php if (!empty($rekap)): ?>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="<?= base_url('admin/absensi/cetak-rekap-siswa?kelas_id='.$filter_kelas.'&tanggal_mulai='.$tanggal_mulai.'&tanggal_akhir='.$tanggal_akhir) ?>" target="_blank" class="btn btn-success"><i class="fas fa-print"></i> Cetak</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <?php if ($filter_kelas === 'all'): ?><th>Kelas</th><?php endif; ?>
                            <th>Hadir</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rekap as $i => $r): ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= esc($r['nis']) ?></td>
                            <td><?= esc($r['nama']) ?></td>
                            <?php if ($filter_kelas === 'all'): ?><td><?= esc($r['kelas']) ?></td><?php endif; ?>
                            <td class="text-success fw-bold"><?= $r['hadir'] ?></td>
                            <td class="text-warning fw-bold"><?= $r['sakit'] ?></td>
                            <td class="text-info fw-bold"><?= $r['izin'] ?></td>
                            <td class="text-danger fw-bold"><?= $r['alpha'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php elseif ($filter_kelas && $tanggal_mulai && $tanggal_akhir): ?>
        <div class="alert alert-info">Tidak ada data absensi pada rentang tanggal tersebut.</div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?> 