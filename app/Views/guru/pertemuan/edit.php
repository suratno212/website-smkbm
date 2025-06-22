<form action="<?= base_url('guru/pertemuan/update/'.$pertemuan['id']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="mapel_id" class="form-label">Mata Pelajaran</label>
        <select name="mapel_id" id="mapel_id" class="form-select" required>
            <option value="">Pilih Mapel</option>
            <?php foreach ($mapel as $m): ?>
                <option value="<?= $m['id'] ?>" <?= $pertemuan['mapel_id'] == $m['id'] ? 'selected' : '' ?>><?= esc($m['nama_mapel']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="nama_pertemuan" class="form-label">Nama Pertemuan</label>
        <input type="text" name="nama_pertemuan" id="nama_pertemuan" class="form-control" value="<?= esc($pertemuan['nama_pertemuan']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= esc($pertemuan['tanggal']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="topik" class="form-label">Topik</label>
        <input type="text" name="topik" id="topik" class="form-control" value="<?= esc($pertemuan['topik']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form> 