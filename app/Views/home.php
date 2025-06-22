<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <!-- Update color variables -->
    <style>
        :root {
            --primary-color: #1B2A78;
            --secondary-color: #F7D117;
            --white-color: #FFFFFF;
            --text-dark: #333333;
            --text-light: #666666;
            --bg-light: #f8f9fa;
            --shadow-color: rgba(27, 42, 120, 0.1);
        }

        /* Tab Contents Background */
        .tab-contents {
            position: relative;
            min-height: 400px;
            background: url('<?= base_url('assets/images/bg/pattern.png') ?>') center/cover;
            padding: 40px 0;
        }

        .tab-contents::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(27, 42, 120, 0.95) 0%, rgba(27, 42, 120, 0.85) 100%);
            z-index: 0;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="loader-content">
            <div class="logo-container">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo SMK" class="logo-spin">
                <div class="loading-circle"></div>
            </div>
        </div>
    </div>

    <!-- PPDB Popup -->
    <div id="ppdbPopup" class="popup-overlay">
        <div class="popup-content">
            <div class="popup-body">
                <button class="close-popup">&times;</button>
                <img src="<?= base_url('assets/images/ppdb/popup.jpg') ?>" alt="PPDB 2024" class="popup-image">
                <div class="popup-info">
                    <h4>Tahun Ajaran 2024/2025</h4>
                    <p>Pendaftaran: 1 Januari - 30 Juni 2024</p>
                    <div class="popup-buttons">
                        <a href="https://instagram.com/smkbmbns" target="_blank" class="instagram-btn">
                            <i class="fab fa-instagram"></i> Lihat Instagram
                        </a>
                        <button class="dont-show-btn" id="dontShowAgain">
                            <i class="fas fa-times"></i> Jangan Tampilkan Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $navbar ?>

    <!-- Hero Section -->
    <section class="hero">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="<?= base_url('assets/images/hero/hero1.png') ?>" class="d-block w-100" alt="SMK Bhakti Mulya">
                    <div class="carousel-caption">
                        <h2>Penerimaan Peserta Didik Baru</h2>
                        <p>Tahun Ajaran 2024/2025</p>
                        <p>Pendaftaran: 1 Januari - 30 Juni 2024</p>
                        <a href="#ppdb" class="hero-btn">Daftar Sekarang</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?= base_url('assets/images/hero/hero2.jpg') ?>" class="d-block w-100" alt="Fasilitas Sekolah">
                    <div class="carousel-caption">
                        <h2>Fasilitas Modern</h2>
                        <p>Laboratorium dan Workshop Terlengkap</p>
                        <p>Untuk Meningkatkan Kompetensi Siswa</p>
                        <a href="#profil" class="hero-btn">Lihat Fasilitas</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?= base_url('assets/images/hero/hero3.jpg') ?>" class="d-block w-100" alt="Kegiatan Sekolah">
                    <div class="carousel-caption">
                        <h2>Kegiatan Pembelajaran</h2>
                        <p>Belajar dengan Metode Modern</p>
                        <p>Didukung Tenaga Pengajar Profesional</p>
                        <a href="#jurusan" class="hero-btn">Lihat Jurusan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Informasi Sekolah</h2>
                <p>Selamat datang di website resmi SMK Bhakti Mulya BNS Lampung</p>
            </div>

            <div class="features-tabs">
                <div class="tab-buttons">
                    <button class="tab-btn active" data-tab="profil">
                        <i class="fas fa-school"></i>
                        <span>Profil Sekolah</span>
                    </button>
                    <button class="tab-btn" data-tab="visi-misi">
                        <i class="fas fa-bullseye"></i>
                        <span>Visi & Misi</span>
                    </button>
                    <button class="tab-btn" data-tab="sambutan">
                        <i class="fas fa-user-tie"></i>
                        <span>Sambutan</span>
                    </button>
                    <button class="tab-btn" data-tab="pengumuman">
                        <i class="fas fa-bullhorn"></i>
                        <span>Pengumuman</span>
                    </button>
                    <button class="tab-btn" data-tab="agenda">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Agenda</span>
                    </button>
                    <button class="tab-btn" data-tab="infografis">
                        <i class="fas fa-chart-pie"></i>
                        <span>Infografis</span>
                    </button>
                    <button class="tab-btn" data-tab="video">
                        <i class="fas fa-video"></i>
                        <span>Video</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Tab Contents -->
    <section class="tab-contents">
        <div class="container">
            <div class="tab-pane active" id="profil">
                <div class="content-wrapper">
                    <h3>Profil Sekolah</h3>
                    <div class="content-body">
                        <div class="profil-sekolah">
                            <div class="profil-image">
                                <img src="<?= base_url('assets/images/profil/sekolah.png') ?>" alt="Gedung Sekolah">
                                <div class="profil-overlay">
                                    <div class="profil-stats">
                                        <div class="stat-item">
                                            <i class="fas fa-users"></i>
                                            <span class="stat-number">500+</span>
                                            <span class="stat-label">Siswa</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                            <span class="stat-number">30+</span>
                                            <span class="stat-label">Guru</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-graduation-cap"></i>
                                            <span class="stat-number">90%</span>
                                            <span class="stat-label">Lulusan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profil-description">
                                <p>SMK Bhakti Mulya BNS Lampung didirikan pada tahun 1990 dengan visi menjadi sekolah unggulan yang menghasilkan lulusan berkompeten dan berkarakter. Sekolah ini telah menghasilkan ribuan lulusan yang tersebar di berbagai industri dan perguruan tinggi ternama.</p>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="year">1990</div>
                                        <div class="event">Pendirian SMK Bhakti Mulya</div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="year">2000</div>
                                        <div class="event">Pengembangan Fasilitas Modern</div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="year">2010</div>
                                        <div class="event">Akreditasi A</div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="year">2020</div>
                                        <div class="event">Pembukaan Program Keahlian Baru</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="visi-misi">
                <div class="content-wrapper">
                    <h3>Visi & Misi</h3>
                    <div class="content-body">
                        <div class="visi">
                            <h4>Visi</h4>
                            <p>Menjadi SMK unggulan yang menghasilkan lulusan berkompeten dan berkarakter</p>
                        </div>
                        <div class="misi">
                            <h4>Misi</h4>
                            <ul>
                                <li>Menyelenggarakan pendidikan yang berkualitas</li>
                                <li>Mengembangkan kompetensi siswa sesuai kebutuhan industri</li>
                                <li>Membentuk karakter siswa yang berakhlak mulia</li>
                                <li>Mengoptimalkan fasilitas pembelajaran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="sambutan">
                <div class="content-wrapper">
                    <h3>Sambutan</h3>
                    <div class="content-body">
                        <!-- Sambutan Ketua Yayasan -->
                        <div class="kepsek-profile">
                            <img src="<?= base_url('assets/images/ketua-yayasan.jpg') ?>" alt="Ketua Yayasan">
                            <div class="kepsek-info">
                                <h4>Rofil Mahmudi</h4>
                                <p>Ketua Yayasan Bhakti Mulya</p>
                            </div>
                        </div>
                        <div class="sambutan-text">
                            <p>Selamat datang di SMK Bhakti Mulya BNS Lampung. Sebagai Ketua Yayasan, saya sangat bangga dengan perkembangan sekolah ini yang terus berkomitmen memberikan pendidikan berkualitas. Kami bertekad untuk terus meningkatkan kualitas pendidikan dan menghasilkan lulusan yang kompeten dan berkarakter.</p>
                        </div>

                        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

                        <!-- Sambutan Kepala Sekolah -->
                        <div class="kepsek-profile">
                            <img src="<?= base_url('assets/images/kepsek.jpg') ?>" alt="Kepala Sekolah">
                            <div class="kepsek-info">
                                <h4>Joni Haryanto, S.T</h4>
                                <p>Kepala SMK Bhakti Mulya BNS Lampung</p>
                            </div>
                        </div>
                        <div class="sambutan-text">
                            <p>Selamat datang di SMK Bhakti Mulya BNS Lampung, sekolah yang mengutamakan kualitas pendidikan. Kami berkomitmen untuk memberikan pendidikan terbaik bagi generasi muda Indonesia dengan fasilitas modern dan tenaga pengajar yang profesional.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="pengumuman">
                <div class="content-wrapper">
                    <h3>Pengumuman</h3>
                    <div class="content-body">
                        <div class="pengumuman-list">
                            <?php if (empty($pengumuman)) : ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada pengumuman</h5>
                                    <p class="text-muted">Pengumuman akan muncul di sini ketika admin mempublikasikannya</p>
                                </div>
                            <?php else : ?>
                                <?php foreach (array_slice($pengumuman, 0, 6) as $p) : ?>
                            <div class="pengumuman-item">
                                <div class="pengumuman-image">
                                            <?php if ($p['file'] && pathinfo($p['file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($p['file'], PATHINFO_EXTENSION) == 'png' || pathinfo($p['file'], PATHINFO_EXTENSION) == 'jpeg') : ?>
                                                <img src="<?= base_url('uploads/pengumuman/' . $p['file']) ?>" alt="<?= $p['judul'] ?>">
                                            <?php else : ?>
                                                <img src="<?= base_url('assets/images/pengumuman/default.jpg') ?>" alt="<?= $p['judul'] ?>">
                                            <?php endif; ?>
                                </div>
                                <div class="pengumuman-content">
                                            <div class="date"><?= date('d M Y', strtotime($p['created_at'])) ?></div>
                                            <div class="badge badge-<?= $p['jenis'] == 'Jadwal Ujian' ? 'danger' : ($p['jenis'] == 'Kegiatan' ? 'warning' : 'info') ?> mb-2">
                                                <?= $p['jenis'] ?>
                                </div>
                                            <h4><?= $p['judul'] ?></h4>
                                            <p><?= $p['isi'] ? (strlen($p['isi']) > 100 ? substr($p['isi'], 0, 100) . '...' : $p['isi']) : 'Tidak ada deskripsi' ?></p>
                                            <div class="pengumuman-actions">
                                                <?php if ($p['file']) : ?>
                                                    <a href="<?= base_url('download-pengumuman/' . $p['id']) ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?= base_url('pengumuman') ?>" class="read-more">Lihat Semua Pengumuman</a>
                            </div>
                                </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="agenda">
                <div class="content-wrapper">
                    <h3>Agenda Sekolah</h3>
                    <div class="content-body">
                        <div class="agenda-list">
                            <div class="agenda-item">
                                <div class="agenda-image">
                                    <img src="<?= base_url('assets/images/agenda/workshop.jpg') ?>" alt="Workshop">
                                </div>
                                <div class="agenda-content">
                                    <div class="date">20 Mar 2024</div>
                                    <h4>Workshop Teknologi</h4>
                                    <p>Workshop pengembangan teknologi untuk siswa jurusan Teknik Informatika</p>
                                    <div class="agenda-details">
                                        <span><i class="fas fa-clock"></i> 09:00 - 15:00</span>
                                        <span><i class="fas fa-map-marker-alt"></i> Ruang Lab Komputer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-image">
                                    <img src="<?= base_url('assets/images/agenda/kunjungan.jpg') ?>" alt="Kunjungan Industri">
                                </div>
                                <div class="agenda-content">
                                    <div class="date">25 Mar 2024</div>
                                    <h4>Kunjungan Industri</h4>
                                    <p>Kunjungan ke perusahaan mitra untuk siswa kelas XI</p>
                                    <div class="agenda-details">
                                        <span><i class="fas fa-clock"></i> 08:00 - 16:00</span>
                                        <span><i class="fas fa-map-marker-alt"></i> PT. Mitra Industri</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="infografis">
                <div class="content-wrapper">
                    <h3>Infografis</h3>
                    <div class="content-body">
                        <div class="infografis-grid">
                            <div class="infografis-item">
                                <img src="<?= base_url('assets/images/infografis/statistik-siswa.jpg') ?>" alt="Statistik Siswa">
                                <div class="infografis-overlay">
                                    <h4>Statistik Siswa</h4>
                                    <p>Data jumlah siswa per jurusan tahun 2024</p>
                                </div>
                            </div>
                            <div class="infografis-item">
                                <img src="<?= base_url('assets/images/infografis/prestasi.jpg') ?>" alt="Prestasi">
                                <div class="infografis-overlay">
                                    <h4>Prestasi</h4>
                                    <p>Prestasi akademik dan non-akademik</p>
                                </div>
                            </div>
                            <div class="infografis-item">
                                <img src="<?= base_url('assets/images/infografis/fasilitas.jpg') ?>" alt="Fasilitas">
                                <div class="infografis-overlay">
                                    <h4>Fasilitas</h4>
                                    <p>Fasilitas pembelajaran dan sarana prasarana</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="video">
                <div class="content-wrapper">
                    <h3>Video Sekolah</h3>
                    <div class="content-body">
                        <div class="video-grid">
                            <div class="video-item">
                                <div class="video-container">
                                    <iframe width="100%" height="315" 
                                        src="https://www.youtube.com/embed/jvZ-r2R-des" 
                                        title="Video Profil Sekolah" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <h4>Video Profil Sekolah</h4>
                                <p>Kenali lebih dekat SMK Bhakti Mulya BNS Lampung</p>
                            </div>
                            <div class="video-item">
                                <div class="video-container">
                                    <iframe width="100%" height="315" 
                                        src="https://www.youtube.com/embed/yBtlX-ZAwqQ" 
                                        title="Kegiatan Sekolah" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <h4>Kegiatan Sekolah</h4>
                                <p>Dokumentasi kegiatan belajar mengajar dan ekstrakurikuler</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section id="berita" class="berita">
        <div class="container">
            <div class="section-title">
                <h2>Berita Terkini</h2>
                <p>Informasi terbaru seputar kegiatan sekolah</p>
            </div>
            <div class="berita-grid">
                <div class="berita-item">
                    <div class="berita-image">
                        <img src="<?= base_url('assets/images/berita/berita1.jpg') ?>" alt="Berita 1">
                    </div>
                    <div class="berita-content">
                        <div class="date">20 Mar 2024</div>
                        <h3>Workshop Teknologi Terkini</h3>
                        <p>Siswa jurusan Teknik Informatika mengikuti workshop pengembangan aplikasi mobile.</p>
                        <a href="#" class="read-more">Baca Selengkapnya</a>
                    </div>
                </div>
                <div class="berita-item">
                    <div class="berita-image">
                        <img src="<?= base_url('assets/images/berita/berita2.jpg') ?>" alt="Berita 2">
                    </div>
                    <div class="berita-content">
                        <div class="date">18 Mar 2024</div>
                        <h3>Prestasi Lomba Robotik</h3>
                        <p>Tim robotik sekolah berhasil meraih juara 2 dalam kompetisi robotik tingkat provinsi.</p>
                        <a href="#" class="read-more">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pengumuman Section -->
    <section id="pengumuman" class="pengumuman">
        <div class="container">
            <div class="section-title">
                <h2>Pengumuman Terbaru</h2>
                <p>Informasi penting dan pengumuman resmi dari sekolah</p>
            </div>
            <div class="pengumuman-grid">
                <?php if (empty($pengumuman)) : ?>
                    <div class="pengumuman-empty">
                        <div class="empty-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3>Belum ada pengumuman</h3>
                        <p>Pengumuman akan muncul di sini ketika admin mempublikasikannya</p>
                    </div>
                <?php else : ?>
                    <?php foreach (array_slice($pengumuman, 0, 6) as $p) : ?>
                        <div class="pengumuman-card">
                            <div class="pengumuman-image">
                                <?php if ($p['file'] && in_array(pathinfo($p['file'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) : ?>
                                    <img src="<?= base_url('uploads/pengumuman/' . $p['file']) ?>" alt="<?= $p['judul'] ?>">
                                <?php else : ?>
                                    <img src="<?= base_url('assets/images/Logo.png') ?>" alt="<?= $p['judul'] ?>">
                                <?php endif; ?>
                                <div class="pengumuman-badge">
                                    <span class="badge badge-<?= $p['jenis'] == 'Jadwal Ujian' ? 'danger' : ($p['jenis'] == 'Kegiatan' ? 'warning' : 'info') ?>">
                                        <?= $p['jenis'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="pengumuman-content">
                                <div class="pengumuman-meta">
                                    <span class="date"><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($p['created_at'])) ?></span>
                                    <span class="time"><i class="far fa-clock"></i> <?= date('H:i', strtotime($p['created_at'])) ?></span>
                                </div>
                                <h3><?= $p['judul'] ?></h3>
                                <p><?= $p['isi'] ? (strlen($p['isi']) > 120 ? substr($p['isi'], 0, 120) . '...' : $p['isi']) : 'Tidak ada deskripsi' ?></p>
                                <div class="pengumuman-actions">
                                    <?php if ($p['file']) : ?>
                                        <a href="<?= base_url('download-pengumuman/' . $p['id']) ?>" class="btn-download">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('pengumuman') ?>" class="btn-more">
                                        <i class="fas fa-arrow-right"></i> Lihat Semua
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($pengumuman) && count($pengumuman) > 6) : ?>
                <div class="pengumuman-more">
                    <a href="<?= base_url('pengumuman') ?>" class="btn-view-all">
                        <i class="fas fa-list"></i> Lihat Semua Pengumuman
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Jurusan Section -->
    <section id="jurusan" class="jurusan">
        <div class="container">
            <div class="section-title">
                <h2>Program Keahlian</h2>
                <p>Pilihan jurusan yang tersedia di SMK Bhakti Mulya BNS Lampung</p>
            </div>
            <div class="jurusan-grid">
                <div class="jurusan-item">
                    <div class="jurusan-image">
                        <img src="<?= base_url('assets/images/jurusan/tkj.jpg') ?>" alt="Teknik Komputer dan Jaringan">
                    </div>
                    <div class="jurusan-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Teknik Komputer dan Jaringan</h3>
                    <p>Mempelajari instalasi jaringan komputer, administrasi sistem, dan keamanan jaringan.</p>
                    <div class="jurusan-details">
                        <span><i class="fas fa-clock"></i> 3 Tahun</span>
                        <span><i class="fas fa-users"></i> 36 Siswa/Kelas</span>
                    </div>
                </div>
                <div class="jurusan-item">
                    <div class="jurusan-image">
                        <img src="<?= base_url('assets/images/jurusan/tbsm.jpg') ?>" alt="Teknik Bisnis Sepeda Motor">
                    </div>
                    <div class="jurusan-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <h3>Teknik Bisnis Sepeda Motor</h3>
                    <p>Mempelajari perawatan, perbaikan, dan bisnis sepeda motor modern.</p>
                    <div class="jurusan-details">
                        <span><i class="fas fa-clock"></i> 3 Tahun</span>
                        <span><i class="fas fa-users"></i> 36 Siswa/Kelas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeri Section -->
    <section id="galeri" class="galeri">
        <div class="container">
            <div class="section-title">
                <h2>Galeri Kegiatan</h2>
                <p>Dokumentasi kegiatan belajar mengajar dan ekstrakurikuler</p>
            </div>
            <div class="galeri-grid" id="galeri-container">
                <!-- Row 1 -->
                <!-- Kegiatan 1: Praktikum Lab -->
                <div class="galeri-item" data-gallery="praktikum">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum1.jpg') ?>" alt="Praktikum Lab 1" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum2.jpg') ?>" alt="Praktikum Lab 2" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum3.jpg') ?>" alt="Praktikum Lab 3" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                    </div>
                    <div class="galeri-info">
                        <h4>Praktikum Lab</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 3 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 15 Maret 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan 2: Perpisahan -->
                <div class="galeri-item" data-gallery="perpisahan">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan1.jpg') ?>" alt="Perpisahan 1" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan2.jpg') ?>" alt="Perpisahan 2" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan3.jpg') ?>" alt="Perpisahan 3" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                    </div>
                    <div class="galeri-info">
                        <h4>Perpisahan Angkatan 8</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 4 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 20 Maret 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan 3: Ekstrakurikuler -->
                <div class="galeri-item" data-gallery="ekstra">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra1.jpg') ?>" alt="Ekstrakurikuler 1" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra2.jpg') ?>" alt="Ekstrakurikuler 2" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra3.jpg') ?>" alt="Ekstrakurikuler 3" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                    </div>
                    <div class="galeri-info">
                        <h4>Kegiatan Ekstrakurikuler</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 3 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 25 Maret 2024</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Gallery Items -->
            <div class="galeri-items-hidden" id="hidden-galeri">
                <!-- Row 2 -->
                <!-- Kegiatan 1: Praktikum Lab -->
                <div class="galeri-item" data-gallery="praktikum">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum1.jpg') ?>" alt="Praktikum Lab 1" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum2.jpg') ?>" alt="Praktikum Lab 2" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum3.jpg') ?>" alt="Praktikum Lab 3" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                    </div>
                    <div class="galeri-info">
                        <h4>Praktikum Lab</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 3 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 15 Maret 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan 2: Perpisahan -->
                <div class="galeri-item" data-gallery="perpisahan">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan1.jpg') ?>" alt="Perpisahan 1" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan2.jpg') ?>" alt="Perpisahan 2" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan3.jpg') ?>" alt="Perpisahan 3" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                    </div>
                    <div class="galeri-info">
                        <h4>Perpisahan Angkatan 8</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 4 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 20 Maret 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan 3: Ekstrakurikuler -->
                <div class="galeri-item" data-gallery="ekstra">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra1.jpg') ?>" alt="Ekstrakurikuler 1" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra2.jpg') ?>" alt="Ekstrakurikuler 2" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra3.jpg') ?>" alt="Ekstrakurikuler 3" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                    </div>
                    <div class="galeri-info">
                        <h4>Kegiatan Ekstrakurikuler</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 3 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 25 Maret 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Row 3 -->
                <!-- Kegiatan 1: Praktikum Lab -->
                <div class="galeri-item" data-gallery="praktikum">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum1.jpg') ?>" alt="Praktikum Lab 1" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum2.jpg') ?>" alt="Praktikum Lab 2" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                        <img src="<?= base_url('assets/images/galeri/praktikum/praktikum3.jpg') ?>" alt="Praktikum Lab 3" data-title="Praktikum Lab" data-desc="Siswa sedang melakukan praktikum di laboratorium komputer">
                    </div>
                    <div class="galeri-info">
                        <h4>Praktikum Lab</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 3 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 15 Maret 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan 2: Perpisahan -->
                <div class="galeri-item" data-gallery="perpisahan">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan1.jpg') ?>" alt="Perpisahan 1" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan2.jpg') ?>" alt="Perpisahan 2" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                        <img src="<?= base_url('assets/images/galeri/perpisahan/perpisahan3.jpg') ?>" alt="Perpisahan 3" data-title="Perpisahan Angkatan 8" data-desc="Acara perpisahan angkatan 8 SMK Bhakti Mulya">
                    </div>
                    <div class="galeri-info">
                        <h4>Perpisahan Angkatan 8</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 4 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 20 Maret 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan 3: Ekstrakurikuler -->
                <div class="galeri-item" data-gallery="ekstra">
                    <div class="galeri-images">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra1.jpg') ?>" alt="Ekstrakurikuler 1" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra2.jpg') ?>" alt="Ekstrakurikuler 2" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                        <img src="<?= base_url('assets/images/galeri/ekstra/ekstra3.jpg') ?>" alt="Ekstrakurikuler 3" data-title="Kegiatan Ekstrakurikuler" data-desc="Kegiatan ekstrakurikuler robotik">
                    </div>
                    <div class="galeri-info">
                        <h4>Kegiatan Ekstrakurikuler</h4>
                        <div class="galeri-meta">
                            <span class="photo-count"><i class="fas fa-images"></i> 3 Foto</span>
                            <span class="date"><i class="far fa-calendar-alt"></i> 25 Maret 2024</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="show-more-container" style="text-align: center; margin-top: 30px;">
                <button id="toggle-galeri" class="show-more-btn">
                    <i class="fas fa-chevron-down"></i> Tampilkan Semua Galeri
                </button>
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox">
        <div class="lightbox-content">
            <span class="close-lightbox">&times;</span>
            <div class="lightbox-navigation">
                <button class="lightbox-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="lightbox-next"><i class="fas fa-chevron-right"></i></button>
            </div>
            <img src="" alt="" class="lightbox-image">
            <div class="lightbox-caption">
                <h3></h3>
                <p></p>
                <div class="lightbox-counter"></div>
            </div>
        </div>
    </div>

    <!-- Data Pegawai Section -->
    <section id="pegawai" class="pegawai">
        <div class="container">
            <div class="section-title">
                <h2>Data Pegawai</h2>
                <p>Tenaga pendidik dan kependidikan SMK Bhakti Mulya BNS Lampung</p>
            </div>
            <div class="pegawai-grid">
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai1.jpg') ?>" alt="Solatun Khoiriyah">
                    </div>
                    <div class="pegawai-info">
                        <h3>Solatun Khoiriyah, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai2.jpg') ?>" alt="Melia Damayanti">
                    </div>
                    <div class="pegawai-info">
                        <h3>Melia Damayanti, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai3.jpg') ?>" alt="Peppi Sutriyani">
                    </div>
                    <div class="pegawai-info">
                        <h3>Peppi Sutriyani, S.Sos</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pegawai-grid-more" style="display: none;">
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai4.jpg') ?>" alt="Sugianto">
                    </div>
                    <div class="pegawai-info">
                        <h3>Sugianto, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai5.jpg') ?>" alt="Rizky Amalia">
                    </div>
                    <div class="pegawai-info">
                        <h3>Rizky Amalia, S.E</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai6.jpg') ?>" alt="Munawar">
                    </div>
                    <div class="pegawai-info">
                        <h3>Munawar, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai7.jpg') ?>" alt="Septi Dwiyani">
                    </div>
                    <div class="pegawai-info">
                        <h3>Septi Dwiyani, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai8.jpg') ?>" alt="Siti Munawaroh">
                    </div>
                    <div class="pegawai-info">
                        <h3>Siti Munawaroh, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai9.jpg') ?>" alt="Widi Saputra">
                    </div>
                    <div class="pegawai-info">
                        <h3>Widi Saputra, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai10.jpg') ?>" alt="Melisa Sulmi">
                    </div>
                    <div class="pegawai-info">
                        <h3>Melisa Sulmi, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai11.jpg') ?>" alt="Kartini">
                    </div>
                    <div class="pegawai-info">
                        <h3>Kartini, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai12.jpg') ?>" alt="Dewi Sartika">
                    </div>
                    <div class="pegawai-info">
                        <h3>Dewi Sartika, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai13.jpg') ?>" alt="Safitri">
                    </div>
                    <div class="pegawai-info">
                        <h3>Safitri, S.Kom</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai14.jpg') ?>" alt="Joni Haryono">
                    </div>
                    <div class="pegawai-info">
                        <h3>Joni Haryono, S.T</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai15.jpg') ?>" alt="Jamaludin">
                    </div>
                    <div class="pegawai-info">
                        <h3>Jamaludin, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai16.jpg') ?>" alt="Rofik Ridho Kurnia">
                    </div>
                    <div class="pegawai-info">
                        <h3>Rofik Ridho Kurnia, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai17.jpg') ?>" alt="Sudirman">
                    </div>
                    <div class="pegawai-info">
                        <h3>Sudirman, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai18.jpg') ?>" alt="Rizki Pungut Saputra">
                    </div>
                    <div class="pegawai-info">
                        <h3>Rizki Pungut Saputra, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai19.jpg') ?>" alt="Komarudin">
                    </div>
                    <div class="pegawai-info">
                        <h3>Komarudin, S.Pd</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
                <div class="pegawai-item">
                    <div class="pegawai-image">
                        <img src="<?= base_url('assets/images/pegawai/pegawai20.jpg') ?>" alt="Eko Alan Budi Kusuma">
                    </div>
                    <div class="pegawai-info">
                        <h3>Eko Alan Budi Kusuma, S.Kom</h3>
                        <p>Guru</p>
                        <div class="pegawai-contact">
                            <span><i class="fas fa-envelope"></i> email@example.com</span>
                            <span><i class="fas fa-phone"></i> 081234567890</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="show-more-container" style="text-align: center; margin-top: 30px;">
                <button id="showMoreBtn" class="show-more-btn">
                    <i class="fas fa-chevron-down"></i> Tampilkan Lainnya
                </button>
            </div>
        </div>
    </section>

    <!-- PPDB Section -->
    <section id="ppdb" class="ppdb">
        <div class="container">
            <div class="section-title">
                <h2>Pendaftaran Peserta Didik Baru</h2>
                <p>Tahun Ajaran 2024/2025</p>
            </div>
            <div class="ppdb-content">
                <div class="ppdb-info">
                    <h3>Persyaratan Pendaftaran</h3>
                    <ul>
                        <li>Lulusan SMP/MTs atau sederajat</li>
                        <li>Usia maksimal 21 tahun</li>
                        <li>Membawa fotokopi ijazah dan SKHUN</li>
                        <li>Membawa fotokopi KTP orang tua</li>
                        <li>Membawa pas foto 3x4 (3 lembar)</li>
                    </ul>
                    <div class="ppdb-contact">
                        <h4>Informasi Pendaftaran</h4>
                        <p><i class="fas fa-phone"></i> (0721) 123456</p>
                        <p><i class="fas fa-envelope"></i> ppdb@smkbmbns.sch.id</p>
                    </div>
                </div>
                <div class="ppdb-form">
                    <h3>Formulir Pendaftaran Online</h3>
                    <form action="<?= base_url('spmb/daftar') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <select id="agama" name="agama" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="asal_sekolah">Asal Sekolah</label>
                            <input type="text" id="asal_sekolah" name="asal_sekolah" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_ortu">Nama Orang Tua</label>
                            <input type="text" id="nama_ortu" name="nama_ortu" required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp_ortu">No. HP Orang Tua</label>
                            <input type="tel" id="no_hp_ortu" name="no_hp_ortu" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="tel" id="no_hp" name="no_hp" required>
                        </div>
                        <div class="form-group">
                            <label for="jurusan_pilihan">Pilihan Jurusan</label>
                            <select id="jurusan_pilihan" name="jurusan_pilihan" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="TKJ">Teknik Komputer dan Jaringan (TKJ)</option>
                                <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="MM">Multimedia (MM)</option>
                            </select>
                        </div>
                        <button type="submit" class="submit-btn">Daftar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section id="video-sekolah" class="video-sekolah">
        <div class="container">
            <div class="section-title">
                <h2>Video Sekolah</h2>
                <p>Kenali lebih dekat SMK Bhakti Mulya BNS Lampung melalui video</p>
            </div>
            <div class="video-grid">
                <div class="video-item">
                    <div class="video-container">
                        <iframe width="100%" height="315" 
                            src="https://www.youtube.com/embed/jvZ-r2R-des" 
                            title="Video Profil Sekolah" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    <h4>Video Profil Sekolah</h4>
                    <p>Kenali lebih dekat SMK Bhakti Mulya BNS Lampung</p>
                </div>
                <div class="video-item">
                    <div class="video-container">
                        <iframe width="100%" height="315" 
                            src="https://www.youtube.com/embed/yBtlX-ZAwqQ" 
                            title="Kegiatan Sekolah" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    <h4>Kegiatan Sekolah</h4>
                    <p>Dokumentasi kegiatan belajar mengajar dan ekstrakurikuler</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <div class="footer-logo">
                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo SMK Bhakti Mulya">
                        <div class="footer-logo-text">
                            <h3>SMK Bhakti Mulya</h3>
                            <p>BNS Lampung</p>
                        </div>
                    </div>
                    <div class="footer-contact">
                        <h4>Kontak Kami</h4>
                        <p><i class="fas fa-map-marker-alt"></i> Jl. Raya BNS No. 123, Lampung</p>
                        <p><i class="fas fa-phone"></i> (0721) 123456</p>
                        <p><i class="fas fa-envelope"></i> info@smkbmbns.sch.id</p>
                        <div class="social-media">
                            <a href="https://instagram.com/smkbmbns" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://facebook.com/smkbmbns" target="_blank"><i class="fab fa-facebook"></i></a>
                            <a href="https://youtube.com/smkbmbns" target="_blank"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-map">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.268734107045!2d104.27393818444637!3d-5.220413139046498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e479ffb0b36e33b%3A0x9786758675426f34!2sSMK%20Bhakti%20Mulya!5e0!3m2!1sid!2sid!4v1748973564262!5m2!1sid!2sid" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> SMK Bhakti Mulya BNS Lampung. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Loading Screen Script -->
    <script>
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loading-screen');
            
            // Tunggu 1.5 detik
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                loadingScreen.style.visibility = 'hidden';
                
                // Hapus loading screen dari DOM setelah fade out
                setTimeout(() => {
                    loadingScreen.remove();
                }, 300);
            }, 1500);
        });
    </script>
    
    <!-- Carousel Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi carousel
            var myCarousel = new bootstrap.Carousel(document.getElementById('heroCarousel'), {
                interval: 3000,
                wrap: true,
                keyboard: true,
                pause: 'hover',
                touch: true
            });

            myCarousel.cycle();

            // PPDB Popup Logic
            const popup = document.getElementById('ppdbPopup');
            const closeBtn = document.querySelector('.close-popup');
            const dontShowBtn = document.getElementById('dontShowAgain');

            // Check if popup should be shown
            if (!localStorage.getItem('ppdbPopupShown')) {
                popup.style.display = 'flex';
            }

            // Close popup
            closeBtn.addEventListener('click', () => {
                popup.style.display = 'none';
            });

            // Don't show again
            dontShowBtn.addEventListener('click', () => {
                localStorage.setItem('ppdbPopupShown', 'true');
                popup.style.display = 'none';
            });

            // Close popup when clicking outside
            popup.addEventListener('click', (e) => {
                if (e.target === popup) {
                    popup.style.display = 'none';
                }
            });
        });
    </script>

    <!-- Galeri Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-galeri');
            const hiddenItems = document.getElementById('hidden-galeri');
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = lightbox.querySelector('.lightbox-image');
            const lightboxTitle = lightbox.querySelector('.lightbox-caption h3');
            const lightboxDesc = lightbox.querySelector('.lightbox-caption p');
            const lightboxCounter = lightbox.querySelector('.lightbox-counter');
            const closeLightbox = lightbox.querySelector('.close-lightbox');
            const prevBtn = lightbox.querySelector('.lightbox-prev');
            const nextBtn = lightbox.querySelector('.lightbox-next');
            let isExpanded = false;
            let currentGallery = [];
            let currentIndex = 0;

            // Toggle gallery visibility with buffering
            toggleBtn.addEventListener('click', function() {
                // Disable button during buffering
                toggleBtn.disabled = true;
                toggleBtn.style.opacity = '0.7';
                
                // Add loading animation to icon
                const icon = toggleBtn.querySelector('i');
                icon.style.animation = 'spin 0.5s linear';
                
                setTimeout(() => {
                    isExpanded = !isExpanded;
                    hiddenItems.style.display = isExpanded ? 'grid' : 'none';
                    toggleBtn.innerHTML = isExpanded ? 
                        '<i class="fas fa-chevron-up"></i> Sembunyikan Galeri' : 
                        '<i class="fas fa-chevron-down"></i> Tampilkan Semua Galeri';
                    
                    // Re-enable button after buffering
                    toggleBtn.disabled = false;
                    toggleBtn.style.opacity = '1';
                    icon.style.animation = '';
                }, 500);
            });

            // Lightbox functionality
            document.querySelectorAll('.galeri-item').forEach(item => {
                item.addEventListener('click', function() {
                    const gallery = this.dataset.gallery;
                    const images = this.querySelectorAll('.galeri-images img');
                    
                    // Collect all images from the gallery
                    currentGallery = Array.from(images);
                    currentIndex = 0;
                    
                    updateLightbox();
                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            });

            function updateLightbox() {
                const currentImg = currentGallery[currentIndex];
                lightboxImg.src = currentImg.src;
                lightboxTitle.textContent = currentImg.dataset.title;
                lightboxDesc.textContent = currentImg.dataset.desc;
                lightboxCounter.textContent = `Foto ${currentIndex + 1} dari ${currentGallery.length}`;
                
                // Update navigation buttons
                prevBtn.style.display = currentIndex > 0 ? 'flex' : 'none';
                nextBtn.style.display = currentIndex < currentGallery.length - 1 ? 'flex' : 'none';
            }

            // Lightbox navigation
            prevBtn.addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateLightbox();
                }
            });

            nextBtn.addEventListener('click', function() {
                if (currentIndex < currentGallery.length - 1) {
                    currentIndex++;
                    updateLightbox();
                }
            });

            // Close lightbox
            closeLightbox.addEventListener('click', function() {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            });

            // Close lightbox when clicking outside
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    lightbox.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (!lightbox.classList.contains('active')) return;

                switch(e.key) {
                    case 'Escape':
                        lightbox.classList.remove('active');
                        document.body.style.overflow = '';
                        break;
                    case 'ArrowLeft':
                        if (currentIndex > 0) {
                            currentIndex--;
                            updateLightbox();
                        }
                        break;
                    case 'ArrowRight':
                        if (currentIndex < currentGallery.length - 1) {
                            currentIndex++;
                            updateLightbox();
                        }
                        break;
                }
            });
        });
    </script>

    <style>
    /* Remove profil section styles */
    .profil {
        display: none;
    }

    /* Gallery Grid Layout */
    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        padding: 20px 0;
    }

    /* Hidden Gallery Items Layout */
    .galeri-items-hidden {
        display: none;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 25px;
    }

    .galeri-items-hidden.active {
        display: grid;
    }

    /* Show More Container */
    .show-more-container {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    /* Show More Button Style */
    .show-more-btn {
        background: #1a237e;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(26, 35, 126, 0.2);
    }

    .show-more-btn:hover {
        background: #283593;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26, 35, 126, 0.3);
    }

    .show-more-btn i {
        transition: transform 0.3s ease;
    }

    .show-more-btn:hover i {
        transform: translateY(2px);
    }

    .show-more-btn.active i {
        transform: rotate(180deg);
    }

    /* Gallery Item Styles */
    .galeri-item {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .galeri-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Gallery Images Container */
    .galeri-images {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
        border-radius: 15px 15px 0 0;
    }

    .galeri-images::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .galeri-item:hover .galeri-images::after {
        opacity: 1;
    }

    .galeri-images img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .galeri-item:hover .galeri-images img {
        transform: scale(1.1);
    }

    /* Gallery Info */
    .galeri-info {
        padding: 12px;
        background: #fff;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .galeri-info h4 {
        margin: 0 0 8px 0;
        font-size: 16px;
        font-weight: 600;
        color: #1a237e;
        line-height: 1.3;
    }

    .galeri-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: #666;
        padding-top: 8px;
        border-top: 1px solid #eee;
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .galeri-grid,
        .galeri-items-hidden {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 992px) {
        .galeri-grid,
        .galeri-items-hidden {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .galeri-images {
            height: 220px;
        }
    }

    @media (max-width: 576px) {
        .galeri-grid,
        .galeri-items-hidden {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .galeri-images {
            height: 200px;
        }
    }

    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .lightbox.active {
        display: flex;
        opacity: 1;
    }

    .lightbox-content {
        position: relative;
        width: 90%;
        max-width: 1200px;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .lightbox-caption {
        color: white;
        text-align: center;
        padding: 20px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        margin-top: 20px;
        max-width: 800px;
    }

    .lightbox-caption h3 {
        margin: 0 0 10px 0;
        font-size: 24px;
        font-weight: 600;
    }

    .lightbox-caption p {
        margin: 0 0 10px 0;
        font-size: 16px;
        line-height: 1.5;
    }

    .lightbox-counter {
        font-size: 14px;
        color: #ccc;
        margin-top: 10px;
    }

    .close-lightbox {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        font-size: 30px;
        cursor: pointer;
        z-index: 1001;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        transition: background 0.3s ease;
    }

    .close-lightbox:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .lightbox-navigation {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        padding: 0 20px;
    }

    .lightbox-prev,
    .lightbox-next {
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        cursor: pointer;
        font-size: 20px;
        border-radius: 50%;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-prev:hover,
    .lightbox-next:hover {
        background: rgba(0, 0, 0, 0.8);
        transform: scale(1.1);
    }

    /* Loading Animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .show-more-btn:disabled {
        cursor: not-allowed;
    }

    /* Jurusan Section Styles */
    .jurusan {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .jurusan-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .jurusan-item {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .jurusan-item:hover {
        transform: translateY(-10px);
    }

    .jurusan-image {
        width: 100%;
        height: 250px;
        overflow: hidden;
    }

    .jurusan-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .jurusan-item:hover .jurusan-image img {
        transform: scale(1.1);
    }

    .jurusan-icon {
        width: 80px;
        height: 80px;
        background: #1a237e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -40px auto 20px;
        position: relative;
        z-index: 1;
        box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
    }

    .jurusan-icon i {
        font-size: 32px;
        color: white;
    }

    .jurusan-item h3 {
        text-align: center;
        color: #1a237e;
        margin: 0 0 15px;
        padding: 0 20px;
        font-size: 24px;
    }

    .jurusan-item p {
        text-align: center;
        color: #666;
        margin: 0 0 20px;
        padding: 0 20px;
        line-height: 1.6;
    }

    .jurusan-details {
        display: flex;
        justify-content: center;
        gap: 20px;
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #eee;
    }

    .jurusan-details span {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        font-size: 14px;
    }

    .jurusan-details i {
        color: #1a237e;
    }

    @media (max-width: 768px) {
        .jurusan-grid {
            grid-template-columns: 1fr;
        }

        .jurusan-image {
            height: 200px;
        }
    }

    /* Add styles for new profil tab */
    .profil-sekolah {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .profil-image {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        height: 400px;
    }

    .profil-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .profil-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 30px 20px;
    }

    .profil-stats {
        display: flex;
        justify-content: space-around;
        color: white;
    }

    .stat-item {
        text-align: center;
    }

    .stat-item i {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .stat-number {
        display: block;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 14px;
        opacity: 0.9;
    }

    .profil-description {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .profil-description p {
        color: var(--text-light);
        line-height: 1.8;
        margin-bottom: 30px;
    }

    .timeline {
        margin-top: 30px;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--primary-color);
    }

    .timeline-item {
        position: relative;
        padding-left: 30px;
        margin-bottom: 30px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: var(--primary-color);
    }

    .year {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 5px;
    }

    .event {
        color: var(--text-light);
    }

    @media (max-width: 768px) {
        .profil-stats {
            flex-direction: column;
            gap: 20px;
        }
        
        .profil-image {
            height: 300px;
        }
    }

    /* Tab button styles enhancement */
    .tab-btn {
        background: var(--white-color);
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        padding: 12px 25px;
        border-radius: 30px;
        transition: all 0.3s ease;
        margin: 0 5px;
        box-shadow: 0 2px 10px rgba(27, 42, 120, 0.1);
        font-weight: 500;
    }

    .tab-btn span {
        color: inherit;
        transition: color 0.3s ease;
    }

    .tab-btn:hover {
        background: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(27, 42, 120, 0.2);
    }

    .tab-btn:hover span {
        color: var(--white-color);
    }

    .tab-btn:hover i {
        color: #F7D117;
        transform: scale(1.1);
    }

    .tab-btn.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        box-shadow: 0 4px 15px rgba(27, 42, 120, 0.3);
    }

    .tab-btn.active span {
        color: var(--white-color);
    }

    .tab-btn.active i {
        color: #F7D117;
    }

    .tab-btn i {
        margin-right: 8px;
        transition: all 0.3s ease;
    }

    /* Features section enhancement */
    .features {
        background: var(--white-color);
        padding: 40px 0;
        position: relative;
        overflow: hidden;
    }

    .features::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('<?= base_url('assets/images/bg/pattern-light.png') ?>') center/cover;
        opacity: 0.05;
    }

    .features .section-title {
        position: relative;
        z-index: 1;
    }

    .features .section-title h2 {
        color: var(--primary-color);
    }

    .features .section-title p {
        color: var(--text-light);
    }

    .features-tabs {
        position: relative;
        z-index: 1;
        margin-top: 30px;
    }

    .tab-buttons {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .tab-buttons {
            flex-direction: column;
            align-items: center;
        }

        .tab-btn {
            width: 100%;
            max-width: 300px;
            margin: 5px 0;
        }

        .content-wrapper {
            padding: 20px;
        }
    }

    .social-media {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }

    .social-media a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-color);
        color: var(--white-color);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 18px;
        text-decoration: none;
    }

    .social-media a i {
        transition: all 0.3s ease;
    }

    .social-media a:hover {
        background: #FFFFFF;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(27, 42, 120, 0.3);
        border: 2px solid #1B2A78;
    }

    .social-media a:hover i {
        color: #1B2A78;
    }

    /* Pengumuman Section Styles */
    .pengumuman {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .pengumuman-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .pengumuman-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .pengumuman-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .pengumuman-image {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .pengumuman-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .pengumuman-card:hover .pengumuman-image img {
        transform: scale(1.1);
    }

    .pengumuman-badge {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-danger {
        background: #dc3545;
        color: white;
    }

    .badge-warning {
        background: #ffc107;
        color: #212529;
    }

    .badge-info {
        background: #17a2b8;
        color: white;
    }

    .pengumuman-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .pengumuman-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #666;
    }

    .pengumuman-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .pengumuman-meta i {
        color: var(--primary-color);
    }

    .pengumuman-content h3 {
        color: var(--primary-color);
        font-size: 20px;
        font-weight: 600;
        margin: 0 0 15px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pengumuman-content p {
        color: #666;
        line-height: 1.6;
        margin: 0 0 20px 0;
        flex-grow: 1;
    }

    .pengumuman-actions {
        display: flex;
        gap: 15px;
        margin-top: auto;
    }

    .btn-download, .btn-more {
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-download {
        background: var(--primary-color);
        color: white;
        border: 2px solid var(--primary-color);
    }

    .btn-download:hover {
        background: transparent;
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    .btn-more {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-more:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .pengumuman-more {
        text-align: center;
        margin-top: 40px;
    }

    .btn-view-all {
        background: var(--primary-color);
        color: white;
        padding: 15px 30px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 5px 15px rgba(27, 42, 120, 0.3);
    }

    .btn-view-all:hover {
        background: #283593;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(27, 42, 120, 0.4);
    }

    .pengumuman-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon i {
        font-size: 32px;
        color: #ccc;
    }

    .pengumuman-empty h3 {
        color: #666;
        margin: 0 0 10px 0;
        font-size: 24px;
    }

    .pengumuman-empty p {
        color: #999;
        margin: 0;
        font-size: 16px;
    }

    /* Responsive Design for Pengumuman */
    @media (max-width: 768px) {
        .pengumuman-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .pengumuman-card {
            margin: 0 10px;
        }

        .pengumuman-content {
            padding: 20px;
        }

        .pengumuman-content h3 {
            font-size: 18px;
        }

        .pengumuman-actions {
            flex-direction: column;
            gap: 10px;
        }

        .btn-download, .btn-more {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .pengumuman-meta {
            flex-direction: column;
            gap: 10px;
        }

        .pengumuman-image {
            height: 180px;
        }
    }
    </style>

    <script>
    // Scroll Animation
    document.addEventListener('DOMContentLoaded', function() {
        // Function to check if element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
                rect.bottom >= 0
            );
        }

        // Function to handle scroll animation
        function handleScrollAnimation() {
            const elements = document.querySelectorAll('.section-title, .profil-image, .profil-info, .jurusan-item, .galeri-item, .pegawai-item');
            
            elements.forEach(element => {
                if (isInViewport(element)) {
                    element.classList.add('visible');
                }
            });
        }

        // Initial check for elements in viewport
        handleScrollAnimation();

        // Add scroll event listener
        window.addEventListener('scroll', handleScrollAnimation);

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation classes to elements
        document.querySelectorAll('.section-title').forEach(el => el.classList.add('fade-in'));
        document.querySelectorAll('.profil-image').forEach(el => el.classList.add('slide-in-left'));
        document.querySelectorAll('.profil-info').forEach(el => el.classList.add('slide-in-right'));
        document.querySelectorAll('.jurusan-item').forEach(el => el.classList.add('scale-in'));
        document.querySelectorAll('.galeri-item').forEach(el => el.classList.add('fade-in'));
        document.querySelectorAll('.pegawai-item').forEach(el => el.classList.add('fade-in'));
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const tabButtons = document.querySelectorAll('.features-tabs .tab-btn');
        const tabPanes = document.querySelectorAll('.tab-contents .tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                
                // Remove active class from all buttons and panes
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding tab pane
                const tabId = this.getAttribute('data-tab');
                const targetPane = document.getElementById(tabId);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });

        // Smooth scroll for other navigation links
        document.querySelectorAll('a[href^="#"]:not(.tab-btn)').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
    </script>

    <!-- Pengumuman Popup -->
    <div id="pengumumanPopup" class="popup-overlay">
        <div class="popup-content pengumuman-popup">
            <div class="popup-body">
                <button class="close-popup">&times;</button>
                <div class="pengumuman-detail">
                    <div class="pengumuman-header">
                        <div class="pengumuman-image">
                            <img src="" alt="Pengumuman" id="popupImage">
                        </div>
                        <div class="pengumuman-info">
                            <div class="date" id="popupDate"></div>
                            <h3 id="popupTitle"></h3>
                        </div>
                    </div>
                    <div class="pengumuman-body">
                        <p id="popupContent"></p>
                        <div class="pengumuman-gallery" id="popupGallery">
                            <!-- Gallery images will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pengumuman Popup Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const pengumumanPopup = document.getElementById('pengumumanPopup');
            const closePopup = pengumumanPopup.querySelector('.close-popup');
            const readMoreButtons = document.querySelectorAll('.pengumuman-item .read-more');

            // Sample pengumuman data (in real application, this would come from a database)
            const pengumumanData = {
                'uts': {
                    title: 'Jadwal Ujian Tengah Semester',
                    date: '15 Mar 2024',
                    image: '<?= base_url('assets/images/pengumuman/uts.jpg') ?>',
                    content: `SMK Bhakti Mulya BNS Lampung mengumumkan jadwal Ujian Tengah Semester (UTS) untuk semester genap tahun ajaran 2023/2024.

                    Jadwal UTS akan dilaksanakan pada tanggal 18-25 Maret 2024. Berikut adalah jadwal lengkapnya:

                    Senin, 18 Maret 2024:
                    - 07.30-09.30: Matematika
                    - 10.00-12.00: Bahasa Indonesia

                    Selasa, 19 Maret 2024:
                    - 07.30-09.30: Bahasa Inggris
                    - 10.00-12.00: Fisika

                    Rabu, 20 Maret 2024:
                    - 07.30-09.30: Kimia
                    - 10.00-12.00: Biologi

                    Kamis, 21 Maret 2024:
                    - 07.30-09.30: Sejarah
                    - 10.00-12.00: Ekonomi

                    Jumat, 22 Maret 2024:
                    - 07.30-09.30: Geografi
                    - 10.00-12.00: Sosiologi

                    Catatan Penting:
                    1. Siswa diharapkan hadir 30 menit sebelum ujian dimulai
                    2. Membawa kartu ujian dan alat tulis
                    3. Mengenakan seragam lengkap
                    4. Tidak diperkenankan membawa HP ke dalam ruang ujian

                    Untuk informasi lebih lanjut, silakan hubungi wali kelas masing-masing.`,
                    gallery: [
                        '<?= base_url('assets/images/pengumuman/uts1.jpg') ?>',
                        '<?= base_url('assets/images/pengumuman/uts2.jpg') ?>',
                        '<?= base_url('assets/images/pengumuman/uts3.jpg') ?>'
                    ]
                },
                'ppdb': {
                    title: 'Pendaftaran PPDB 2024/2025',
                    date: '10 Mar 2024',
                    image: '<?= base_url('assets/images/pengumuman/ppdb.jpg') ?>',
                    content: `SMK Bhakti Mulya BNS Lampung membuka pendaftaran Peserta Didik Baru (PPDB) untuk tahun ajaran 2024/2025.

                    Informasi Pendaftaran:
                    Periode: 1 Januari - 30 Juni 2024
                    Kuota: 180 siswa (60 siswa per jurusan)

                    Persyaratan Pendaftaran:
                    1. Lulusan SMP/MTs atau sederajat
                    2. Usia maksimal 21 tahun
                    3. Membawa fotokopi ijazah dan SKHUN
                    4. Membawa fotokopi KTP orang tua
                    5. Membawa pas foto 3x4 (3 lembar)

                    Program Keahlian yang Dibuka:
                    1. Teknik Komputer dan Jaringan (TKJ)
                    2. Teknik Bisnis Sepeda Motor (TBSM)
                    3. Teknik Kendaraan Ringan (TKR)

                    Biaya Pendaftaran:
                    - Biaya pendaftaran: Rp 200.000
                    - Biaya seragam: Rp 500.000
                    - Biaya kegiatan: Rp 300.000

                    Cara Pendaftaran:
                    1. Mengisi formulir pendaftaran online di website sekolah
                    2. Melakukan pembayaran biaya pendaftaran
                    3. Mengumpulkan berkas persyaratan
                    4. Mengikuti tes seleksi (jika diperlukan)

                    Untuk informasi lebih lanjut, silakan hubungi:
                    - Telepon: (0721) 123456
                    - Email: ppdb@smkbmbns.sch.id
                    - Instagram: @smkbmbns`,
                    gallery: [
                        '<?= base_url('assets/images/pengumuman/ppdb1.jpg') ?>',
                        '<?= base_url('assets/images/pengumuman/ppdb2.jpg') ?>',
                        '<?= base_url('assets/images/pengumuman/ppdb3.jpg') ?>'
                    ]
                }
            };

            // Add click event to read more buttons
            readMoreButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pengumumanId = this.closest('.pengumuman-item').querySelector('.pengumuman-image img').alt.toLowerCase();
                    const data = pengumumanData[pengumumanId];

                    if (data) {
                        document.getElementById('popupImage').src = data.image;
                        document.getElementById('popupDate').textContent = data.date;
                        document.getElementById('popupTitle').textContent = data.title;
                        document.getElementById('popupContent').innerHTML = data.content.replace(/\n/g, '<br>');
                        
                        // Update gallery
                        const galleryContainer = document.getElementById('popupGallery');
                        galleryContainer.innerHTML = '';
                        
                        if (data.gallery && data.gallery.length > 0) {
                            data.gallery.forEach(imageUrl => {
                                const galleryItem = document.createElement('div');
                                galleryItem.className = 'gallery-item';
                                galleryItem.innerHTML = `<img src="${imageUrl}" alt="Gallery Image">`;
                                galleryContainer.appendChild(galleryItem);
                            });
                        }
                        
                        pengumumanPopup.style.display = 'flex';
                    }
                });
            });

            // Close popup
            closePopup.addEventListener('click', () => {
                pengumumanPopup.style.display = 'none';
            });

            // Close popup when clicking outside
            pengumumanPopup.addEventListener('click', (e) => {
                if (e.target === pengumumanPopup) {
                    pengumumanPopup.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> 