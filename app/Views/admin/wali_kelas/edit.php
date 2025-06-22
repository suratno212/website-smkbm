<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Wali Kelas</h1>
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
                            <h3 class="card-title">Form Edit Wali Kelas</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('admin/wali_kelas/update/' . $wali_kelas['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                
                                <div class="form-group">
                                    <label for="tahun_akademik_id">Tahun Akademik</label>
                                    <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control <?= ($validation->hasError('tahun_akademik_id')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Tahun Akademik</option>
                                        <?php foreach ($tahun_akademik as $ta) : ?>
                                            <option value="<?= $ta['id'] ?>" <?= (old('tahun_akademik_id', $wali_kelas['tahun_akademik_id']) == $ta['id']) ? 'selected' : '' ?>>
                                                <?= $ta['tahun'] ?> - Semester <?= $ta['semester'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tahun_akademik_id') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control <?= ($validation->hasError('kelas_id')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Kelas</option>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['id'] ?>" <?= (old('kelas_id', $wali_kelas['kelas_id']) == $k['id']) ? 'selected' : '' ?>>
                                                <?= $k['nama_kelas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kelas_id') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="guru_id">Guru</label>
                                    <select name="guru_id" id="guru_id" class="form-control <?= ($validation->hasError('guru_id')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Guru</option>
                                        <?php foreach ($guru as $g) : ?>
                                            <option value="<?= $g['id'] ?>" <?= (old('guru_id', $wali_kelas['guru_id']) == $g['id']) ? 'selected' : '' ?>>
                                                <?= $g['nama'] ?> (<?= $g['nama_mapel'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('guru_id') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update</button>
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