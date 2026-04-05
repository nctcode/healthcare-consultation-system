<div class="d-flex justify-content-between align-items-center mb-4"><h4>Lịch khám của tôi</h4><a href="<?= url('/patient/appointments/book') ?>" class="btn btn-gradient"><i class="fas fa-plus me-2"></i>Đặt lịch mới</a></div>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>Mã</th><th>Ngày khám</th><th>Giờ</th><th>Bác sĩ</th><th>Hình thức</th><th>Trạng thái</th><th>QR Code</th><th>Thao tác</th></tr></thead>
    <tbody>
        <?php foreach ($appointments as $a): ?>
        <tr>
            <td>#<?= $a['id'] ?></td><td><?= format_date($a['appointment_date']) ?></td><td><?= format_time($a['appointment_time']) ?></td>
            <td><strong><?= e($a['doctor_name'] ?? '') ?></strong></td><td><?= appointment_type_label($a['appointment_type_id'] ?? 1) ?></td>
            <td><?= status_badge($a['status']) ?></td><td><code><?= e($a['qr_code'] ?? '') ?></code></td>
            <td>
                <a href="<?= url('/patient/appointments/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                <?php if ($a['status'] === 'completed'): ?><a href="<?= url('/patient/reviews/create/' . $a['id']) ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-star"></i></a><?php endif; ?>
                <?php if (in_array($a['status'], ['confirmed', 'in_progress', 'completed'])): ?><a href="<?= url('/messages/' . $a['id']) ?>" class="btn btn-sm btn-outline-success" title="Nhắn tin"><i class="fas fa-comments me-1"></i>💬</a><?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($appointments)): ?><tr><td colspan="8" class="text-center py-4 text-muted">Chưa có lịch khám</td></tr><?php endif; ?>
    </tbody>
</table></div></div>
