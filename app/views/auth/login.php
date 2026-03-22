<div class="auth-wrapper">
    <div class="auth-card fade-in">
        <div class="text-center mb-4">
            <img src="<?= asset('images/logo1.png') ?>" alt="Logo" height="64" class="mb-2">
            <h2 class="text-gradient"><?= APP_NAME ?></h2>
            <p class="subtitle"><?= APP_DESCRIPTION ?> — Đăng nhập</p>
        </div>
        <form method="POST" action="<?= url('/dang-nhap') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com" value="<?= old('email') ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>
            </div>
            <button type="submit" class="btn btn-gradient w-100 btn-lg mb-3">
                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
            </button>
        </form>
        <p class="text-center text-muted">Chưa có tài khoản? <a href="<?= url('/dang-ky') ?>">Đăng ký ngay</a></p>
        <hr>
        <div class="text-center small text-muted">
            <p class="mb-1"><strong>Tài khoản demo:</strong></p>
            <p class="mb-0">Admin: admin@hospital.com</p>
            <p class="mb-0">Bác sĩ: bsi.nguyen@hospital.com</p>
            <p class="mb-0">Bệnh nhân: bn.tran@gmail.com</p>
            <p class="mb-0">Mật khẩu chung: <code>password</code></p>
        </div>
    </div>
</div>
