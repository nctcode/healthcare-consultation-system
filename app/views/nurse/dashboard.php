<div class="row g-4 mb-4">
    <div class="col-sm-6"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Bệnh nhân đang chăm sóc</div><div class="stat-value"><?= $totalActive ?></div></div><div class="stat-icon bg-gradient-primary"><i class="fas fa-procedures"></i></div></div></div></div>
    <div class="col-sm-6"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Hôm nay</div><div class="stat-value"><?= date('d/m/Y') ?></div></div><div class="stat-icon bg-gradient-accent"><i class="fas fa-calendar-day"></i></div></div></div></div>
</div>
<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Bệnh nhân đang chăm sóc</h5></div><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0">
    <thead><tr><th>Bệnh nhân</th><th>Bác sĩ phụ trách</th><th>Ngày phân công</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($assignments as $a): ?>
        <tr><td><strong><?= e($a['patient_name'] ?? '') ?></strong></td><td><?= e($a['doctor_name'] ?? '') ?></td><td><?= format_date($a['created_at']) ?></td><td><?= status_badge($a['status']) ?></td>
        <td><a href="<?= url('/nurse/health-update/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-heartbeat me-1"></i>Cập nhật</a> <a href="<?= url('/nurse/care-notes/' . $a['id']) ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-notes-medical me-1"></i>Ghi chú</a></td></tr>
        <?php endforeach; ?>
        <?php if (empty($assignments)): ?><tr><td colspan="5" class="text-center py-4 text-muted">Chưa có bệnh nhân nào</td></tr><?php endif; ?>
    </tbody>
</table></div></div></div>
