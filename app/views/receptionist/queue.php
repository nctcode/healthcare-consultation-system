<h4 class="mb-4">Hàng chờ bệnh nhân hôm nay (<?= date('d/m/Y') ?>)</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>STT</th><th>Giờ hẹn</th><th>Bệnh nhân</th><th>Bác sĩ</th><th>Chuyên khoa</th><th>Hình thức</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
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
            <td class="text-nowrap">
                <?php if ($a['status'] === 'confirmed'): ?>
                    <form method="POST" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="appointment_id" value="<?= (int)$a['id'] ?>">
                        <input type="hidden" name="action" value="call_next">
                        <button type="submit" class="btn btn-sm btn-primary">Gọi khám</button>
                    </form>
                    <form method="POST" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="appointment_id" value="<?= (int)$a['id'] ?>">
                        <input type="hidden" name="action" value="mark_absent">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Vắng mặt</button>
                    </form>
                <?php elseif ($a['status'] === 'in_progress'): ?>
                    <form method="POST" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="appointment_id" value="<?= (int)$a['id'] ?>">
                        <input type="hidden" name="action" value="complete">
                        <button type="submit" class="btn btn-sm btn-success">Hoàn tất</button>
                    </form>
                    <form method="POST" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="appointment_id" value="<?= (int)$a['id'] ?>">
                        <input type="hidden" name="action" value="return_waiting">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Trả về chờ</button>
                    </form>
                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($queue)): ?><tr><td colspan="8" class="text-center py-4 text-muted">Chưa có bệnh nhân trong hàng chờ</td></tr><?php endif; ?>
    </tbody>
</table></div></div>
