<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-lg-7 col-md-9">
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body p-4">
        <h2 class="mb-4 text-center" style="color: var(--primary-color); font-weight:700;">Formulir Pendaftaran SPMB</h2>
        <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('spmb/daftar') ?>" method="post" class="mt-3">
          <?= csrf_field() ?>
          <div class="form-group mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
              <option value="">- Pilih -</option>
              <option value="Laki-laki" <?= old('jenis_kelamin')=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
              <option value="Perempuan" <?= old('jenis_kelamin')=='Perempuan'?'selected':'' ?>>Perempuan</option>
            </select>
          </div>
          <div class="form-group mb-3">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>Agama</label>
            <select name="agama_id" class="form-control" required>
              <option value="">- Pilih Agama -</option>
              <?php foreach ($agama as $a): ?>
                <option value="<?= $a['id'] ?>" <?= old('agama_id')==$a['id']?'selected':'' ?>><?= esc($a['nama_agama']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required><?= old('alamat') ?></textarea>
          </div>
          <div class="form-group mb-3">
            <label>Asal Sekolah</label>
            <input type="text" name="asal_sekolah" class="form-control" value="<?= old('asal_sekolah') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>Nama Orang Tua</label>
            <input type="text" name="nama_ortu" class="form-control" value="<?= old('nama_ortu') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>No. HP Orang Tua</label>
            <input type="text" name="no_hp_ortu" class="form-control" value="<?= old('no_hp_ortu') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>No. HP</label>
            <input type="text" name="no_hp" class="form-control" value="<?= old('no_hp') ?>" required>
          </div>
          <div class="form-group mb-3">
            <label>Jurusan Pilihan</label>
            <select name="jurusan_id" class="form-control" required>
              <option value="">- Pilih Jurusan -</option>
              <?php foreach ($jurusan as $j): ?>
                <option value="<?= $j['id'] ?>" <?= old('jurusan_id')==$j['id']?'selected':'' ?>><?= esc($j['nama_jurusan']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group mb-4">
            <label>NISN</label>
            <input type="text" name="nisn" class="form-control" value="<?= old('nisn') ?>" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg" style="background: var(--primary-color); border: none;">Daftar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?> 