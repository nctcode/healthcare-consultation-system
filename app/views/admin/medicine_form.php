<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0"><?= e($title) ?></h5></div><div class="card-body"><form method="POST"><?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Tên thuốc *</label><input type="text" name="name" class="form-control" value="<?= e($medicine['name'] ?? '') ?>" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Tên gốc</label><input type="text" name="generic_name" class="form-control" value="<?= e($medicine['generic_name'] ?? '') ?>"></div>
        <div class="col-md-3 mb-3"><label class="form-label">Đơn vị</label><input type="text" name="unit" class="form-control" value="<?= e($medicine['unit'] ?? 'Viên') ?>"></div>
        <div class="col-md-3 mb-3"><label class="form-label">Giá (VNĐ)</label><input type="number" name="price" class="form-control" value="<?= $medicine['price'] ?? 0 ?>"></div>
        <div class="col-md-3 mb-3"><label class="form-label">Tồn kho</label><input type="number" name="stock" class="form-control" value="<?= $medicine['stock'] ?? 0 ?>"></div>
        <div class="col-md-3 mb-3"><label class="form-label">Trạng thái</label><select name="status" class="form-select"><option value="active" <?= ($medicine['status'] ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option><option value="inactive" <?= ($medicine['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Ngừng</option></select></div>
        <div class="col-12 mb-3"><label class="form-label">Mô tả</label><textarea name="description" class="form-control" rows="2"><?= e($medicine['description'] ?? '') ?></textarea></div>
    </div>
    <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Lưu</button> <a href="<?= url('/admin/medicines') ?>" class="btn btn-outline-secondary">Hủy</a>
</form></div></div>
