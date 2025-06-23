<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h3 class="mb-4">Rekap Absensi</h3>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="mb-3">Login sebagai: <strong><?= esc($user['username'] ?? '-') ?></strong></div>
            <form class="row g-3 align-items-end mb-4" method="get">
                <div class="col-md-4">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= $filter_kelas == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
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
            <?php if ($filter_kelas && $tanggal_mulai && $tanggal_akhir): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jumlah Hadir</th>
                            <th>Jumlah Izin</th>
                            <th>Jumlah Sakit</th>
                            <th>Jumlah Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dataAbsensi)): ?>
                        <tr><td colspan="7" class="text-center">Tidak ada data absensi.</td></tr>
                        <?php else: ?>
                        <?php foreach ($dataAbsensi as $i => $a): ?>
                        <tr>
                            <td><?= $i+1 ?></td>
                            <td><?= esc($a['nama']) ?></td>
                            <td><?= esc($a['kelas']) ?></td>
                            <td><?= $a['hadir'] ?></td>
                            <td><?= $a['izin'] ?></td>
                            <td><?= $a['sakit'] ?></td>
                            <td><?= $a['alpha'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 