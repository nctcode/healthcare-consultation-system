<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e(APP_DESCRIPTION) ?> - Đặt lịch khám trực tiếp, online, tại nhà">
    <title><?= e($title ?? APP_NAME) ?></title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="<?= url('/') ?>">
                <img src="<?= asset('images/logo1.png') ?>" alt="Logo" height="36" class="me-2" style="vertical-align:middle">
                <span><?= APP_NAME ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item"><a class="nav-link" href="<?= url('/public') ?>">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/bac-si') ?>">Bác sĩ</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('/chuyen-khoa') ?>">Chuyên khoa</a></li>
                </ul>
                <?php if (Auth::check()): ?>
                    <a href="<?= url(Auth::dashboardUrl()) ?>" class="btn btn-login">
                        <i class="fas fa-user me-1"></i><?= e(Auth::user()['name']) ?>
                    </a>
                <?php else: ?>
                    <a href="<?= url('/dang-nhap') ?>" class="btn btn-outline-primary me-2">Đăng nhập</a>
                    <a href="<?= url('/dang-ky') ?>" class="btn btn-login">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if ($msg = get_flash('success')): ?>
        <div class="toast-container"><div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= e($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div></div>
    <?php endif; ?>
    <?php if ($msg = get_flash('error')): ?>
        <div class="toast-container"><div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= e($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div></div>
    <?php endif; ?>

    <!-- Content -->
    <?= $content ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><img src="<?= asset('images/logo1.png') ?>" alt="Logo" height="50" class="me-2"><?= APP_NAME ?></h5>
                    <p>Hệ thống tư vấn và khám bệnh trực tuyến hàng đầu. Kết nối bệnh nhân với bác sĩ chuyên khoa mọi lúc, mọi nơi.</p>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= url('/') ?>">Trang chủ</a></li>
                        <li><a href="<?= url('/bac-si') ?>">Bác sĩ</a></li>
                        <li><a href="<?= url('/chuyen-khoa') ?>">Chuyên khoa</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Dịch vụ</h5>
                    <ul class="list-unstyled">
                        <li>Khám trực tiếp</li>
                        <li>Khám online</li>
                        <li>Khám tại nhà</li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Liên hệ</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Nguyễn Văn Cừ, Q.5, TP.HCM</p>
                    <p><i class="fas fa-phone me-2"></i>1900 xxxx</p>
                    <p><i class="fas fa-envelope me-2"></i>info@medicare.vn</p>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts
        setTimeout(() => document.querySelectorAll('.toast-container .alert').forEach(a => a.remove()), 5000);
    </script>
</body>
</html>
