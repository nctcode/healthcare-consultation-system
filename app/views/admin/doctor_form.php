<div class="card card-custom">
    <div class="card-header bg-white"><h5 class="mb-0"><?= e($title) ?></h5></div>
    <div class="card-body">
        <form method="POST" action="">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Họ và tên *</label>
                    <input type="text" name="full_name" class="form-control" value="<?= e($doctor['full_name'] ?? old('full_name')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="<?= e($doctor['email'] ?? old('email')) ?>" <?= $doctor ? 'readonly' : 'required' ?>>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?= e($doctor['phone'] ?? old('phone')) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><?= $doctor ? 'Đổi mật khẩu' : 'Mật khẩu *' ?></label>
                    <input type="password" name="password" class="form-control" <?= $doctor ? '' : 'required' ?> placeholder="<?= $doctor ? 'Để trống nếu không đổi' : '' ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Chuyên khoa *</label>
                    <select name="specialty_id" class="form-select" required>
                        <option value="">Chọn chuyên khoa</option>
                        <?php foreach ($specialties as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= ($doctor['specialty_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bằng cấp</label>
                    <input type="text" name="qualification" class="form-control" value="<?= e($doctor['qualification'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Số năm kinh nghiệm</label>
                    <input type="number" name="experience_years" class="form-control" value="<?= $doctor['experience_years'] ?? 0 ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Phí khám (VNĐ)</label>
                    <input type="number" name="consultation_fee" class="form-control" value="<?= $doctor['consultation_fee'] ?? 0 ?>">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Giới thiệu</label>
                    <textarea name="bio" class="form-control" rows="3"><?= e($doctor['bio'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Lưu</button>
                <a href="<?= url('/admin/doctors') ?>" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
