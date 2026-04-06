<?php if (!$appointment): ?><div class="alert alert-warning">Không tìm thấy lịch khám.</div><?php return; endif; ?>
<div class="row">
    <div class="col-lg-4">
        <div class="card card-custom mb-4"><div class="card-header bg-white"><h5 class="mb-0">Thông tin bệnh nhân</h5></div><div class="card-body">
            <p><strong>Họ tên:</strong> <?= e($patient['full_name'] ?? $appointment['patient_name']) ?></p>
            <p><strong>Giới tính:</strong> <?= gender_label($patient['gender'] ?? '') ?></p>
            <p><strong>Ngày sinh:</strong> <?= format_date($patient['date_of_birth'] ?? '') ?></p>
            <p><strong>SĐT:</strong> <?= e($patient['phone'] ?? '') ?></p>
            <p><strong>Nhóm máu:</strong> <?= e($patient['blood_type'] ?? 'N/A') ?></p>
            <p><strong>Dị ứng:</strong> <?= e($patient['allergies'] ?? 'Không') ?></p>
        </div></div>
        <div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Lịch sử bệnh án</h5></div><div class="card-body">
            <?php foreach (array_slice($medicalRecords, 0, 5) as $r): ?>
            <div class="border-bottom pb-2 mb-2"><small class="text-muted"><?= format_date($r['created_at']) ?></small><p class="mb-0 small"><?= truncate($r['diagnosis'] ?? '', 80) ?></p></div>
            <?php endforeach; ?>
            <?php if (empty($medicalRecords)): ?><p class="text-muted small">Chưa có bệnh án trước.</p><?php endif; ?>
        </div></div>
    </div>
    <div class="col-lg-8">
        <div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Khám bệnh</h5></div><div class="card-body">
            <div class="alert alert-info"><strong>Triệu chứng mô tả:</strong> <?= nl2br(e($appointment['symptoms'] ?? 'Không có')) ?></div>
            <form method="POST" action="<?= url('/doctor/medical-records/create/' . $appointment['id']) ?>"><?= csrf_field() ?>
                <div class="mb-3"><label class="form-label">Triệu chứng ghi nhận</label><textarea name="symptoms" class="form-control" rows="2"><?= e($appointment['symptoms'] ?? '') ?></textarea></div>
                <div class="mb-3"><label class="form-label">Chẩn đoán *</label><textarea name="diagnosis" class="form-control" rows="3" required placeholder="Nhập chẩn đoán..."></textarea></div>
                <div class="mb-3"><label class="form-label">Phương pháp điều trị *</label><textarea name="treatment" class="form-control" rows="3" required placeholder="Nhập phương pháp điều trị..."></textarea></div>
                <div class="mb-3"><label class="form-label">Ghi chú</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
                <div class="mb-3"><label class="form-label">Ngày tái khám</label><input type="date" name="follow_up_date" class="form-control"></div>
                <button type="submit" class="btn btn-gradient btn-lg"><i class="fas fa-save me-2"></i>Lưu bệnh án & Kê đơn thuốc</button>
            </form>
        </div></div>
    </div>
</div>
