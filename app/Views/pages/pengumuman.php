<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --accent-color: #3b82f6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(30, 58, 138, 0.95) !important;
            backdrop-filter: blur(10px);
        }
        
        .main-content {
            padding: 80px 0 40px 0;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        
        .footer {
            background: rgba(30, 58, 138, 0.9);
            color: white;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" height="40" class="d-inline-block align-text-top me-2">
                SMK Bhakti Mulya BNS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('pengumuman') ?>">Pengumuman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('jadwal-ujian') ?>">Jadwal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('ppdb') ?>">PPDB</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-sm ms-2" href="<?= base_url('auth') ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2 class="mb-0">
                                <i class="fas fa-bullhorn me-2"></i>
                                Pengumuman Sekolah
                            </h2>
                            <p class="mb-0 mt-2">Informasi terbaru dari SMK Bhakti Mulya BNS</p>
                        </div>
                        <div class="card-body">
                            <?php if (empty($pengumuman)) : ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-info-circle fa-4x text-muted mb-3"></i>
                                    <h4 class="text-muted">Belum ada pengumuman</h4>
                                    <p class="text-muted">Pengumuman akan muncul di sini ketika admin mempublikasikannya</p>
                                </div>
                            <?php else : ?>
                                <?php foreach ($pengumuman as $p) : ?>
                                    <div class="alert alert-<?= $p['jenis'] == 'Jadwal Ujian' ? 'danger' : ($p['jenis'] == 'Kegiatan' ? 'warning' : 'info') ?>">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="alert-heading">
                                                    <i class="fas fa-<?= $p['jenis'] == 'Jadwal Ujian' ? 'calendar-alt' : ($p['jenis'] == 'Kegiatan' ? 'star' : 'info-circle') ?> me-2"></i>
                                                    <?= $p['judul'] ?>
                                                </h5>
                                                <?php if ($p['isi']) : ?>
                                                    <p class="mb-2"><?= nl2br($p['isi']) ?></p>
                                                <?php endif; ?>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-tag me-1"></i> <?= $p['jenis'] ?> | 
                                                        <i class="fas fa-calendar me-1"></i> <?= date('d F Y H:i', strtotime($p['created_at'])) ?>
                                                    </small>
                                                    <?php if ($p['file']) : ?>
                                                        <a href="<?= base_url('download-pengumuman/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download me-1"></i> Download File
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 SMK Bhakti Mulya BNS. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 