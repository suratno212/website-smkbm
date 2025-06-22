<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' | ' : '' ?>SMK Bhakti Mulya BNS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f8fb; }
        .navbar { background: #0a2342; }
        .navbar-brand, .nav-link, .footer { color: #fff !important; }
        .footer { background: #0a2342; padding: 20px 0; text-align: center; margin-top: 40px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" height="40" class="me-2">
                SMK Bhakti Mulya BNS
            </a>
        </div>
    </nav>
    <main class="container my-4">
        <?= $this->renderSection('content') ?>
    </main>
    <footer class="footer">
        &copy; <?= date('Y') ?> SMK Bhakti Mulya BNS Lampung. All rights reserved.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 