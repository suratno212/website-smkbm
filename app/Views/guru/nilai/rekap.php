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
                                <i class="fas fa-chart-bar me-2"></i>Rekap Nilai Siswa
                            </h4>
                            <p class="text-muted mb-0">
                                Kelas: <strong><?= $kelas['nama_kelas'] ?> - <?= $kelas['nama_jurusan'] ?></strong> | 
                                Semester: <strong><?= $semester ?></strong>
                            </p>
                        </div>
                        <div class="text-end">
                            <a href="<?= base_url('guru/nilai') ?>" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button onclick="window.print()" class="btn btn-success">
                                <i class="fas fa-print me-2"></i>Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards (landscape/1 baris) -->
    <div class="row mb-4 statistik-row">
        <div class="col-3">
            <div class="card bg-primary text-white text-center mb-0">
                <div class="card-body p-2">
                    <i class="fas fa-users fa-2x mb-1"></i>
                    <div class="fw-bold">Total Siswa</div>
                    <div class="fs-5 mb-0"><?= count($siswaList) ?></div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-success text-white text-center mb-0">
                <div class="card-body p-2">
                    <i class="fas fa-book fa-2x mb-1"></i>
                    <div class="fw-bold">Mata Pelajaran</div>
                    <div class="fs-5 mb-0"><?= count($mapelList) ?></div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-info text-white text-center mb-0">
                <div class="card-body p-2">
                    <i class="fas fa-chart-line fa-2x mb-1"></i>
                    <div class="fw-bold">Rata-rata Kelas</div>
                    <div class="fs-5 mb-0" id="rataRataKelas">0.00</div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-warning text-white text-center mb-0">
                <div class="card-body p-2">
                    <i class="fas fa-trophy fa-2x mb-1"></i>
                    <div class="fw-bold">Nilai Tertinggi</div>
                    <div class="fs-5 mb-0" id="nilaiTertinggi">0.00</div>
                </div>
            </div>
        </div>
    </div>
    <style>
    @media print {
        .statistik-row { margin-bottom: 10px !important; }
        .statistik-row .card { margin-bottom: 0 !important; }
        .statistik-row .col-3 { width: 25% !important; float: left; }
        .statistik-row .card-body { padding: 6px 2px !important; font-size: 12px; }
        .statistik-row i { font-size: 1.2em !important; }
    }
    </style>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Filter Data
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="filterMapel" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="filterMapel">
                                <option value="">Semua Mata Pelajaran</option>
                                <?php foreach ($mapelList as $mapel) : ?>
                                    <option value="<?= $mapel['id'] ?>"><?= $mapel['nama_mapel'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filterRange" class="form-label">Rentang Nilai</label>
                            <select class="form-select" id="filterRange">
                                <option value="">Semua Nilai</option>
                                <option value="90-100">90-100 (A)</option>
                                <option value="80-89">80-89 (B)</option>
                                <option value="70-79">70-79 (C)</option>
                                <option value="60-69">60-69 (D)</option>
                                <option value="0-59">0-59 (E)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="searchSiswa" class="form-label">Cari Siswa</label>
                            <input type="text" class="form-control" id="searchSiswa" placeholder="Nama atau NIS...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Summary Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>Rekap Nilai Siswa
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($siswaList)) : ?>
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Data</h5>
                            <p class="text-muted">Belum ada siswa yang terdaftar di kelas ini.</p>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="nilaiTable">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">NIS</th>
                                        <th width="20%">Nama Siswa</th>
                                        <?php foreach ($mapelList as $mapel) : ?>
                                            <th class="text-center" data-mapel="<?= $mapel['id'] ?>">
                                                <?= $mapel['nama_mapel'] ?>
                                            </th>
                                        <?php endforeach; ?>
                                        <th width="10%" class="text-center">Rata-rata</th>
                                        <th width="10%" class="text-center">Ranking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $rankingData = [];
                                    foreach ($siswaList as $index => $siswa) : 
                                        $totalNilai = 0;
                                        $countNilai = 0;
                                        $nilaiSiswa = [];
                                    ?>
                                        <tr data-siswa="<?= $siswa['id'] ?>">
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
                                            <?php foreach ($mapelList as $mapel) : ?>
                                                <?php 
                                                $nilai = $nilaiData[$siswa['id']][$mapel['id']] ?? null;
                                                $nilaiAkhir = $nilai ? $nilai['akhir'] : 0;
                                                $nilaiSiswa[$mapel['id']] = $nilaiAkhir;
                                                
                                                if ($nilaiAkhir > 0) {
                                                    $totalNilai += $nilaiAkhir;
                                                    $countNilai++;
                                                }
                                                ?>
                                                <td class="text-center align-middle">
                                                    <?php if ($nilaiAkhir > 0) : ?>
                                                        <span class="badge <?= getNilaiBadgeClass($nilaiAkhir) ?> fs-6">
                                                            <?= number_format($nilaiAkhir, 2) ?>
                                                        </span>
                                                    <?php else : ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <?php 
                                            $rataRata = $countNilai > 0 ? ($totalNilai / $countNilai) : 0;
                                            $rankingData[] = [
                                                'siswa_id' => $siswa['id'],
                                                'nama' => $siswa['nama'],
                                                'rata_rata' => $rataRata,
                                                'count_nilai' => $countNilai
                                            ];
                                            ?>
                                            <td class="text-center align-middle">
                                                <?php if ($rataRata > 0) : ?>
                                                    <span class="badge <?= getNilaiBadgeClass($rataRata) ?> fs-6">
                                                        <?= number_format($rataRata, 2) ?>
                                                    </span>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge bg-secondary fs-6 ranking-badge" data-siswa="<?= $siswa['id'] ?>">
                                                    -
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Distribution Chart -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Nilai
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="gradeChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list-ol me-2"></i>Top 5 Siswa
                    </h5>
                </div>
                <div class="card-body">
                    <div id="topStudents">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Area Tanda Tangan (hanya muncul saat cetak) -->
<style>
@media print {
    .ttd-area {
        display: flex;
        justify-content: space-between;
        margin-top: 60px;
        padding: 0 40px;
    }
    .ttd-box {
        width: 40%;
        text-align: center;
    }
    .ttd-space {
        height: 80px; /* ruang untuk tanda tangan */
    }
}
</style>
<div class="ttd-area d-none d-print-flex mt-5">
    <div class="ttd-box">
        <div>Mengetahui,<br>Kepala Sekolah</div>
        <div class="ttd-space"><!-- Tambahkan <img src="..." alt="TTD Kepala Sekolah"> di sini jika ingin tanda tangan digital --></div>
        <div><u><!-- Nama Kepala Sekolah --></u><br>NIP: <!-- NIP Kepala Sekolah --></div>
    </div>
    <div class="ttd-box">
        <div><?= date('d F Y') ?><br>Wali Kelas</div>
        <div class="ttd-space"><!-- Tambahkan <img src="..." alt="TTD Wali Kelas"> di sini jika ingin tanda tangan digital --></div>
        <div><u><!-- Nama Wali Kelas --></u><br>NIP: <!-- NIP Wali Kelas --></div>
    </div>
</div>
<!--
Catatan:
- Untuk menampilkan tanda tangan digital, upload file scan ttd ke folder uploads, lalu ganti komentar <img src="..."> dengan path file ttd.
- Nama dan NIP bisa diisi manual atau diambil dari database jika sudah tersedia.
-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Store ranking data globally
const rankingData = <?= json_encode($rankingData) ?>;

// Calculate and display rankings
function calculateRankings() {
    // Sort by average score (descending)
    const sortedData = [...rankingData].sort((a, b) => b.rata_rata - a.rata_rata);
    
    // Update ranking badges
    sortedData.forEach((data, index) => {
        const badge = document.querySelector(`.ranking-badge[data-siswa="${data.siswa_id}"]`);
        if (badge && data.rata_rata > 0) {
            badge.textContent = index + 1;
            badge.className = 'badge fs-6 ranking-badge';
            
            if (index === 0) {
                badge.classList.add('bg-warning', 'text-dark');
            } else if (index === 1) {
                badge.classList.add('bg-secondary');
            } else if (index === 2) {
                badge.classList.add('bg-danger');
            } else {
                badge.classList.add('bg-info');
            }
        }
    });
    
    // Update top 5 students
    updateTopStudents(sortedData.slice(0, 5));
    
    // Update statistics
    updateStatistics(sortedData);
}

function updateTopStudents(topData) {
    const container = document.getElementById('topStudents');
    container.innerHTML = '';
    
    topData.forEach((data, index) => {
        if (data.rata_rata > 0) {
            const card = document.createElement('div');
            card.className = 'd-flex align-items-center mb-3 p-2 border rounded';
            
            const rankClass = index === 0 ? 'bg-warning text-dark' : 
                            index === 1 ? 'bg-secondary' : 
                            index === 2 ? 'bg-danger' : 'bg-info';
            
            card.innerHTML = `
                <div class="badge ${rankClass} me-3 fs-6">${index + 1}</div>
                <div class="flex-grow-1">
                    <strong>${data.nama}</strong>
                    <br>
                    <small class="text-muted">Rata-rata: ${data.rata_rata.toFixed(2)}</small>
                </div>
            `;
            container.appendChild(card);
        }
    });
}

function updateStatistics(data) {
    const validData = data.filter(d => d.rata_rata > 0);
    
    if (validData.length > 0) {
        const rataRataKelas = validData.reduce((sum, d) => sum + d.rata_rata, 0) / validData.length;
        const nilaiTertinggi = Math.max(...validData.map(d => d.rata_rata));
        
        document.getElementById('rataRataKelas').textContent = rataRataKelas.toFixed(2);
        document.getElementById('nilaiTertinggi').textContent = nilaiTertinggi.toFixed(2);
    }
}

// Filter functionality
document.getElementById('filterMapel').addEventListener('change', filterTable);
document.getElementById('filterRange').addEventListener('change', filterTable);
document.getElementById('searchSiswa').addEventListener('input', filterTable);

function filterTable() {
    const mapelFilter = document.getElementById('filterMapel').value;
    const rangeFilter = document.getElementById('filterRange').value;
    const searchFilter = document.getElementById('searchSiswa').value.toLowerCase();
    
    const rows = document.querySelectorAll('#nilaiTable tbody tr');
    
    rows.forEach(row => {
        let showRow = true;
        
        // Search filter
        if (searchFilter) {
            const nama = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const nis = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (!nama.includes(searchFilter) && !nis.includes(searchFilter)) {
                showRow = false;
            }
        }
        
        // Mapel filter
        if (mapelFilter && showRow) {
            const nilaiCell = row.querySelector(`td[data-mapel="${mapelFilter}"]`);
            if (nilaiCell && nilaiCell.textContent.trim() === '-') {
                showRow = false;
            }
        }
        
        // Range filter
        if (rangeFilter && showRow) {
            const rataRataCell = row.querySelector('td:nth-last-child(2)');
            const nilai = parseFloat(rataRataCell.textContent);
            if (!isNaN(nilai)) {
                const [min, max] = rangeFilter.split('-').map(Number);
                if (nilai < min || nilai > max) {
                    showRow = false;
                }
            }
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateRankings();
});

<?php
function getNilaiBadgeClass($nilai) {
    if ($nilai >= 90) return 'bg-success';
    if ($nilai >= 80) return 'bg-primary';
    if ($nilai >= 70) return 'bg-warning text-dark';
    if ($nilai >= 60) return 'bg-info';
    return 'bg-danger';
}
?>
</script>

<?= $this->endSection() ?> 