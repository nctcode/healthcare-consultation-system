<h4 class="mb-4">Quản lý lịch hẹn</h4>
<div class="mb-3">
    <a href="<?= url('/receptionist/appointments/create') ?>" class="btn btn-gradient">
        <i class="fas fa-plus-circle me-2"></i>Tạo lịch hẹn tại quầy
    </a>
</div>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Ngày</th><th>Giờ</th><th>Bệnh nhân</th><th>Bác sĩ</th><th>Hình thức</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($appointments as $a): ?>
        <tr><td>#<?= $a['id'] ?></td><td><?= format_date($a['appointment_date']) ?></td><td><?= format_time($a['appointment_time']) ?></td>
        <td><strong><?= e($a['patient_name'] ?? '') ?></strong></td><td><?= e($a['doctor_name'] ?? '') ?></td><td><?= appointment_type_label($a['appointment_type_id'] ?? 1) ?></td><td><?= status_badge($a['status']) ?></td>
        <td><a href="<?= url('/receptionist/appointments/edit/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
        <?php if ($a['status'] !== 'cancelled' && $a['status'] !== 'completed'): ?><a href="<?= url('/receptionist/appointments/cancel/' . $a['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hủy lịch hẹn?')"><i class="fas fa-times"></i></a><?php endif; ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
