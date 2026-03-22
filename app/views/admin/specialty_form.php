<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0"><?= e($title) ?></h5></div><div class="card-body"><form method="POST"><?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Tên chuyên khoa *</label><input type="text" name="name" class="form-control" value="<?= e($specialty['name'] ?? '') ?>" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Icon (Font Awesome)</label><input type="text" name="icon" class="form-control" value="<?= e($specialty['icon'] ?? 'fas fa-stethoscope') ?>" placeholder="fas fa-heart"></div>
        <div class="col-md-6 mb-3"><label class="form-label">Trạng thái</label><select name="status" class="form-select"><option value="active" <?= ($specialty['status'] ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option><option value="inactive" <?= ($specialty['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Ngừng</option></select></div>
        <div class="col-12 mb-3"><label class="form-label">Mô tả</label><textarea name="description" class="form-control" rows="3"><?= e($specialty['description'] ?? '') ?></textarea></div>
    </div>
    <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Lưu</button> <a href="<?= url('/admin/specialties') ?>" class="btn btn-outline-secondary">Hủy</a>
</form></div></div>
