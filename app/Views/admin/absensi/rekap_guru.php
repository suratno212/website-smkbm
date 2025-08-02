<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="mb-4">Rekap Absensi Guru per Minggu</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end" method="get">
                <div class="col-md-4">
                    <label class="form-label">Guru</label>
                    <select name="guru_id" class="form-select" required>
                        <option value="">Pilih Guru</option>
                        <option value="all" <?= $filter_guru === 'all' ? 'selected' : '' ?>>Semua Guru</option>
                        <?php foreach ($guru as $g): ?>
                            <option value="<?= $g['nik_nip'] ?>" <?= $filter_guru == $g['nik_nip'] ? 'selected' : '' ?>><?= esc($g['nama']) ?></option>
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
    <?php if ($filter_guru): ?>
        <?php if (!empty($rekap)): ?>
            <div class="mb-3">
                <a href="<?= base_url('admin/absensi/cetak-rekap-guru?guru_id=' . $filter_guru . '&tanggal_mulai=' . $tanggal_mulai . '&tanggal_akhir=' . $tanggal_akhir) ?>" target="_blank" class="btn btn-success"><i class="fas fa-print"></i> Cetak</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap as $i => $r): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                        <td class="fw-bold <?= $r['status'] == 'Hadir' ? 'text-success' : ($r['status'] == 'Izin' ? 'text-info' : ($r['status'] == 'Sakit' ? 'text-warning' : 'text-danger')) ?>">
                                            <?= esc($r['status']) ?>
                                        </td>
                                        <td><?= esc($r['keterangan'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php elseif ($tanggal_mulai && $tanggal_akhir): ?>
            <div class="alert alert-info">Tidak ada data absensi pada rentang tanggal tersebut.</div>
        <?php endif; ?>
    <?php elseif ($tanggal_mulai && $tanggal_akhir): ?>
        <?php if (!empty($rekap)): ?>
            <?php foreach ($rekap as $nik => $data): ?>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <b><?= esc($data['guru']['nama']) ?> (<?= esc($data['guru']['nik_nip']) ?>)</b>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($data['absensi'])): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['absensi'] as $i => $r): ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                                <td class="fw-bold <?= $r['status'] == 'Hadir' ? 'text-success' : ($r['status'] == 'Izin' ? 'text-info' : ($r['status'] == 'Sakit' ? 'text-warning' : 'text-danger')) ?>">
                                                    <?= esc($r['status']) ?>
                                                </td>
                                                <td><?= esc($r['keterangan'] ?? '-') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">Tidak ada data absensi untuk guru ini pada rentang tanggal tersebut.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Tidak ada data absensi pada rentang tanggal tersebut.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php if (isset($is_cetak) && $is_cetak): ?>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
<?php endif; ?>
<?= $this->endSection() ?>