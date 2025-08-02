<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Calon Siswa</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Nama</strong></td>
                            <td>: <?= $calon_siswa['nama'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: <?= $calon_siswa['email'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Lahir</strong></td>
                            <td>: <?= date('d/m/Y', strtotime($calon_siswa['tanggal_lahir'])) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>: <?= $calon_siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>: <?= $calon_siswa['alamat'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>No HP</strong></td>
                            <td>: <?= $calon_siswa['no_hp'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Asal Sekolah</strong></td>
                            <td>: <?= $calon_siswa['asal_sekolah'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan Pilihan</strong></td>
                            <td>: <span class="badge badge-info"><?= $calon_siswa['jurusan_pilihan'] ?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Status Pendaftaran</strong></td>
                            <td>: 
                                <?php
                                $statusClass = '';
                                switch ($calon_siswa['status_pendaftaran']) {
                                    case 'terdaftar':
                                        $statusClass = 'badge-warning';
                                        break;
                                    case 'diterima':
                                        $statusClass = 'badge-success';
                                        break;
                                    case 'ditolak':
                                        $statusClass = 'badge-danger';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $statusClass ?>">
                                    <?= ucfirst($calon_siswa['status_pendaftaran']) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status Tes</strong></td>
                            <td>: 
                                <?php
                                $tesClass = '';
                                switch ($calon_siswa['status_tes']) {
                                    case 'belum_tes':
                                        $tesClass = 'badge-secondary';
                                        break;
                                    case 'sedang_tes':
                                        $tesClass = 'badge-warning';
                                        break;
                                    case 'sudah_tes':
                                        $tesClass = 'badge-info';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $tesClass ?>">
                                    <?= ucfirst(str_replace('_', ' ', $calon_siswa['status_tes'])) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Nilai Tes</strong></td>
                            <td>: 
                                <?php if ($calon_siswa['nilai_tes']) : ?>
                                    <span class="badge badge-primary"><?= $calon_siswa['nilai_tes'] ?></span>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Konversi ke Siswa Aktif</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/calon-siswa/konversi/' . $calon_siswa['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-group">
                            <label for="nis">NIS <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukkan NIS (10 digit)" required maxlength="10" minlength="10">
                            <small class="form-text text-muted">NIS harus 10 digit dan unik</small>
                        </div>

                        <div class="form-group">
                            <label for="jurusan_id">Jurusan <span class="text-danger">*</span></label>
                            <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                <option value="">Pilih Jurusan</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j['id'] ?>" 
                                            <?= $j['nama_jurusan'] == $calon_siswa['jurusan_pilihan'] ? 'selected' : '' ?>>
                                        <?= $j['nama_jurusan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kelas_id">Kelas <span class="text-danger">*</span></label>
                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['id'] ?>"><?= $k['nama_kelas'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="agama_id">Agama <span class="text-danger">*</span></label>
                            <select class="form-control" id="agama_id" name="agama_id" required>
                                <option value="">Pilih Agama</option>
                                <?php foreach ($agama as $a) : ?>
                                    <option value="<?= $a['id'] ?>"><?= $a['nama_agama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Perhatian:</strong> Setelah dikonversi, calon siswa akan menjadi siswa aktif dan dapat login ke sistem SIAKAD sebagai siswa.
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" 
                                    onclick="return confirm('Konversi calon siswa ini menjadi siswa aktif?')">
                                <i class="fas fa-user-plus"></i> Konversi ke Siswa
                            </button>
                            <a href="<?= base_url('admin/calon-siswa') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto-fill jurusan based on calon siswa's choice
    $('#jurusan_id').change(function() {
        var jurusanId = $(this).val();
        if (jurusanId) {
            // You can add AJAX to load classes based on jurusan if needed
        }
    });
});
</script>
<?= $this->endSection() ?> 
 
 