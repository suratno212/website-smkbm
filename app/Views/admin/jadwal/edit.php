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
                                    <label for="tahun_akademik_id">Tahun Akademik</label>
                                    <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control <?= session('errors.tahun_akademik_id') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Tahun Akademik</option>
                                        <?php foreach ($tahun_akademik as $ta) : ?>
                                            <option value="<?= $ta['id'] ?>" <?= old('tahun_akademik_id', $jadwal['tahun_akademik_id']) == $ta['id'] ? 'selected' : '' ?>>
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
                                    <label for="mapel_id">Mata Pelajaran</label>
                                    <select name="mapel_id" id="mapel_id" class="form-control <?= session('errors.mapel_id') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        <?php foreach ($mapel as $m) : ?>
                                            <option value="<?= $m['id'] ?>" <?= old('mapel_id', $jadwal['mapel_id']) == $m['id'] ? 'selected' : '' ?>>
                                                <?= $m['nama_mapel'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.mapel_id')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.mapel_id') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="guru_id">Guru</label>
                                    <select name="guru_id" id="guru_id" class="form-control <?= session('errors.guru_id') ? 'is-invalid' : '' ?>" required>
                                        <option value="">Pilih Guru</option>
                                        <?php foreach ($guru as $g) : ?>
                                            <option value="<?= $g['id'] ?>" <?= old('guru_id', $jadwal['guru_id']) == $g['id'] ? 'selected' : '' ?>>
                                                <?= $g['nama'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.guru_id')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.guru_id') ?>
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