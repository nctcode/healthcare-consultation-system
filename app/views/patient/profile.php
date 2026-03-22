<div class="card card-custom">
    <div class="card-header bg-white"><h5 class="mb-0">Hồ sơ cá nhân</h5></div>
    <div class="card-body">
        <form method="POST"><?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Họ và tên</label><input type="text" name="full_name" class="form-control" value="<?= e($user['full_name'] ?? '') ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" class="form-control" value="<?= e($user['email'] ?? '') ?>" readonly></div>
                <div class="col-md-6 mb-3"><label class="form-label">SĐT</label><input type="text" name="phone" class="form-control" value="<?= e($user['phone'] ?? '') ?>"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Ngày sinh</label><input type="date" name="date_of_birth" class="form-control" value="<?= e($patient['date_of_birth'] ?? '') ?>"></div>
                <div class="col-md-4 mb-3"><label class="form-label">Giới tính</label><select name="gender" class="form-select"><option value="">Chọn</option><option value="male" <?= ($patient['gender']??'')=='male'?'selected':'' ?>>Nam</option><option value="female" <?= ($patient['gender']??'')=='female'?'selected':'' ?>>Nữ</option><option value="other" <?= ($patient['gender']??'')=='other'?'selected':'' ?>>Khác</option></select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Nhóm máu</label><select name="blood_type" class="form-select"><option value="">Chọn</option><?php foreach (['A','B','AB','O'] as $bt): ?><option value="<?= $bt ?>" <?= ($patient['blood_type']??'')==$bt?'selected':'' ?>><?= $bt ?></option><?php endforeach; ?></select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Số BHYT</label><input type="text" name="insurance_number" class="form-control" value="<?= e($patient['insurance_number'] ?? '') ?>"></div>
                <div class="col-12 mb-3"><label class="form-label">Địa chỉ</label><input type="text" name="address" class="form-control" value="<?= e($patient['address'] ?? '') ?>"></div>
                <div class="col-12 mb-3"><label class="form-label">Dị ứng</label><textarea name="allergies" class="form-control" rows="2"><?= e($patient['allergies'] ?? '') ?></textarea></div>
                <div class="col-12 mb-3"><label class="form-label">Liên hệ khẩn cấp</label><input type="text" name="emergency_contact" class="form-control" value="<?= e($patient['emergency_contact'] ?? '') ?>"></div>
            </div>
            <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Cập nhật</button>
        </form>
    </div>
</div>
