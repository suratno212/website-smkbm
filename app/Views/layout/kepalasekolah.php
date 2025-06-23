<?php
if (!isset($user) || !is_array($user)) {
    $user = [
        'username' => session()->get('username'),
        'foto' => session()->get('foto'),
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - SIAKAD SMK Bhakti Mulya BNS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #F7D117;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; transition: all 0.3s ease; }
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width); background: var(--primary-color); color: white; padding: 20px; transition: all 0.3s ease; z-index: 1000; }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); padding: 10px; }
        .sidebar-header { padding: 20px 0; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); transition: all 0.3s ease; }
        .sidebar.collapsed .sidebar-header { padding: 10px 0; }
        .sidebar-header img { width: 80px; height: 80px; margin-bottom: 10px; transition: all 0.3s ease; }
        .sidebar.collapsed .sidebar-header img { width: 40px; height: 40px; margin-bottom: 5px; }
        .sidebar-header h3 { font-size: 18px; margin: 0; transition: all 0.3s ease; }
        .sidebar.collapsed .sidebar-header h3 { display: none; }
        .sidebar-menu { padding: 20px 0; transition: all 0.3s ease; overflow-y: auto; max-height: calc(100vh - 160px); scrollbar-width: thin; scrollbar-color: #888 #222; }
        .sidebar.collapsed .sidebar-menu { padding: 10px 0; }
        .sidebar-menu::-webkit-scrollbar { width: 8px; background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; opacity: 0; transition: opacity 0.2s; }
        .sidebar-menu:hover::-webkit-scrollbar-thumb { opacity: 1; }
        .menu-item { display: flex; align-items: center; padding: 12px 20px; color: rgba(255,255,255,0.8); text-decoration: none; transition: all 0.3s ease; border-left: 4px solid transparent; margin-bottom: 5px; border-radius: 8px; }
        .sidebar.collapsed .menu-item { padding: 15px 0; justify-content: center; text-align: center; }
        .menu-item:hover { background-color: rgba(255,255,255,0.1); color: white; text-decoration: none; transform: translateX(5px); }
        .sidebar.collapsed .menu-item:hover { transform: scale(1.1); }
        .menu-item.active { background-color: rgba(255,255,255,0.2); color: #FFD700; border-left: 4px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .menu-item i { margin-right: 10px; width: 20px; text-align: center; font-size: 1.1em; transition: all 0.3s ease; }
        .sidebar.collapsed .menu-item i { margin: 0; font-size: 1.2em; }
        .menu-item span { font-weight: 500; transition: all 0.3s ease; }
        .sidebar.collapsed .menu-item span { display: none; }
        .menu-item.active i { color: #FFD700; }
        .menu-item.active:hover { background-color: rgba(255,255,255,0.2); color: #FFD700; }
        .menu-item.active:hover i { color: #FFD700; }
        .main-content { margin-left: var(--sidebar-width); padding: 20px; transition: all 0.3s ease; }
        .main-content.expanded { margin-left: var(--sidebar-collapsed-width); }
        .top-bar { background: white; padding: 15px 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .sidebar-toggle { background: var(--primary-color); color: white; border: none; font-size: 1.2em; border-radius: 5px; padding: 8px 12px; margin-right: 10px; }
        .profile-image { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--secondary-color); margin-right: 10px; }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); width: var(--sidebar-width); padding: 20px; } .sidebar.show { transform: translateX(0); } .sidebar.collapsed { transform: translateX(-100%); } .main-content { margin-left: 0; } .main-content.expanded { margin-left: 0; } .sidebar-header h3, .menu-item span { display: block; } .menu-item { padding: 12px 20px; justify-content: flex-start; text-align: left; } .menu-item i { margin-right: 10px; } }
        .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; display: none; }
        .sidebar-overlay.show { display: block; }
    </style>
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Sekolah">
            <h3>SIAKAD Kepala Sekolah</h3>
        </div>
        <div class="sidebar-menu">
            <a href="<?= base_url('kepalasekolah/dashboard') ?>" class="menu-item <?= uri_string() == 'kepalasekolah/dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="<?= base_url('kepalasekolah/rekap-nilai') ?>" class="menu-item <?= strpos(uri_string(), 'kepalasekolah/rekap-nilai') === 0 ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i>
                <span>Rekap Nilai</span>
            </a>
            <a href="<?= base_url('kepalasekolah/rekap-absensi') ?>" class="menu-item <?= strpos(uri_string(), 'kepalasekolah/rekap-absensi') === 0 ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list"></i>
                <span>Rekap Absensi</span>
            </a>
            <a href="<?= base_url('kepalasekolah/raport') ?>" class="menu-item <?= strpos(uri_string(), 'kepalasekolah/raport') === 0 ? 'active' : '' ?>">
                <i class="fas fa-file-alt"></i>
                <span>Laporan e-Raport</span>
            </a>
            <a href="<?= base_url('kepalasekolah/statistik') ?>" class="menu-item <?= strpos(uri_string(), 'kepalasekolah/statistik') === 0 ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i>
                <span>Statistik</span>
            </a>
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
                    <?php if (!empty($user['foto'])) : ?>
                        <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" alt="User" class="profile-image">
                    <?php else : ?>
                        <img src="<?= base_url('assets/images/Logo.png') ?>" alt="User" class="profile-image">
                    <?php endif; ?>
                    <div>
                        <h6 class="mb-0"><?= $user['username'] ?? 'Kepala Sekolah' ?></h6>
                        <small class="text-muted">Kepala Sekolah</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= base_url('kepalasekolah/profile') ?>"><i class="fas fa-user-edit me-2"></i>Profil</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
        <?= $this->renderSection('content') ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                if (window.innerWidth <= 768) {
                    if (sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    } else {
                        sidebar.classList.add('show');
                        sidebarOverlay.classList.add('show');
                    }
                }
            });
            sidebarOverlay.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html> 