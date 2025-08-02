<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Jadwal Pelajaran</h1>
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

                            <form action="<?= base_url('admin/jadwal/update/' . $jadwal['id']) ?>" method="post">
                                <div class="form-group">
                                    <label for="kd_tahun_akademik">Tahun Akademik</label>
                                    <select name="kd_tahun_akademik" id="kd_tahun_akademik" class="form-control <?= session('errors.kd_tahun_akademik') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Tahun Akademik</option>
                                        <?php foreach ($tahun_akademik as $ta) : ?>
                                            <option value="<?= $ta['kd_tahun_akademik'] ?>" <?= old('kd_tahun_akademik', $jadwal['kd_tahun_akademik']) == $ta['kd_tahun_akademik'] ? 'selected' : '' ?>>
                                                <?= $ta['tahun'] ?> - Semester <?= $ta['semester'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.kd_tahun_akademik')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.kd_tahun_akademik') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control <?= session('errors.kelas_id') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['id'] ?>" <?= old('kelas_id', $jadwal['kelas_id']) == $k['id'] ? 'selected' : '' ?>>
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.kelas_id')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.kelas_id') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="kd_mapel">Mata Pelajaran</label>
                                    <select name="kd_mapel" id="kd_mapel" class="form-control <?= session('errors.kd_mapel') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        <?php foreach ($mapel as $m) : ?>
                                            <option value="<?= $m['kd_mapel'] ?>" <?= old('kd_mapel', $jadwal['kd_mapel']) == $m['kd_mapel'] ? 'selected' : '' ?>>
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
                                            <option value="<?= $g['nik_nip'] ?>" <?= old('nik_nip', $jadwal['nik_nip']) == $g['nik_nip'] ? 'selected' : '' ?>>
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
                                        <option value="Senin" <?= old('hari', $jadwal['hari']) == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                        <option value="Selasa" <?= old('hari', $jadwal['hari']) == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                        <option value="Rabu" <?= old('hari', $jadwal['hari']) == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                        <option value="Kamis" <?= old('hari', $jadwal['hari']) == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                        <option value="Jumat" <?= old('hari', $jadwal['hari']) == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                        <option value="Sabtu" <?= old('hari', $jadwal['hari']) == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                    </select>
                                    <?php if (session('errors.hari')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.hari') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control <?= session('errors.jam_mulai') ? 'is-invalid' : '' ?>" value="<?= old('jam_mulai', $jadwal['jam_mulai']) ?>" required>
                                    <?php if (session('errors.jam_mulai')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.jam_mulai') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control <?= session('errors.jam_selesai') ? 'is-invalid' : '' ?>" value="<?= old('jam_selesai', $jadwal['jam_selesai']) ?>" required>
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
        </div>
    </section>
</div>
<?= $this->endSection() ?> 