<?= $this->extend('layout/calonsiswa') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-body text-center" style="background: #1a237e; color: #fff; border-radius: 10px 10px 0 0;">
                    <h2 class="mb-2">Selamat Datang, <?= esc($calon_siswa['nama'] ?? $user['username']) ?>!</h2>
                    <p class="mb-0">Dashboard Calon Siswa SPMB</p>
                </div>
                <div class="card-body" style="background: #f5f5f5;">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div class="p-3 rounded" style="background:#e3eafc;">
                                <strong>Email:</strong> <?= esc($user['username']) ?><br>
                                <strong>No. Pendaftaran:</strong> <?= esc($spmb['no_pendaftaran'] ?? '-') ?><br>
                                <strong>Nama Lengkap:</strong> <?= esc($calon_siswa['nama'] ?? '-') ?><br>
                                <strong>Tanggal Lahir:</strong> <?= esc($calon_siswa['tanggal_lahir'] ?? '-') ?><br>
                                <strong>Jurusan Pilihan:</strong> <?= esc($calon_siswa['jurusan_pilihan'] ?? '-') ?><br>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="p-3 rounded" style="background:#e3eafc;">
                                <span style="font-size:1.1rem;font-weight:600;">Status Pendaftaran:</span>
                                <span class="badge badge-<?= ($calon_siswa['status_pendaftaran'] ?? '')=='diterima'?'success':(($calon_siswa['status_pendaftaran'] ?? '')=='ditolak'?'danger':'warning') ?>" style="color:#1a237e;font-weight:bold;font-size:1rem;vertical-align:middle;"> 
                                    <?= esc(ucfirst($calon_siswa['status_pendaftaran'] ?? 'terdaftar')) ?> 
                                </span><br>
                                <span style="font-size:1.1rem;font-weight:600;">Status Tes:</span>
                                <span class="badge badge-<?= ($calon_siswa['status_tes'] ?? '')=='sudah_tes'?'success':'warning' ?>" style="color:#1a237e;font-weight:bold;font-size:1rem;vertical-align:middle;"> 
                                    <?= esc(ucfirst(str_replace('_', ' ', $calon_siswa['status_tes'] ?? 'belum_tes'))) ?> 
                                </span><br>
                                <?php if ($calon_siswa['nilai_tes']): ?>
                                    <span style="font-size:1.1rem;font-weight:600;">Nilai Tes:</span> <span class="text-primary h5"> <?= $calon_siswa['nilai_tes'] ?> </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-4">
                        <?php if (($calon_siswa['status_tes'] ?? 'belum_tes') != 'sudah_tes'): ?>
                            <a href="<?= base_url('spmbtes/mulai') ?>" class="btn btn-primary btn-lg mb-2 mb-md-0" style="background:#1a237e; border:none;">Mulai Tes SPMB</a>
                        <?php else: ?>
                            <a href="<?= base_url('spmbtes/hasil') ?>" class="btn btn-success btn-lg mb-2 mb-md-0">Lihat Hasil Tes</a>
                        <?php endif; ?>
                        <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger btn-lg">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 