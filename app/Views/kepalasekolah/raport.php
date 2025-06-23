<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Laporan e-Raport</h3>
    <div class="mb-3">Login sebagai: <strong><?= esc($user['username'] ?? '-') ?></strong></div>
    <form class="row g-3 align-items-end mb-4" method="get">
        <div class="col-md-6">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select" required>
                <option value="">Pilih Kelas</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= $filter_kelas == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search"></i> Tampilkan</button>
        </div>
    </form>
    <?php if ($filter_kelas): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Nilai Rata-rata</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dataSiswa)): ?>
                <tr><td colspan="5" class="text-center">Tidak ada data siswa.</td></tr>
                <?php else: ?>
                <?php foreach ($dataSiswa as $i => $s): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= esc($s['nama']) ?></td>
                    <td><?= esc($s['kelas']) ?></td>
                    <td><?= number_format($s['rata_rata'],2) ?></td>
                    <td><?= esc($s['status']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?> 