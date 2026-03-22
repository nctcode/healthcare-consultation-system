<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Dashboard') ?> | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<?php
    $role = Auth::role();
    $currentUrl = $_GET['url'] ?? '';
    $user = Auth::user();
    $initials = mb_substr($user['name'] ?? 'U', 0, 1);
?>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="<?= asset('images/logo1.png') ?>" alt="Logo" height="30" class="me-2" style="vertical-align:middle">
            <span><?= APP_NAME ?></span>
        </div>
        <div class="sidebar-menu">
            <?php if ($role === 'admin'): ?>
                <div class="sidebar-label">Tổng quan</div>
                <a href="<?= url('/admin/dashboard') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/dashboard') ? 'active' : '' ?>"><i class="fas fa-chart-pie"></i> Dashboard</a>
                <div class="sidebar-label">Quản lý</div>
                <a href="<?= url('/admin/doctors') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/doctor') ? 'active' : '' ?>"><i class="fas fa-user-md"></i> Bác sĩ</a>
                <a href="<?= url('/admin/patients') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/patient') ? 'active' : '' ?>"><i class="fas fa-procedures"></i> Bệnh nhân</a>
                <a href="<?= url('/admin/nurses') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/nurse') ? 'active' : '' ?>"><i class="fas fa-user-nurse"></i> Điều dưỡng</a>
                <a href="<?= url('/admin/receptionists') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/reception') ? 'active' : '' ?>"><i class="fas fa-concierge-bell"></i> Lễ tân</a>
                <a href="<?= url('/admin/specialties') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/special') ? 'active' : '' ?>"><i class="fas fa-stethoscope"></i> Chuyên khoa</a>
                <a href="<?= url('/admin/medicines') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/medicine') ? 'active' : '' ?>"><i class="fas fa-pills"></i> Thuốc</a>
                <a href="<?= url('/admin/services') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/service') ? 'active' : '' ?>"><i class="fas fa-hand-holding-medical"></i> Dịch vụ</a>
                <a href="<?= url('/admin/schedules') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/schedule') ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Lịch làm việc</a>
                <a href="<?= url('/admin/users') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/user') ? 'active' : '' ?>"><i class="fas fa-users-cog"></i> Người dùng</a>
                <div class="sidebar-label">Báo cáo</div>
                <a href="<?= url('/admin/reports') ?>" class="sidebar-link <?= str_contains($currentUrl, 'admin/report') ? 'active' : '' ?>"><i class="fas fa-chart-bar"></i> Thống kê</a>

            <?php elseif ($role === 'director'): ?>
                <div class="sidebar-label">Ban Giám đốc</div>
                <a href="<?= url('/director/dashboard') ?>" class="sidebar-link <?= str_contains($currentUrl, 'director/dashboard') ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Bảng điều khiển</a>
                <a href="<?= url('/director/reports') ?>" class="sidebar-link <?= str_contains($currentUrl, 'director/report') ? 'active' : '' ?>"><i class="fas fa-chart-bar"></i> Báo cáo doanh thu</a>
                <div class="sidebar-label">Xem dữ liệu</div>
                <a href="<?= url('/director/doctors') ?>" class="sidebar-link <?= str_contains($currentUrl, 'director/doctor') ? 'active' : '' ?>"><i class="fas fa-user-md"></i> Danh sách bác sĩ</a>
                <a href="<?= url('/director/patients') ?>" class="sidebar-link <?= str_contains($currentUrl, 'director/patient') ? 'active' : '' ?>"><i class="fas fa-procedures"></i> Bệnh nhân</a>
                <a href="<?= url('/director/nurses') ?>" class="sidebar-link <?= str_contains($currentUrl, 'director/nurse') ? 'active' : '' ?>"><i class="fas fa-user-nurse"></i> Điều dưỡng</a>
                <a href="<?= url('/director/receptionists') ?>" class="sidebar-link <?= str_contains($currentUrl, 'director/reception') ? 'active' : '' ?>"><i class="fas fa-concierge-bell"></i> Lễ tân</a>

            <?php elseif ($role === 'patient'): ?>
                <div class="sidebar-label">Menu</div>
                <a href="<?= url('/patient/dashboard') ?>" class="sidebar-link <?= str_contains($currentUrl, 'patient/dashboard') ? 'active' : '' ?>"><i class="fas fa-home"></i> Dashboard</a>
                <a href="<?= url('/patient/profile') ?>" class="sidebar-link <?= str_contains($currentUrl, 'patient/profile') ? 'active' : '' ?>"><i class="fas fa-user"></i> Hồ sơ cá nhân</a>
                <a href="<?= url('/patient/appointments/book') ?>" class="sidebar-link <?= str_contains($currentUrl, 'appointments/book') ? 'active' : '' ?>"><i class="fas fa-calendar-plus"></i> Đặt lịch khám</a>
                <a href="<?= url('/patient/appointments') ?>" class="sidebar-link <?= $currentUrl === 'patient/appointments' ? 'active' : '' ?>"><i class="fas fa-calendar-check"></i> Lịch khám</a>
                <a href="<?= url('/patient/medical-records') ?>" class="sidebar-link <?= str_contains($currentUrl, 'medical-record') ? 'active' : '' ?>"><i class="fas fa-file-medical"></i> Hồ sơ bệnh án</a>
                <a href="<?= url('/patient/prescriptions') ?>" class="sidebar-link <?= str_contains($currentUrl, 'prescription') ? 'active' : '' ?>"><i class="fas fa-prescription"></i> Đơn thuốc</a>
                <a href="<?= url('/patient/payments') ?>" class="sidebar-link <?= str_contains($currentUrl, 'payment') ? 'active' : '' ?>"><i class="fas fa-credit-card"></i> Thanh toán</a>
                <a href="<?= url('/patient/notifications') ?>" class="sidebar-link <?= str_contains($currentUrl, 'notification') ? 'active' : '' ?>"><i class="fas fa-bell"></i> Thông báo</a>

            <?php elseif ($role === 'doctor'): ?>
                <div class="sidebar-label">Menu</div>
                <a href="<?= url('/doctor/dashboard') ?>" class="sidebar-link <?= str_contains($currentUrl, 'doctor/dashboard') ? 'active' : '' ?>"><i class="fas fa-home"></i> Dashboard</a>
                <a href="<?= url('/doctor/appointments') ?>" class="sidebar-link <?= str_contains($currentUrl, 'doctor/appointment') ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Lịch khám</a>
                <a href="<?= url('/doctor/medical-records') ?>" class="sidebar-link <?= str_contains($currentUrl, 'medical-record') ? 'active' : '' ?>"><i class="fas fa-file-medical"></i> Bệnh án</a>
                <a href="<?= url('/doctor/patients') ?>" class="sidebar-link <?= str_contains($currentUrl, 'doctor/patient') ? 'active' : '' ?>"><i class="fas fa-users"></i> Bệnh nhân</a>

            <?php elseif ($role === 'nurse'): ?>
                <div class="sidebar-label">Menu</div>
                <a href="<?= url('/nurse/dashboard') ?>" class="sidebar-link <?= str_contains($currentUrl, 'nurse/dashboard') ? 'active' : '' ?>"><i class="fas fa-home"></i> Dashboard</a>
                <a href="<?= url('/nurse/patients') ?>" class="sidebar-link <?= str_contains($currentUrl, 'nurse/patient') ? 'active' : '' ?>"><i class="fas fa-procedures"></i> Bệnh nhân</a>

            <?php elseif ($role === 'receptionist'): ?>
                <div class="sidebar-label">Menu</div>
                <a href="<?= url('/receptionist/dashboard') ?>" class="sidebar-link <?= str_contains($currentUrl, 'receptionist/dashboard') ? 'active' : '' ?>"><i class="fas fa-home"></i> Dashboard</a>
                <a href="<?= url('/receptionist/appointments') ?>" class="sidebar-link <?= str_contains($currentUrl, 'receptionist/appointment') ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Lịch hẹn</a>
                <a href="<?= url('/receptionist/checkin') ?>" class="sidebar-link <?= str_contains($currentUrl, 'checkin') ? 'active' : '' ?>"><i class="fas fa-qrcode"></i> Check-in</a>
                <a href="<?= url('/receptionist/payments') ?>" class="sidebar-link <?= str_contains($currentUrl, 'receptionist/payment') ? 'active' : '' ?>"><i class="fas fa-cash-register"></i> Thanh toán</a>
                <a href="<?= url('/receptionist/queue') ?>" class="sidebar-link <?= str_contains($currentUrl, 'queue') ? 'active' : '' ?>"><i class="fas fa-list-ol"></i> Hàng chờ</a>
            <?php endif; ?>

            <div class="sidebar-label">Tài khoản</div>
            <a href="<?= url('/dang-xuat') ?>" class="sidebar-link"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center">
            <button class="btn btn-icon d-lg-none me-2" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="fas fa-bars"></i>
            </button>
            <span class="page-title"><?= e($title ?? 'Dashboard') ?></span>
        </div>
        <div class="topbar-right">
            <button class="btn btn-icon" onclick="toggleTheme()" title="Chuyển giao diện"><i class="fas fa-moon"></i></button>
            <div class="notif-badge">
                <a href="<?= url('/patient/notifications') ?>" class="btn btn-icon"><i class="fas fa-bell"></i></a>
                <span class="badge bg-danger notif-count" style="display:none"></span>
            </div>
            <div class="user-menu dropdown">
                <div data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar-sm"><?= e($initials) ?></div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text fw-bold"><?= e($user['name'] ?? '') ?></span></li>
                    <li><span class="dropdown-item-text text-muted small"><?= e($user['email'] ?? '') ?></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= url('/dang-xuat') ?>"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($msg = get_flash('success')): ?>
        <div class="toast-container"><div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i><?= e($msg) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    <?php endif; ?>
    <?php if ($msg = get_flash('error')): ?>
        <div class="toast-container"><div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i><?= e($msg) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    <?php endif; ?>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <?= $content ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const theme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }
        // Load saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) document.documentElement.setAttribute('data-theme', savedTheme);

        // Auto-dismiss alerts
        setTimeout(() => document.querySelectorAll('.toast-container .alert').forEach(a => a.remove()), 5000);

        // Notification polling
        function checkNotifs() {
            fetch('<?= url('/api/notifications') ?>')
                .then(r => r.json())
                .then(data => {
                    const badge = document.querySelector('.notif-count');
                    if (data.unread > 0) { badge.textContent = data.unread; badge.style.display = 'flex'; }
                    else { badge.style.display = 'none'; }
                }).catch(() => {});
        }
        setInterval(checkNotifs, 30000);
        checkNotifs();
    </script>
</body>
</html>
