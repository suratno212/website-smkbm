<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Jadwal Pelajaran</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('admin/jadwal/store') ?>" method="post">
                                <div class="form-group">
                                    <label for="tahun_akademik_id">Tahun Akademik</label>
                                    <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control <?= session('errors.tahun_akademik_id') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Tahun Akademik</option>
                                        <?php foreach ($tahun_akademik as $ta) : ?>
                                            <option value="<?= $ta['kd_tahun_akademik'] ?>" <?= old('tahun_akademik_id') == $ta['kd_tahun_akademik'] ? 'selected' : '' ?>>
                                                <?= $ta['tahun'] ?> - Semester <?= $ta['semester'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.tahun_akademik_id')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.tahun_akademik_id') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="kd_kelas">Kelas</label>
                                    <select name="kd_kelas" id="kd_kelas" class="form-control <?= session('errors.kd_kelas') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['kd_kelas'] ?>" data-jurusan="<?= $k['jurusan_id'] ?? '' ?>">
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.kd_kelas')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.kd_kelas') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="kd_mapel">Mata Pelajaran</label>
                                    <select name="kd_mapel" id="kd_mapel" class="form-control <?= session('errors.kd_mapel') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        <?php foreach ($mapel as $m) : ?>
                                            <option value="<?= $m['kd_mapel'] ?>" data-jurusan="<?= $m['jurusan_id'] ?? '' ?>">
                                                <?= $m['nama_mapel'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.kd_mapel')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.kd_mapel') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="nik_nip">Guru</label>
                                    <select name="nik_nip" id="nik_nip" class="form-control <?= session('errors.nik_nip') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Guru</option>
                                        <?php foreach ($guru as $g) : ?>
                                            <option value="<?= $g['nik_nip'] ?>" <?= old('nik_nip') == $g['nik_nip'] ? 'selected' : '' ?>>
                                                <?= $g['nama'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.nik_nip')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.nik_nip') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="hari">Hari</label>
                                    <select name="hari" id="hari" class="form-control <?= session('errors.hari') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin" <?= old('hari') == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                        <option value="Selasa" <?= old('hari') == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                        <option value="Rabu" <?= old('hari') == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                        <option value="Kamis" <?= old('hari') == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                        <option value="Jumat" <?= old('hari') == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                        <option value="Sabtu" <?= old('hari') == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                    </select>
                                    <?php if (session('errors.hari')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.hari') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control <?= session('errors.jam_mulai') ? 'is-invalid' : '' ?>" value="<?= old('jam_mulai') ?>" required>
                                    <?php if (session('errors.jam_mulai')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.jam_mulai') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control <?= session('errors.jam_selesai') ? 'is-invalid' : '' ?>" value="<?= old('jam_selesai') ?>" required>
                                    <?php if (session('errors.jam_selesai')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.jam_selesai') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="<?= base_url('admin/jadwal') ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-success text-white">Generate Otomatis Pertemuan</div>
                <div class="card-body">
                    <form action="<?= base_url('admin/jadwal/generatePertemuanOtomatis') ?>" method="post">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-control" required>
                                    <option value="">Pilih Kelas</option>
                                    <?php foreach ($kelas as $k): ?>
                                        <option value="<?= $k['id'] ?>"><?= esc($k['nama_kelas']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mata Pelajaran</label>
                                <select name="kd_mapel" class="form-control" required>
                                    <option value="">Pilih Mapel</option>
                                    <?php foreach ($mapel as $m): ?>
                                        <option value="<?= $m['kd_mapel'] ?>"><?= esc($m['nama_mapel']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Hari</label>
                                <select name="hari" class="form-control" required>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" min="1" max="40" value="10" required>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success">Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.getElementById('kd_kelas').addEventListener('change', function() {
        var jurusanId = this.options[this.selectedIndex].getAttribute('data-jurusan');
        var mapelSelect = document.getElementById('kd_mapel');
        for (var i = 0; i < mapelSelect.options.length; i++) {
            var opt = mapelSelect.options[i];
            if (!opt.value || !opt.getAttribute('data-jurusan') || opt.getAttribute('data-jurusan') == jurusanId) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        }
        mapelSelect.value = '';
    });
</script>
<?= $this->endSection() ?>