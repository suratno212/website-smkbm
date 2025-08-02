<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Edit Tugas</h3>
    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('guru/materitugas/updateTugas/' . $tugas['kd_tugas']) ?>" method="post" enctype="multipart/form-data" class="mt-3">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="kd_kelas" class="form-label">Kelas</label>
            <select name="kd_kelas" id="kd_kelas" class="form-select" required>
                <option value="">- Pilih Kelas -</option>
                <?php if (!empty($kelas_diampu)): foreach ($kelas_diampu as $k): ?>
                        <option value="<?= $k['kd_kelas'] ?>" <?= (old('kd_kelas', $tugas['kd_kelas']) == $k['kd_kelas']) ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                <?php endforeach;
                endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="kd_mapel" class="form-label">Mata Pelajaran</label>
            <select name="kd_mapel" id="kd_mapel" class="form-select" required>
                <option value="">- Pilih Mata Pelajaran -</option>
                <?php if (!empty($mapel_diampu)): foreach ($mapel_diampu as $m): ?>
                        <option value="<?= $m['kd_mapel'] ?>" <?= (old('kd_mapel', $tugas['kd_mapel']) == $m['kd_mapel']) ? 'selected' : '' ?>><?= esc($m['nama_mapel']) ?></option>
                <?php endforeach;
                endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Tugas</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul', $tugas['judul']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required><?= old('deskripsi', $tugas['deskripsi']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="<?= old('deadline', date('Y-m-d\TH:i', strtotime($tugas['deadline']))) ?>" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">File Tugas (pdf, doc, docx, max 10MB)</label>
            <?php if ($tugas['file']): ?>
                <div class="alert alert-info">
                    <strong>File saat ini:</strong> <?= $tugas['file'] ?>
                    <br><small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                </div>
            <?php endif; ?>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Tugas</button>
        <a href="<?= base_url('guru/materitugas/tugas') ?>" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?>