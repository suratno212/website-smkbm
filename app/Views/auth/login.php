<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIAKAD - SMK Bhakti Mulya BNS Lampung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #F7D117;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color), #283593);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            padding: 0;
        }

        .login-header {
            background: var(--primary-color);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .login-header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: 600;
        }

        .login-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.25);
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-login {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #283593;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-to-home a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-to-home a:hover {
            color: #283593;
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Sekolah">
            <h1>SIAKAD SMK Bhakti Mulya BNS</h1>
        </div>
        
        <div class="login-form">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </form>

            <div class="back-to-home">
                <a href="<?= base_url() ?>">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 