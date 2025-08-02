<?php
if (!isset($jurusan)) $jurusan = [];
if (!isset($agama)) $agama = [];
?>
<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-lg-7 col-md-10">
    <div class="card shadow-lg border-0 mb-4" style="border-radius:18px;">
      <div class="card-body p-5">
        <div class="text-center mb-4">
          <h2 class="mb-2" style="color: var(--primary-color); font-weight:700;"><i class="fas fa-user-plus me-2"></i>Formulir Pendaftaran SPMB</h2>
          <p class="text-muted mb-0">Silakan isi data diri Anda dengan benar untuk mendaftar sebagai calon peserta didik baru SMK Bhakti Mulya.</p>
        </div>
        <?php if (isset($errors) && $errors): ?>
          <div class="alert alert-danger">
            <h6 class="alert-heading">
              <i class="fas fa-exclamation-triangle me-2"></i>
              Terdapat kesalahan dalam pengisian formulir:
            </h6>
            <ul class="mb-0 mt-2">
              <?php foreach ($errors as $field => $error): ?>
                <?php if (is_array($error)): ?>
                  <?php foreach ($error as $err): ?>
                    <li><?= esc($err) ?></li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li><?= esc($error) ?></li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <form action="<?= base_url('spmb/daftar') ?>" method="post" class="mt-3">
          <?= csrf_field() ?>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-user"></i> Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                  <option value="">- Pilih -</option>
                  <option value="Laki-laki" <?= old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                  <option value="Perempuan" <?= old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-map-marker-alt"></i> Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-calendar-alt"></i> Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-praying-hands"></i> Agama</label>
                <select name="agama_id" class="form-control" required>
                  <option value="">- Pilih Agama -</option>
                  <?php foreach ($agama as $a): ?>
                    <option value="<?= $a['id'] ?>" <?= old('agama_id') == $a['id'] ? 'selected' : '' ?>><?= esc($a['nama_agama']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-graduation-cap"></i> Jurusan Pilihan</label>
                <select name="kd_jurusan" class="form-control" required>
                  <option value="">- Pilih Jurusan -</option>
                  <?php foreach ($jurusan as $j): ?>
                    <option value="<?= isset($j['kd_jurusan']) ? $j['kd_jurusan'] : '' ?>" <?= old('kd_jurusan') == (isset($j['kd_jurusan']) ? $j['kd_jurusan'] : '') ? 'selected' : '' ?>><?= esc($j['nama_jurusan'] ?? '-') ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-home"></i> Alamat</label>
                <textarea name="alamat" class="form-control" required><?= old('alamat') ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-school"></i> Asal Sekolah</label>
                <input type="text" name="asal_sekolah" class="form-control" value="<?= old('asal_sekolah') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-id-card"></i> NIS</label>
                <input type="text" name="nis" class="form-control" value="<?= old('nis') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-user-friends"></i> Nama Orang Tua</label>
                <input type="text" name="nama_ortu" class="form-control" value="<?= old('nama_ortu') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-phone"></i> No. HP Orang Tua</label>
                <input type="text" name="no_hp_ortu" class="form-control" value="<?= old('no_hp_ortu') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="fw-semibold"><i class="fas fa-mobile-alt"></i> No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="<?= old('no_hp') ?>" required>
              </div>
            </div>
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg" style="background: var(--primary-color); border: none; border-radius:8px; font-weight:600;"><i class="fas fa-paper-plane me-2"></i>Daftar Sekarang</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>