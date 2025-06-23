<?= $this->extend('layout/kepalasekolah') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3><?= esc($title) ?></h3>
    <div class="mb-3">Login sebagai: <strong><?= esc($user['username'] ?? '-') ?></strong></div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Rata-rata Nilai</th>
                    <th>Status Kelulusan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ahmad</td>
                    <td>XII TKJ 1</td>
                    <td>87.5</td>
                    <td>Lulus</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Budi</td>
                    <td>XII TKJ 1</td>
                    <td>82.3</td>
                    <td>Lulus</td>
                </tr>
                <!-- Tambahkan baris lain sesuai kebutuhan -->
            </tbody>
        </table>
    </div>
</div> 