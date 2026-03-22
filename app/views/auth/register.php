<div class="auth-wrapper">
    <div class="auth-card fade-in">
        <div class="text-center mb-4">
            <img src="<?= asset('images/logo1.png') ?>" alt="Logo" height="64" class="mb-2">
            <h2 class="text-gradient"><?= APP_NAME ?></h2>
            <p class="subtitle"><?= APP_DESCRIPTION ?> — Đăng ký tài khoản</p>
        </div>
        <form method="POST" action="<?= url('/dang-ky') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Họ và tên *</label>
                <input type="text" name="full_name" class="form-control" value="<?= old('full_name') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại *</label>
                <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>" required>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="date_of_birth" class="form-control" value="<?= old('date_of_birth') ?>">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="">Chọn</option>
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                        <option value="other">Khác</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="<?= old('address') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu *</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu *</label>
                <input type="password" name="password_confirm" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-gradient w-100 btn-lg mb-3">
                <i class="fas fa-user-plus me-2"></i>Đăng ký
            </button>
        </form>
        <p class="text-center text-muted">Đã có tài khoản? <a href="<?= url('/dang-nhap') ?>">Đăng nhập</a></p>
    </div>
</div>
