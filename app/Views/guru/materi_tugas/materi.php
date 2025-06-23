<?= $this->extend('layout/guru') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('guru/materitugas') ?>">E-Learning</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Materi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Daftar Materi</h1>
                        <p class="welcome-subtitle">Kelola semua materi pembelajaran Anda</p>
                    </div>
                    <div class="welcome-illustration">
                        <div class="floating-card">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterKelompok" class="form-label">Filter Kelompok Mapel</label>
            <select id="filterKelompok" class="form-select">
                <option value="">Semua Kelompok</option>
                <option value="A">A. Muatan Nasional</option>
                <option value="B">B. Muatan Kewilayahan</option>
                <option value="C1">C1. Dasar Bidang Keahlian</option>
                <option value="C2">C2. Dasar Program Keahlian</option>
                <option value="C3">C3. Kompetensi Keahlian</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-modern">
                    <div class="header-content">
                        <div class="header-icon"><i class="fas fa-book"></i></div>
                        <div class="header-text">
                            <h4 class="header-title">Semua Materi</h4>
                            <p class="header-subtitle">Daftar lengkap materi pembelajaran</p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <a href="<?= base_url('guru/materitugas/uploadMateri') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Upload Materi Baru
                        </a>
                    </div>
                </div>
                <div class="card-body-modern">
                    <?php if (empty($materi)): ?>
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-book"></i></div>
                            <h5 class="empty-title">Belum ada materi</h5>
                            <p class="empty-subtitle">Upload materi pembelajaran untuk siswa</p>
                            <a href="<?= base_url('guru/materitugas/uploadMateri') ?>" class="btn btn-primary">Upload Materi</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="materiTableBody">
                                    <?php
                                    // Urutkan materi berdasarkan kelompok mapel
                                    usort($materi, function($a, $b) {
                                        return strcmp($a['kelompok'] ?? '', $b['kelompok'] ?? '');
                                    });
                                    ?>
                                    <?php foreach ($materi as $index => $m): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="file-icon me-2">
                                                    <i class="fas fa-file-pdf"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= $m['judul'] ?></h6>
                                                    <?php if ($m['file']): ?>
                                                        <small class="text-muted"><?= $m['file'] ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary"><?= $m['nama_mapel'] ?? 'N/A' ?><?php if (!empty($m['kelompok'])): ?> <span class="badge bg-secondary ms-1">[<?= $m['kelompok'] ?>]</span><?php endif; ?></span></td>
                                        <td><span class="badge bg-info"><?= $m['nama_kelas'] ?? 'N/A' ?></span></td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                  title="<?= $m['deskripsi'] ?>">
                                                <?= $m['deskripsi'] ?: '-' ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($m['created_at'] ?? 'now')) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <?php if ($m['file']): ?>
                                                    <a href="<?= base_url('guru/materitugas/download/' . $m['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?= base_url('guru/materitugas/editMateri/' . $m['id']) ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('guru/materitugas/deleteMateri/' . $m['id']) ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Yakin ingin menghapus materi ini?')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
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
</div>

<style>
.welcome-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}

.welcome-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.floating-card {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.card-header-modern {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 40px;
    height: 40px;
    background: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.header-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    color: #495057;
}

.header-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.card-body-modern {
    padding: 1.5rem;
}

.file-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #e3f2fd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
}

.empty-state {
    text-align: center;
    padding: 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: #6c757d;
}

.empty-title {
    margin-bottom: 0.5rem;
    color: #495057;
}

.empty-subtitle {
    color: #6c757d;
    margin-bottom: 1.5rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .card-body-modern {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>
<script>
document.getElementById('filterKelompok').addEventListener('change', function() {
    var val = this.value;
    var rows = document.querySelectorAll('#materiTableBody tr');
    rows.forEach(function(row) {
        var kelompok = row.querySelector('td span.badge.bg-secondary');
        if (!val || (kelompok && kelompok.textContent.replace(/\[|\]/g, '') === val)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
<?= $this->endSection() ?> 