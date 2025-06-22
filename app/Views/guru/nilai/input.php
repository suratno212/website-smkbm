<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-primary">
                                <i class="fas fa-edit me-2"></i>Input Nilai Siswa
                            </h4>
                            <p class="text-muted mb-0">
                                Kelas: <strong><?= $kelas['nama_kelas'] ?></strong> | 
                                Mata Pelajaran: <strong><?= $mapel['nama_mapel'] ?></strong> | 
                                Semester: <strong><?= $semester ?></strong>
                            </p>
                        </div>
                        <div class="text-end">
                            <a href="<?= base_url('guru/nilai') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- DEBUG: Tampilkan tahun_akademik_id -->
    <div class="alert alert-info">Tahun Akademik Aktif ID: <?= $tahun_akademik_id ?></div>

    <!-- Class Info -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h5 class="mb-1">Total Siswa</h5>
                    <h3 class="mb-0"><?= count($siswaList) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h5 class="mb-1">Sudah Dinilai</h5>
                    <h3 class="mb-0" id="sudahDinilai">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h5 class="mb-1">Belum Dinilai</h5>
                    <h3 class="mb-0" id="belumDinilai">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h5 class="mb-1">Rata-rata</h5>
                    <h3 class="mb-0" id="rataRata">0.00</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Input Form -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>Form Input Nilai
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($siswaList)) : ?>
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Siswa</h5>
                            <p class="text-muted">Belum ada siswa yang terdaftar di kelas ini.</p>
                        </div>
                    <?php else : ?>
                        <form action="<?= base_url('guru/nilai/store') ?>" method="POST" id="nilaiForm">
                            <?= csrf_field() ?>
                            <input type="hidden" name="kelas_id" value="<?= $kelasId ?>">
                            <input type="hidden" name="mapel_id" value="<?= $mapelId ?>">
                            <input type="hidden" name="semester" value="<?= $semester ?>">
                            <input type="hidden" name="tahun_akademik_id" value="<?= $tahun_akademik_id ?>">
                            <div class="alert alert-warning">DEBUG: tahun_akademik_id di form = <?= $tahun_akademik_id ?></div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">NIS</th>
                                            <th width="25%">Nama Siswa</th>
                                            <th width="15%">UTS (30%)</th>
                                            <th width="15%">UAS (40%)</th>
                                            <th width="15%">Tugas (30%)</th>
                                            <th width="10%">Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($siswaList as $index => $siswa) : ?>
                                            <?php 
                                            $existingNilai = $nilaiMap[$siswa['id']] ?? null;
                                            $uts = $existingNilai ? $existingNilai['uts'] : '';
                                            $uas = $existingNilai ? $existingNilai['uas'] : '';
                                            $tugas = $existingNilai ? $existingNilai['tugas'] : '';
                                            $akhir = $existingNilai ? $existingNilai['akhir'] : '';
                                            ?>
                                            <tr>
                                                <td class="align-middle"><?= $index + 1 ?></td>
                                                <td class="align-middle">
                                                    <strong><?= $siswa['nisn'] ?></strong>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary rounded-circle p-2 me-2">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                        <div>
                                                            <strong><?= $siswa['nama'] ?></strong>
                                                            <br>
                                                            <small class="text-muted"><?= $siswa['nama_kelas'] ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <input type="number" 
                                                           class="form-control nilai-input" 
                                                           name="uts[]" 
                                                           value="<?= $uts ?>"
                                                           min="0" 
                                                           max="100" 
                                                           step="0.01"
                                                           data-siswa="<?= $siswa['id'] ?>"
                                                           data-type="uts"
                                                           placeholder="0-100">
                                                </td>
                                                <td class="align-middle">
                                                    <input type="number" 
                                                           class="form-control nilai-input" 
                                                           name="uas[]" 
                                                           value="<?= $uas ?>"
                                                           min="0" 
                                                           max="100" 
                                                           step="0.01"
                                                           data-siswa="<?= $siswa['id'] ?>"
                                                           data-type="uas"
                                                           placeholder="0-100">
                                                </td>
                                                <td class="align-middle">
                                                    <input type="number" 
                                                           class="form-control nilai-input" 
                                                           name="tugas[]" 
                                                           value="<?= $tugas ?>"
                                                           min="0" 
                                                           max="100" 
                                                           step="0.01"
                                                           data-siswa="<?= $siswa['id'] ?>"
                                                           data-type="tugas"
                                                           placeholder="0-100">
                                                </td>
                                                <td class="align-middle">
                                                    <input type="hidden" name="siswa_id[]" value="<?= $siswa['id'] ?>">
                                                    <span class="badge bg-success fs-6 nilai-akhir" 
                                                          data-siswa="<?= $siswa['id'] ?>"
                                                          data-nilai-db="<?= $akhir ?>">
                                                        <?= $akhir ? number_format($akhir, 2) : '-' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <button type="button" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="calculateAll()">
                                        <i class="fas fa-calculator me-2"></i>Hitung Semua
                                    </button>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
                                        <i class="fas fa-save me-2"></i>Simpan Nilai
                                    </button>
                                </div>
                            </div>
                        </form>
                        <script>
                        document.getElementById('nilaiForm').addEventListener('submit', function(e) {
                            let fd = new FormData(this);
                            let out = '';
                            for (let [k,v] of fd.entries()) {
                                out += k+': '+v+'\n';
                            }
                            alert('DEBUG POST DATA:\n'+out);
                        });
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Calculate final score when input changes
document.querySelectorAll('.nilai-input').forEach(input => {
    input.addEventListener('input', function() {
        const siswaId = this.dataset.siswa;
        calculateNilai(siswaId);
        updateStats();
    });
});

function calculateNilai(siswaId) {
    const utsInput = document.querySelector(`input[data-siswa="${siswaId}"][data-type="uts"]`);
    const uasInput = document.querySelector(`input[data-siswa="${siswaId}"][data-type="uas"]`);
    const tugasInput = document.querySelector(`input[data-siswa="${siswaId}"][data-type="tugas"]`);
    const akhirSpan = document.querySelector(`.nilai-akhir[data-siswa="${siswaId}"]`);
    
    const uts = parseFloat(utsInput.value) || 0;
    const uas = parseFloat(uasInput.value) || 0;
    const tugas = parseFloat(tugasInput.value) || 0;
    
    // Calculate final score (30% UTS + 40% UAS + 30% Tugas)
    const akhir = (uts * 0.3) + (uas * 0.4) + (tugas * 0.3);
    
    if (akhir > 0) {
        akhirSpan.textContent = akhir.toFixed(2);
        akhirSpan.className = 'badge bg-success fs-6 nilai-akhir';
        akhirSpan.setAttribute('data-nilai-db', akhir.toFixed(2));
    } else {
        akhirSpan.textContent = '-';
        akhirSpan.className = 'badge bg-secondary fs-6 nilai-akhir';
        akhirSpan.setAttribute('data-nilai-db', '');
    }
}

function calculateAll() {
    const siswaIds = [...new Set(Array.from(document.querySelectorAll('.nilai-input')).map(input => input.dataset.siswa))];
    siswaIds.forEach(siswaId => {
        calculateNilai(siswaId);
    });
    updateStats();
}

function updateStats() {
    const akhirSpans = document.querySelectorAll('.nilai-akhir');
    let sudahDinilai = 0;
    let totalNilai = 0;
    let countNilai = 0;
    akhirSpans.forEach(span => {
        let nilai = parseFloat(span.textContent);
        if (!isNaN(nilai) && nilai > 0) {
            sudahDinilai++;
            totalNilai += nilai;
            countNilai++;
        }
    });
    const belumDinilai = akhirSpans.length - sudahDinilai;
    const rataRata = countNilai > 0 ? (totalNilai / countNilai) : 0;
    document.getElementById('sudahDinilai').textContent = sudahDinilai;
    document.getElementById('belumDinilai').textContent = belumDinilai;
    document.getElementById('rataRata').textContent = rataRata.toFixed(2);
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset semua nilai?')) {
        document.querySelectorAll('.nilai-input').forEach(input => {
            input.value = '';
        });
        document.querySelectorAll('.nilai-akhir').forEach(span => {
            span.textContent = '-';
            span.className = 'badge bg-secondary fs-6 nilai-akhir';
            span.setAttribute('data-nilai-db', '');
        });
        updateStats();
    }
}

// Initialize stats on page load
document.addEventListener('DOMContentLoaded', function() {
    updateStats();
});
</script>

<?= $this->endSection() ?> 