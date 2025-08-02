<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="mb-4">Edit Soal SPMB</h1>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $e): ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('admin/spmbsoal/update/'.$soal['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?php if (!empty($soal['gambar'])): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/spmb_soal/'.$soal['gambar']) ?>" alt="Gambar Soal" style="max-width:200px;max-height:200px;">
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <div class="form-group">
            <label>Pertanyaan</label>
            <textarea name="soal" class="form-control" required><?= old('soal', $soal['soal']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Pilihan A</label>
            <input type="text" name="pilihan_a" class="form-control" value="<?= old('pilihan_a', $soal['pilihan_a']) ?>" required>
        </div>
        <div class="form-group">
            <label>Pilihan B</label>
            <input type="text" name="pilihan_b" class="form-control" value="<?= old('pilihan_b', $soal['pilihan_b']) ?>" required>
        </div>
        <div class="form-group">
            <label>Pilihan C</label>
            <input type="text" name="pilihan_c" class="form-control" value="<?= old('pilihan_c', $soal['pilihan_c']) ?>" required>
        </div>
        <div class="form-group">
            <label>Pilihan D</label>
            <input type="text" name="pilihan_d" class="form-control" value="<?= old('pilihan_d', $soal['pilihan_d']) ?>" required>
        </div>
        <div class="form-group">
            <label>Jawaban Benar</label>
            <select name="jawaban_benar" class="form-control" required>
                <option value="">Pilih</option>
                <option value="a" <?= old('jawaban_benar', $soal['jawaban_benar'])=='a'?'selected':'' ?>>A</option>
                <option value="b" <?= old('jawaban_benar', $soal['jawaban_benar'])=='b'?'selected':'' ?>>B</option>
                <option value="c" <?= old('jawaban_benar', $soal['jawaban_benar'])=='c'?'selected':'' ?>>C</option>
                <option value="d" <?= old('jawaban_benar', $soal['jawaban_benar'])=='d'?'selected':'' ?>>D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('admin/spmbsoal') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection() ?> 
 
 
 
 
 