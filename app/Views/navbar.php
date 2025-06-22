<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-contact">
            <span><i class="fas fa-envelope"></i> info@smkbmbns.sch.id</span>
            <span><i class="fas fa-phone"></i> (0721) 123456</span>
        </div>
        <div class="top-bar-time">
            <span id="current-time"></span>
        </div>
    </div>
</div>

<!-- Header/Navbar -->
<header class="header">
    <div class="container">
        <nav class="navbar">
            <div class="logo">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo SMK">
                <div class="logo-text">
                    <h1>SMK BHAKTI MULYA</h1>
                    <p>BNS LAMPUNG</p>
                </div>
            </div>
            
            <ul class="nav-menu">
                <?php foreach ($menu as $item): ?>
                    <li><a href="<?= $item['url'] ?>"><?= $item['text'] ?></a></li>
                <?php endforeach; ?>
                <li><a href="<?= base_url('jadwal-ujian') ?>">Jadwal</a></li>
                <li><a href="#video-sekolah">Video</a></li>
            </ul>

            <div class="menu-toggle">
                <a href="<?= base_url('auth') ?>" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> LOGIN SIAKAD
                </a>
            </div>
        </nav>
    </div>
</header> 