<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="mb-4">Bank Soal SPMB (30 Soal)</h1>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"> <?= session()->getFlashdata('error') ?> </div>
    <?php endif; ?>
    <div class="row">
        <?php
        // Buat array index soal 1-30
        $soalMap = [];
        foreach ($soal as $idx => $s) {
            $soalMap[$idx+1] = $s;
        }
        for ($i=1; $i<=30; $i++):
            $s = $soalMap[$i] ?? null;
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <b>Soal <?= $i ?></b>
                </div>
                <div class="card-body">
                    <?php if ($s): ?>
                        <div class="mb-2"><b>Pertanyaan:</b><br><?= esc($s['soal']) ?></div>
                        <?php if (!empty($s['gambar'])): ?>
                            <img src="<?= base_url('uploads/spmb_soal/'.$s['gambar']) ?>" alt="Gambar Soal" style="max-width:100px;max-height:100px;" class="mb-2">
                        <?php endif; ?>
                        <div><b>A.</b> <?= esc($s['pilihan_a']) ?></div>
                        <div><b>B.</b> <?= esc($s['pilihan_b']) ?></div>
                        <div><b>C.</b> <?= esc($s['pilihan_c']) ?></div>
                        <div><b>D.</b> <?= esc($s['pilihan_d']) ?></div>
                        <div class="mt-2"><b>Jawaban Benar:</b> <span class="badge bg-success"> <?= strtoupper($s['jawaban_benar']) ?> </span></div>
                        <a href="<?= base_url('admin/spmbsoal/edit/'.$s['kd_soal']) ?>" class="btn btn-warning btn-sm mt-3">Edit</a>
                        <form action="<?= base_url('admin/spmbsoal/delete/'.$s['kd_soal']) ?>" method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger btn-sm mt-3" onclick="return confirm('Hapus soal ini?')">Hapus</button>
                        </form>
                    <?php else: ?>
                        <div class="text-muted">Belum ada soal.</div>
                        <a href="<?= base_url('admin/spmbsoal/create') ?>" class="btn btn-primary btn-sm mt-3">Tambah Soal</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>
<?= $this->endSection() ?> 