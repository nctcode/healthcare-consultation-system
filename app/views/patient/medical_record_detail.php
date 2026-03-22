<?php if (!$record): ?><div class="alert alert-warning">Không tìm thấy bệnh án.</div><?php return; endif; ?>
<div class="card card-custom mb-4"><div class="card-header bg-white"><h5 class="mb-0">Bệnh án #<?= $record['id'] ?></h5></div><div class="card-body"><div class="row">
    <div class="col-md-6 mb-3"><strong>Ngày khám:</strong> <?= format_date($record['created_at']) ?></div>
    <div class="col-md-6 mb-3"><strong>Bác sĩ:</strong> <?= e($record['doctor_name'] ?? '') ?></div>
    <div class="col-12 mb-3"><strong>Triệu chứng:</strong><p><?= nl2br(e($record['symptoms'] ?? '')) ?></p></div>
    <div class="col-12 mb-3"><strong>Chẩn đoán:</strong><p class="text-danger fw-bold"><?= nl2br(e($record['diagnosis'] ?? '')) ?></p></div>
    <div class="col-12 mb-3"><strong>Phương pháp điều trị:</strong><p><?= nl2br(e($record['treatment'] ?? '')) ?></p></div>
    <?php if ($record['notes']): ?><div class="col-12 mb-3"><strong>Ghi chú:</strong><p><?= nl2br(e($record['notes'])) ?></p></div><?php endif; ?>
    <?php if ($record['follow_up_date']): ?><div class="col-12"><strong>Ngày tái khám:</strong> <span class="badge bg-warning"><?= format_date($record['follow_up_date']) ?></span></div><?php endif; ?>
</div></div></div>
<?php if (!empty($images)): ?>
<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Hình ảnh y khoa</h5></div><div class="card-body"><div class="row g-3">
    <?php foreach ($images as $img): ?><div class="col-md-4"><img src="<?= asset('uploads/' . $img['image_path']) ?>" class="img-fluid rounded" alt="<?= e($img['description'] ?? '') ?>"><p class="small text-muted mt-1"><?= e($img['image_type'] ?? '') ?> - <?= e($img['description'] ?? '') ?></p></div><?php endforeach; ?>
</div></div></div>
<?php endif; ?>
