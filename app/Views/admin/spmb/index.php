<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-primary">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['total'] ?? 0 ?></div>
                            <small>Total Pendaftar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-success">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['diterima'] ?? 0 ?></div>
                            <small>Diterima</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-warning">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['menunggu'] ?? 0 ?></div>
                            <small>Menunggu</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-danger">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['ditolak'] ?? 0 ?></div>
                            <small>Ditolak</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <div class="card text-white bg-info">
                        <div class="card-body p-2 text-center">
                            <div class="h4 mb-0"><?= $statistik['bersyarat'] ?? 0 ?></div>
                            <small>Bersyarat</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Data SPMB</h3>
                    <a href="<?= base_url('admin/spmb/print') ?>" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-print"></i> Cetak Laporan</a>
                </div>
                <div class="card-body">
                    <form class="row g-2 align-items-end mb-3" method="get" id="form-filter">
                        <div class="col-md-2">
                            <label class="form-label mb-1">Nama</label>
                            <input type="text" name="nama" class="form-control form-control-sm" value="<?= esc($filters['nama'] ?? '') ?>" placeholder="Cari nama...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-1">Jurusan</label>
                            <select name="jurusan" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j['kd_jurusan'] ?>" <?= ($filters['jurusan'] ?? '') == $j['kd_jurusan'] ? 'selected' : '' ?>><?= $j['nama_jurusan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-1">Status</label>
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <option value="Menunggu" <?= ($filters['status'] ?? '') == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Diterima" <?= ($filters['status'] ?? '') == 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                                <option value="Ditolak" <?= ($filters['status'] ?? '') == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                <option value="Diterima Bersyarat" <?= ($filters['status'] ?? '') == 'Diterima Bersyarat' ? 'selected' : '' ?>>Bersyarat</option>
                                <option value="Sudah Jadi Siswa" <?= ($filters['status'] ?? '') == 'Sudah Jadi Siswa' ? 'selected' : '' ?>>Sudah Jadi Siswa</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Tanggal Daftar</label>
                            <div class="input-group input-group-sm">
                                <input type="date" name="tanggal_awal" class="form-control" value="<?= esc($filters['tanggal_awal'] ?? '') ?>">
                                <span class="input-group-text">-</span>
                                <input type="date" name="tanggal_akhir" class="form-control" value="<?= esc($filters['tanggal_akhir'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            <?php if (!empty(array_filter($filters))) : ?>
                                <a href="<?= base_url('admin/spmb') ?>" class="btn btn-secondary btn-sm">Reset</a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form id="form-mass-delete" action="<?= base_url('admin/spmb/mass_delete') ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
                        <?= csrf_field() ?>
                        <div class="mb-2 d-flex gap-2">
                            <button type="submit" class="btn btn-danger btn-sm" id="btn-delete-selected" disabled><i class="fas fa-trash"></i> Hapus Terpilih</button>
                            <button type="button" class="btn btn-primary btn-sm" id="btn-jadikan-siswa" disabled><i class="fas fa-user-plus"></i> Jadikan Siswa Terpilih</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check-all"></th>
                                        <th>No</th>
                                        <th>No. Pendaftaran</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jurusan</th>
                                        <th>Agama</th>
                                        <th>Status</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($spmb)) : ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($spmb as $p) : ?>
                                            <?php
                                                // Cek apakah user sudah ada
                                                $userModel = new \App\Models\UserModel();
                                                $userSiswa = $userModel->where('username', $p['no_pendaftaran'])->first();
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" class="check-item" name="ids[]" value="<?= $p['no_pendaftaran'] ?>"></td>
                                                <td><?= $i++; ?></td>
                                                <td><?= $p['no_pendaftaran']; ?></td>
                                                <td><?= $p['nama_lengkap']; ?></td>
                                                <td><?= $p['nama_jurusan'] ?? '-'; ?></td>
                                                <td><?= $p['nama_agama'] ?? '-'; ?></td>
                                                <td>
                                                    <span class="badge badge-<?=
                                                        $p['status_pendaftaran'] == 'Menunggu' ? 'warning' :
                                                        ($p['status_pendaftaran'] == 'Diterima' ? 'success' :
                                                        ($p['status_pendaftaran'] == 'Diterima Bersyarat' ? 'info' :
                                                        ($p['status_pendaftaran'] == 'Sudah Jadi Siswa' ? 'primary' : 'danger')))
                                                    ?>">
                                                        <?= $p['status_pendaftaran'] == 'Sudah Jadi Siswa' ? 'Sudah Jadi Siswa' : $p['status_pendaftaran']; ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])); ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/spmb/' . $p['no_pendaftaran']); ?>" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($p['status_pendaftaran'] == 'Menunggu') : ?>
                                                        <a href="<?= base_url('admin/spmb/terima/' . $p['no_pendaftaran']); ?>" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                        <a href="<?= base_url('admin/spmb/tolak/' . $p['no_pendaftaran']); ?>" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    <?php elseif ($p['status_pendaftaran'] == 'Diterima' && !$userSiswa) : ?>
                                                        <a href="<?= base_url('admin/spmb/jadikanSiswa/' . $p['no_pendaftaran']); ?>" class="btn btn-primary btn-sm" onclick="return confirm('Jadikan pendaftar ini sebagai siswa?')">
                                                            <i class="fas fa-user-plus"></i> Jadikan Siswa
                                                        </a>
                                                    <?php elseif ($p['status_pendaftaran'] == 'Sudah Jadi Siswa' || $userSiswa) : ?>
                                                        <span class="badge badge-success">Sudah Jadi Siswa</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data pendaftar</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Enable/disable tombol hapus massal dan jadikan siswa massal
const checkAll = document.getElementById('check-all');
const checkItems = document.querySelectorAll('.check-item');
const btnDelete = document.getElementById('btn-delete-selected');
const btnJadikanSiswa = document.getElementById('btn-jadikan-siswa');
const formMass = document.getElementById('form-mass-delete');
function updateBtnState() {
    const checked = document.querySelectorAll('.check-item:checked').length > 0;
    btnDelete.disabled = !checked;
    btnJadikanSiswa.disabled = !checked;
}
checkAll && checkAll.addEventListener('change', function() {
    checkItems.forEach(cb => cb.checked = this.checked);
    updateBtnState();
});
checkItems.forEach(cb => cb.addEventListener('change', updateBtnState));
// Submit ke mass_jadikan_siswa jika tombol biru diklik
btnJadikanSiswa && btnJadikanSiswa.addEventListener('click', function() {
    formMass.action = '<?= base_url('admin/spmb/mass_jadikan_siswa') ?>';
    formMass.submit();
});
// Pastikan default action tetap ke mass_delete
formMass.action = '<?= base_url('admin/spmb/mass_delete') ?>';
</script>
<?= $this->endSection() ?> 