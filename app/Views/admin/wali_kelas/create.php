<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Wali Kelas</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Wali Kelas</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('admin/wali_kelas/store') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="form-group">
                                    <label for="kd_tahun_akademik">Tahun Akademik</label>
                                    <select name="kd_tahun_akademik" id="kd_tahun_akademik" class="form-control <?= ($validation->hasError('kd_tahun_akademik')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Tahun Akademik</option>
                                        <?php foreach ($tahun_akademik as $ta) : ?>
                                            <option value="<?= $ta['kd_tahun_akademik'] ?>" <?= old('kd_tahun_akademik') == $ta['kd_tahun_akademik'] ? 'selected' : '' ?>>
                                                <?= $ta['tahun'] ?> - Semester <?= $ta['semester'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kd_tahun_akademik') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control <?= ($validation->hasError('kelas_id')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['id'] ?>" <?= old('kelas_id') == $k['id'] ? 'selected' : '' ?>>
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kelas_id') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nik_nip">Guru</label>
                                    <select name="nik_nip" id="nik_nip" class="form-control <?= ($validation->hasError('nik_nip')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Guru</option>
                                        <?php foreach ($guru as $g) : ?>
                                            <option value="<?= $g['nik_nip'] ?>" <?= old('nik_nip') == $g['nik_nip'] ? 'selected' : '' ?>>
                                                <?= $g['nama'] ?> (<?= $g['nama_mapel'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nik_nip') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="<?= base_url('admin/wali_kelas') ?>" class="btn btn-secondary">Kembali</a>
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