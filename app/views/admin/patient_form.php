<div class="card card-custom">
    <div class="card-header bg-white">
        <h5 class="mb-0"><?= e($title) ?></h5>
    </div>
    <div class="card-body">
        <?php if (get_flash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= e(get_flash('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <?= csrf_field() ?>

            <div class="row">
                <!-- Thông tin tài khoản -->
                <div class="col-12">
                    <h6 class="text-muted mb-3"><i class="fas fa-user-circle me-2"></i>Thông tin tài khoản</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Họ và tên *</label>
                    <input type="text" name="full_name" class="form-control" 
                        value="<?= e($patient['full_name'] ?? old('full_name')) ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" 
                        value="<?= e($patient['email'] ?? old('email')) ?>" 
                        <?= $patient ? 'readonly' : 'required' ?>>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" 
                        value="<?= e($patient['phone'] ?? old('phone')) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><?= $patient ? 'Đổi mật khẩu' : 'Mật khẩu *' ?></label>
                    <input type="password" name="password" class="form-control" 
                        <?= $patient ? '' : 'required' ?> 
                        placeholder="<?= $patient ? 'Để trống nếu không đổi' : '' ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= ($patient['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="inactive" <?= ($patient['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Ngừng hoạt động</option>
                        <option value="banned" <?= ($patient['status'] ?? '') == 'banned' ? 'selected' : '' ?>>Bị khóa</option>
                    </select>
                </div>

                <!-- Thông tin cá nhân -->
                <div class="col-12 mt-4">
                    <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i>Thông tin cá nhân</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="date_of_birth" class="form-control" 
                        value="<?= e($patient['date_of_birth'] ?? old('date_of_birth')) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="">Chọn giới tính</option>
                        <option value="male" <?= ($patient['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Nam</option>
                        <option value="female" <?= ($patient['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Nữ</option>
                        <option value="other" <?= ($patient['gender'] ?? '') == 'other' ? 'selected' : '' ?>>Khác</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control" rows="2"><?= e($patient['address'] ?? old('address')) ?></textarea>
                </div>

                <!-- Thông tin y tế -->
                <div class="col-12 mt-4">
                    <h6 class="text-muted mb-3"><i class="fas fa-heartbeat me-2"></i>Thông tin y tế</h6>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nhóm máu</label>
                    <select name="blood_type" class="form-select">
                        <option value="">Chọn nhóm máu</option>
                        <option value="O+" <?= ($patient['blood_type'] ?? '') == 'O+' ? 'selected' : '' ?>>O+</option>
                        <option value="O-" <?= ($patient['blood_type'] ?? '') == 'O-' ? 'selected' : '' ?>>O-</option>
                        <option value="A+" <?= ($patient['blood_type'] ?? '') == 'A+' ? 'selected' : '' ?>>A+</option>
                        <option value="A-" <?= ($patient['blood_type'] ?? '') == 'A-' ? 'selected' : '' ?>>A-</option>
                        <option value="B+" <?= ($patient['blood_type'] ?? '') == 'B+' ? 'selected' : '' ?>>B+</option>
                        <option value="B-" <?= ($patient['blood_type'] ?? '') == 'B-' ? 'selected' : '' ?>>B-</option>
                        <option value="AB+" <?= ($patient['blood_type'] ?? '') == 'AB+' ? 'selected' : '' ?>>AB+</option>
                        <option value="AB-" <?= ($patient['blood_type'] ?? '') == 'AB-' ? 'selected' : '' ?>>AB-</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Dị ứng</label>
                    <input type="text" name="allergies" class="form-control" 
                        value="<?= e($patient['allergies'] ?? old('allergies')) ?>" 
                        placeholder="VD: Penicillin, Ngô...">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Số bảo hiểm y tế</label>
                    <input type="text" name="insurance_number" class="form-control" 
                        value="<?= e($patient['insurance_number'] ?? old('insurance_number')) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Liên hệ khẩn cấp</label>
                    <input type="text" name="emergency_contact" class="form-control" 
                        value="<?= e($patient['emergency_contact'] ?? old('emergency_contact')) ?>" 
                        placeholder="VD: Mẹ - 0123456789">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-gradient">
                    <i class="fas fa-save me-2"></i><?= $patient ? 'Cập nhật' : 'Thêm mới' ?>
                </button>
                <a href="<?= url('/admin/patients') ?>" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<?php clear_old_input(); ?>
