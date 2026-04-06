<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Khám hôm nay</div><div class="stat-value"><?= count($todayAppointments) ?></div></div><div class="stat-icon bg-gradient-primary"><i class="fas fa-calendar-day"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-4"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Đã hoàn thành</div><div class="stat-value"><?= $completedToday ?></div></div><div class="stat-icon bg-gradient-accent"><i class="fas fa-check-circle"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-4"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Tổng lượt khám</div><div class="stat-value"><?= $totalAppointments ?></div></div><div class="stat-icon bg-info"><i class="fas fa-chart-line"></i></div></div></div></div>
</div>
<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Lịch khám hôm nay (<?= date('d/m/Y') ?>)</h5></div><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0">
    <thead><tr><th>Giờ</th><th>Bệnh nhân</th><th>Hình thức</th><th>Triệu chứng</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($todayAppointments as $a): ?>
        <tr><td><?= format_time($a['appointment_time']) ?></td><td><strong><?= e($a['patient_name'] ?? '') ?></strong></td><td><?= appointment_type_label($a['appointment_type_id'] ?? 1) ?></td><td><?= truncate($a['symptoms'] ?? '', 40) ?></td><td><?= status_badge($a['status']) ?></td>
        <td>
            <?php if (in_array($a['status'], ['confirmed','in_progress'])): ?><a href="<?= url('/doctor/examine/' . $a['id']) ?>" class="btn btn-sm btn-gradient"><i class="fas fa-stethoscope me-1"></i>Khám</a><?php endif; ?>
            <?php if ($a['status'] === 'completed'): ?><span class="text-success"><i class="fas fa-check"></i></span><?php endif; ?>
        </td></tr>
        <?php endforeach; ?>
        <?php if (empty($todayAppointments)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Không có lịch khám hôm nay</td></tr><?php endif; ?>
    </tbody>
</table></div></div></div>
