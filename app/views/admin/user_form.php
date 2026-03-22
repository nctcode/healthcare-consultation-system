<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0"><?= e($title) ?></h5></div><div class="card-body"><form method="POST"><?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Họ và tên *</label><input type="text" name="full_name" class="form-control" value="<?= e($user['full_name'] ?? old('full_name')) ?>" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="<?= e($user['email'] ?? old('email')) ?>" <?= $user ? 'readonly' : 'required' ?>></div>
        <div class="col-md-4 mb-3"><label class="form-label">SĐT</label><input type="text" name="phone" class="form-control" value="<?= e($user['phone'] ?? '') ?>"></div>
        <div class="col-md-4 mb-3"><label class="form-label">Vai trò</label><select name="role_id" class="form-select" required><?php foreach ($roles as $r): ?><option value="<?= $r['id'] ?>" <?= ($user['role_id'] ?? '') == $r['id'] ? 'selected' : '' ?>><?= e($r['display_name']) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-4 mb-3"><label class="form-label">Trạng thái</label><select name="status" class="form-select"><option value="active" <?= ($user['status'] ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option><option value="inactive" <?= ($user['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Ngừng</option><option value="banned" <?= ($user['status'] ?? '') === 'banned' ? 'selected' : '' ?>>Khóa</option></select></div>
        <div class="col-md-6 mb-3"><label class="form-label"><?= $user ? 'Đổi mật khẩu' : 'Mật khẩu' ?></label><input type="password" name="password" class="form-control" <?= $user ? '' : 'required' ?> placeholder="<?= $user ? 'Để trống nếu không đổi' : '' ?>"></div>
    </div>
    <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Lưu</button> <a href="<?= url('/admin/users') ?>" class="btn btn-outline-secondary">Hủy</a>
</form></div></div>
