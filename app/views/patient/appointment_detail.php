<?php if (!$appointment): ?><div class="alert alert-warning">Không tìm thấy lịch khám.</div><?php return; endif; ?>
<div class="card card-custom"><div class="card-header bg-white d-flex justify-content-between"><h5 class="mb-0">Chi tiết lịch khám #<?= $appointment['id'] ?></h5><?= status_badge($appointment['status']) ?></div>
<div class="card-body"><div class="row">
    <div class="col-md-6 mb-3"><strong>Ngày khám:</strong> <?= format_date($appointment['appointment_date']) ?></div>
    <div class="col-md-6 mb-3"><strong>Giờ:</strong> <?= format_time($appointment['appointment_time']) ?></div>
    <div class="col-md-6 mb-3"><strong>Bác sĩ:</strong> <?= e($appointment['doctor_name'] ?? '') ?></div>
    <div class="col-md-6 mb-3"><strong>Chuyên khoa:</strong> <?= e($appointment['specialty_name'] ?? '') ?></div>
    <div class="col-md-6 mb-3"><strong>Hình thức:</strong> <?= appointment_type_label($appointment['appointment_type_id'] ?? 1) ?></div>
    <div class="col-md-6 mb-3"><strong>Mã QR:</strong> <code><?= e($appointment['qr_code'] ?? '') ?></code></div>
    <div class="col-12 mb-3"><strong>Triệu chứng:</strong><p><?= nl2br(e($appointment['symptoms'] ?? '')) ?></p></div>
    <?php if (!empty($appointment['address'])): ?><div class="col-12 mb-3"><strong>Địa chỉ khám tại nhà:</strong> <?= e($appointment['address']) ?></div><?php endif; ?>
    <?php if (!empty($appointment['notes'])): ?><div class="col-12"><strong>Ghi chú:</strong> <?= nl2br(e($appointment['notes'])) ?></div><?php endif; ?>
</div></div></div>
