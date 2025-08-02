<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - SIAKAD SMK Bhakti Mulya BNS</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#1a237e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SIAKAD SMK">
    <meta name="msapplication-TileColor" content="#1a237e">
    <meta name="msapplication-config" content="/browserconfig.xml">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/icons/icon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/icons/icon-16x16.png">
    <link rel="apple-touch-icon" href="/assets/images/icons/icon-192x192.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #F7D117;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            transition: all 0.3s ease;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-color);
            color: white;
            padding: 20px;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
            padding: 10px;
        }

        .sidebar-header {
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 10px 0;
        }

        .sidebar-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header img {
            width: 40px;
            height: 40px;
            margin-bottom: 5px;
        }

        .sidebar-header h3 {
            font-size: 18px;
            margin: 0;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header h3 {
            display: none;
        }

        .sidebar-menu {
            padding: 20px 0;
            transition: all 0.3s ease;
            overflow-y: auto;
            max-height: calc(100vh - 160px);
            scrollbar-width: thin;
            /* Firefox */
            scrollbar-color: #888 #222;
            /* Firefox */
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 8px;
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .sidebar-menu:hover::-webkit-scrollbar-thumb {
            opacity: 1;
        }

        .sidebar.collapsed .sidebar-menu {
            padding: 10px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            margin-bottom: 5px;
            border-radius: 8px;
        }

        .sidebar.collapsed .menu-item {
            padding: 15px 0;
            justify-content: center;
            text-align: center;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            transform: translateX(5px);
        }

        .sidebar.collapsed .menu-item:hover {
            transform: scale(1.1);
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #FFD700;
            border-left: 4px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .menu-item i {
            margin: 0;
            font-size: 1.2em;
        }

        .menu-item span {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .menu-item.active i {
            color: #FFD700;
        }

        .menu-item.active:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #FFD700;
        }

        .menu-item.active:hover i {
            color: #FFD700;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        .top-bar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Toggle Button */
        .sidebar-toggle {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-toggle:hover {
            background: #283593;
            transform: scale(1.1);
        }

        .sidebar-toggle i {
            transition: all 0.3s ease;
        }

        .sidebar.collapsed+.main-content .sidebar-toggle i {
            transform: rotate(180deg);
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 5px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .user-info h6 {
            color: var(--primary-color);
            font-weight: 600;
        }

        .user-info small {
            color: #666;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-color);
            margin-right: 10px;
        }

        /* Small Box Styles */
        .small-box {
            position: relative;
            display: block;
            margin-bottom: 20px;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            border-radius: 0.25rem;
        }

        .small-box>.inner {
            padding: 10px;
        }

        .small-box h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            white-space: nowrap;
            padding: 0;
            color: white;
        }

        .small-box p {
            color: white;
        }

        .small-box .icon {
            color: rgba(0, 0, 0, .15);
            z-index: 0;
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 70px;
        }

        .small-box>.small-box-footer {
            position: relative;
            text-align: center;
            padding: 3px 0;
            color: rgba(255, 255, 255, .8);
            display: block;
            z-index: 10;
            background: rgba(0, 0, 0, .1);
            text-decoration: none;
        }

        .small-box>.small-box-footer:hover {
            color: #fff;
            background: rgba(0, 0, 0, .15);
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                max-width: 100vw;
                min-width: 100vw;
                z-index: 1100;
                transform: translateX(-100%);
                padding: 20px;
                border-radius: 0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s cubic-bezier(.4, 2, .6, 1), width 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
            }

            .main-content,
            .main-content.expanded {
                margin-left: 0;
            }

            .sidebar-header h3,
            .menu-item span {
                display: block;
            }

            .menu-item {
                padding: 12px 20px;
                justify-content: flex-start;
                text-align: left;
            }

            .menu-item i {
                margin-right: 10px;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Sekolah">
            <h3>SIAKAD Admin</h3>
        </div>
        <div class="sidebar-menu">
            <a href="<?= base_url('admin/dashboard') ?>" class="menu-item <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="<?= base_url('admin/siswa') ?>" class="menu-item <?= strpos(uri_string(), 'admin/siswa') === 0 ? 'active' : '' ?>">
                <i class="fas fa-user-graduate"></i>
                <span>Data Siswa</span>
            </a>
            <a href="<?= base_url('admin/guru') ?>" class="menu-item <?= strpos(uri_string(), 'admin/guru') === 0 ? 'active' : '' ?>">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Data Guru</span>
            </a>
            <a href="<?= base_url('admin/jadwal') ?>" class="menu-item <?= strpos(uri_string(), 'admin/jadwal') === 0 ? 'active' : '' ?>">
                <i class="fas fa-calendar-alt"></i>
                <span>Jadwal Pelajaran</span>
            </a>
            <a href="<?= base_url('admin/pengumuman') ?>" class="menu-item <?= strpos(uri_string(), 'admin/pengumuman') === 0 ? 'active' : '' ?>">
                <i class="fas fa-bullhorn"></i>
                <span>Pengumuman</span>
            </a>
            <div class="menu-item sidebar-dropdown <?= (strpos(uri_string(), 'admin/master') === 0) ? 'active' : '' ?>" style="cursor:pointer;">
                <i class="fas fa-cogs"></i>
                <span>Data Master</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </div>
            <div class="sidebar-submenu" style="display: none; margin-left: 20px;">
                <a href="<?= base_url('admin/master/jurusan') ?>" class="menu-item<?= strpos(uri_string(), 'admin/master/jurusan') === 0 ? ' active' : '' ?>"><i class="fas fa-stream"></i> Jurusan</a>
                <a href="<?= base_url('admin/master/kelas') ?>" class="menu-item<?= strpos(uri_string(), 'admin/master/kelas') === 0 ? ' active' : '' ?>"><i class="fas fa-door-open"></i> Kelas</a>
                <a href="<?= base_url('admin/master/tahun_akademik') ?>" class="menu-item<?= strpos(uri_string(), 'admin/master/tahun_akademik') === 0 ? ' active' : '' ?>"><i class="fas fa-calendar-alt"></i> Tahun Akademik</a>
                <a href="<?= base_url('admin/master/mapel') ?>" class="menu-item<?= strpos(uri_string(), 'admin/master/mapel') === 0 ? ' active' : '' ?>"><i class="fas fa-book"></i> Mapel</a>
                <a href="<?= base_url('admin/master/agama') ?>" class="menu-item<?= strpos(uri_string(), 'admin/master/agama') === 0 ? ' active' : '' ?>"><i class="fas fa-praying-hands"></i> Agama</a>
                <a href="<?= base_url('admin/master/ekstrakurikuler') ?>" class="menu-item<?= strpos(uri_string(), 'admin/master/ekstrakurikuler') === 0 ? ' active' : '' ?>"><i class="fas fa-futbol"></i> Ekstrakurikuler</a>
            </div>
            <div class="menu-item sidebar-dropdown <?= (strpos(uri_string(), 'admin/spmb') === 0 || strpos(uri_string(), 'admin/spmbsoal') === 0 || strpos(uri_string(), 'admin/calon-siswa') === 0) ? 'active' : '' ?>" style="cursor:pointer;">
                <i class="fas fa-user-plus"></i>
                <span>SPMB</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </div>
            <div class="sidebar-submenu" style="display: none; margin-left: 20px;">
                <a href="<?= base_url('admin/spmb') ?>" class="menu-item<?= strpos(uri_string(), 'admin/spmb') === 0 ? ' active' : '' ?>"><i class="fas fa-list"></i> Data SPMB</a>
                <a href="<?= base_url('admin/spmbsoal') ?>" class="menu-item<?= strpos(uri_string(), 'admin/spmbsoal') === 0 ? ' active' : '' ?>"><i class="fas fa-question-circle"></i> Bank Soal SPMB</a>
                <a href="<?= base_url('admin/calon-siswa') ?>" class="menu-item<?= strpos(uri_string(), 'admin/calon-siswa') === 0 ? ' active' : '' ?>"><i class="fas fa-user-friends"></i> Calon Siswa</a>
            </div>
            <a href="<?= base_url('admin/users') ?>" class="menu-item <?= strpos(uri_string(), 'admin/users') === 0 ? 'active' : '' ?>">
                <i class="fas fa-user-cog"></i>
                <span>Manajemen User</span>
            </a>
            <a href="<?= base_url('admin/pengaturan') ?>" class="menu-item <?= strpos(uri_string(), 'admin/pengaturan') === 0 ? 'active' : '' ?>">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            <a href="<?= base_url('admin/export') ?>" class="menu-item <?= strpos(uri_string(), 'admin/export') === 0 ? 'active' : '' ?>">
                <i class="fas fa-file-export"></i>
                <span>Export Data</span>
            </a>
            <div class="menu-item sidebar-dropdown <?= (strpos(uri_string(), 'admin/absensi/rekap-siswa') === 0 || strpos(uri_string(), 'admin/absensi/rekap-guru') === 0) ? 'active' : '' ?>" style="cursor:pointer;">
                <i class="fas fa-clipboard-list"></i>
                <span>Rekap Absensi</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </div>
            <div class="sidebar-submenu" style="display: none; margin-left: 20px;">
                <a href="<?= base_url('admin/absensi/rekap-siswa') ?>" class="menu-item<?= strpos(uri_string(), 'admin/absensi/rekap-siswa') === 0 ? ' active' : '' ?>"><i class="fas fa-user-graduate"></i> Rekap Siswa</a>
                <a href="<?= base_url('admin/absensi/rekap-guru') ?>" class="menu-item<?= strpos(uri_string(), 'admin/absensi/rekap-guru') === 0 ? ' active' : '' ?>"><i class="fas fa-chalkboard-teacher"></i> Rekap Guru</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="top-bar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h4 class="mb-0"><?= $title ?></h4>
                    <small class="text-muted">SIAKAD SMK Bhakti Mulya BNS</small>
                </div>
            </div>
            <div class="user-info dropdown">
                <a href="#" class="d-flex align-items-center dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration:none; color:inherit;">
                    <?php if (isset($user['foto']) && $user['foto']) : ?>
                        <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" alt="User" class="profile-image">
                    <?php else : ?>
                        <img src="<?= base_url('assets/images/Logo.png') ?>" alt="User" class="profile-image">
                    <?php endif; ?>
                    <div>
                        <h6 class="mb-0"><?= $user['nama'] ?? $user['username'] ?? 'Admin' ?></h6>
                        <small class="text-muted"><?= ucfirst($user['role'] ?? 'admin') ?></small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>"><i class="fas fa-user-edit me-2"></i>Profil</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>

        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- PWA Script -->
    <script src="<?= base_url('assets/js/pwa.js') ?>"></script>

    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Check if sidebar state is saved in localStorage
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            if (sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }

            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    // Mobile: show fullscreen sidebar
                    if (sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    } else {
                        sidebar.classList.add('show');
                        sidebarOverlay.classList.add('show');
                    }
                } else {
                    // Desktop: collapse/expand
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    // Save state to localStorage
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                }
            });

            // Close sidebar when clicking overlay on mobile ONLY
            sidebarOverlay.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });

            // Handle window resize - but don't auto-close sidebar
            window.addEventListener('resize', function() {
                // Only handle mobile overlay, don't auto-close sidebar
                if (window.innerWidth > 768) {
                    sidebarOverlay.classList.remove('show');
                }
            });

            // Remove hover effect for collapsed sidebar - let user control manually
            // The sidebar will stay in the state the user chooses
        });

        // Sidebar Dropdown SPMB & Rekap Absensi
        $(document).ready(function() {
            $('.sidebar-dropdown').click(function() {
                $(this).toggleClass('active');
                $(this).next('.sidebar-submenu').slideToggle(200);
            });
            // Auto-open if on SPMB or Rekap Absensi page
            $('.sidebar-dropdown.active').each(function() {
                $(this).next('.sidebar-submenu').show();
            });
        });
    </script>
</body>

</html>