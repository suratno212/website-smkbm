<form action="<?= base_url('guru/pertemuan/store') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="kelas_id" value="<?= esc($kelas_id) ?>">
    <div class="mb-3">
        <label for="mapel_id" class="form-label">Mata Pelajaran</label>
        <select name="mapel_id" id="mapel_id" class="form-select" required>
            <option value="">Pilih Mapel</option>
            <?php foreach ($mapel as $m): ?>
                <option value="<?= $m['id'] ?>"><?= esc($m['nama_mapel']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="nama_pertemuan" class="form-label">Nama Pertemuan</label>
        <input type="text" name="nama_pertemuan" id="nama_pertemuan" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="topik" class="form-label">Topik</label>
        <input type="text" name="topik" id="topik" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<form action="<?= base_url('guru/pertemuan/generate_otomatis') ?>" method="post" class="mb-4">
    <?= csrf_field() ?>
    <input type="hidden" name="kelas_id" value="<?= esc($kelas_id) ?>">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" class="form-select" required>
                <option value="">Pilih Mapel</option>
                <?php foreach ($mapel as $m): ?>
                    <option value="<?= $m['id'] ?>"><?= esc($m['nama_mapel']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Hari</label>
            <select name="hari" class="form-select" required>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Jumlah Pertemuan</label>
            <input type="number" name="jumlah" class="form-control" min="1" max="40" value="10" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success">Generate Otomatis</button>
        </div>
    </div>
</form> 