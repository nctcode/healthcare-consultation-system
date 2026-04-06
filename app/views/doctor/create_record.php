<?php if (!$record): ?><div class="alert alert-warning">Không tìm thấy bệnh án.</div><?php return; endif; ?>
<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Tạo bệnh án</h5></div><div class="card-body">
    <form method="POST"><?= csrf_field() ?>
        <div class="mb-3"><label class="form-label">Triệu chứng</label><textarea name="symptoms" class="form-control" rows="2"><?= e($appointment['symptoms'] ?? '') ?></textarea></div>
        <div class="mb-3"><label class="form-label">Chẩn đoán *</label><textarea name="diagnosis" class="form-control" rows="3" required></textarea></div>
        <div class="mb-3"><label class="form-label">Phương pháp điều trị *</label><textarea name="treatment" class="form-control" rows="3" required></textarea></div>
        <div class="mb-3"><label class="form-label">Ghi chú</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
        <div class="mb-3"><label class="form-label">Ngày tái khám</label><input type="date" name="follow_up_date" class="form-control"></div>
        <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Lưu bệnh án</button>
    </form>
</div></div>
