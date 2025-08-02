<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="mb-4">Tambah Soal SPMB</h1>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $e): ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('admin/spmbsoal/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <div class="form-group">
            <label>Pertanyaan</label>
            <textarea name="soal" class="form-control" required><?= old('soal') ?></textarea>
        </div>
        <div class="form-group">
            <label>Pilihan A</label>
            <input type="text" name="pilihan_a" class="form-control" value="<?= old('pilihan_a') ?>" required>
        </div>
        <div class="form-group">
            <label>Pilihan B</label>
            <input type="text" name="pilihan_b" class="form-control" value="<?= old('pilihan_b') ?>" required>
        </div>
        <div class="form-group">
            <label>Pilihan C</label>
            <input type="text" name="pilihan_c" class="form-control" value="<?= old('pilihan_c') ?>" required>
        </div>
        <div class="form-group">
            <label>Pilihan D</label>
            <input type="text" name="pilihan_d" class="form-control" value="<?= old('pilihan_d') ?>" required>
        </div>
        <div class="form-group">
            <label>Jawaban Benar</label>
            <select name="jawaban_benar" class="form-control" required>
                <option value="">Pilih</option>
                <option value="a" <?= old('jawaban_benar')=='a'?'selected':'' ?>>A</option>
                <option value="b" <?= old('jawaban_benar')=='b'?'selected':'' ?>>B</option>
                <option value="c" <?= old('jawaban_benar')=='c'?'selected':'' ?>>C</option>
                <option value="d" <?= old('jawaban_benar')=='d'?'selected':'' ?>>D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/spmbsoal') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?> 
 
 
 
 
 