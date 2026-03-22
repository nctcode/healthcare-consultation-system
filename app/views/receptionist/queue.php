<h4 class="mb-4">Hàng chờ bệnh nhân hôm nay (<?= date('d/m/Y') ?>)</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>STT</th><th>Giờ hẹn</th><th>Bệnh nhân</th><th>Bác sĩ</th><th>Chuyên khoa</th><th>Hình thức</th><th>Trạng thái</th></tr></thead>
    <tbody>
        <?php foreach ($queue as $i => $a): ?>
        <tr class="<?= $a['status'] === 'in_progress' ? 'table-warning' : ($a['status'] === 'completed' ? 'table-success' : '') ?>">
            <td><span class="badge bg-primary rounded-pill"><?= $i+1 ?></span></td>
            <td><?= format_time($a['appointment_time']) ?></td>
            <td><strong><?= e($a['patient_name'] ?? '') ?></strong></td>
            <td><?= e($a['doctor_name'] ?? '') ?></td>
            <td><?= e($a['specialty_name'] ?? '') ?></td>
            <td><?= appointment_type_label($a['appointment_type_id'] ?? 1) ?></td>
            <td><?= status_badge($a['status']) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($queue)): ?><tr><td colspan="7" class="text-center py-4 text-muted">Chưa có bệnh nhân trong hàng chờ</td></tr><?php endif; ?>
    </tbody>
</table></div></div>
