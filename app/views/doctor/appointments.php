<h4 class="mb-4">Danh sách lịch khám</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>Ngày</th><th>Giờ</th><th>Bệnh nhân</th><th>Hình thức</th><th>Triệu chứng</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($appointments as $a): ?>
        <tr><td><?= format_date($a['appointment_date']) ?></td><td><?= format_time($a['appointment_time']) ?></td><td><strong><?= e($a['patient_name'] ?? '') ?></strong></td><td><?= appointment_type_label($a['appointment_type_id'] ?? 1) ?></td><td><?= truncate($a['symptoms'] ?? '', 40) ?></td><td><?= status_badge($a['status']) ?></td>
        <td>
            <?php if (in_array($a['status'], ['confirmed','in_progress'])): ?><a href="<?= url('/doctor/examine/' . $a['id']) ?>" class="btn btn-sm btn-gradient"><i class="fas fa-stethoscope"></i></a><?php endif; ?>
            <?php if ($a['appointment_type_id'] == 2): ?><a href="<?= url('/chat/' . $a['id']) ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-comments"></i></a><?php endif; ?>
        </td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
