<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Lịch hẹn hôm nay</div><div class="stat-value"><?= $todayCount ?></div></div><div class="stat-icon bg-gradient-primary"><i class="fas fa-calendar-check"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Doanh thu hôm nay</div><div class="stat-value"><?= format_money($todayRevenue) ?></div></div><div class="stat-icon bg-gradient-accent"><i class="fas fa-money-bill-wave"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Chờ thanh toán</div><div class="stat-value"><?= $pendingPayments ?></div></div><div class="stat-icon bg-warning"><i class="fas fa-clock"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Ngày</div><div class="stat-value"><?= date('d/m') ?></div></div><div class="stat-icon bg-info"><i class="fas fa-calendar-day"></i></div></div></div></div>
</div>
<div class="card card-custom"><div class="card-header bg-white d-flex justify-content-between"><h5 class="mb-0">Hàng chờ hôm nay</h5><a href="<?= url('/receptionist/checkin') ?>" class="btn btn-sm btn-gradient"><i class="fas fa-qrcode me-1"></i>Check-in</a></div>
<div class="card-body p-0"><div class="table-responsive"><table class="table mb-0">
    <thead><tr><th>STT</th><th>Giờ</th><th>Bệnh nhân</th><th>Bác sĩ</th><th>Hình thức</th><th>Trạng thái</th></tr></thead>
    <tbody>
        <?php foreach ($todayQueue as $i => $a): ?>
        <tr><td><?= $i+1 ?></td><td><?= format_time($a['appointment_time']) ?></td><td><strong><?= e($a['patient_name'] ?? '') ?></strong></td><td><?= e($a['doctor_name'] ?? '') ?></td><td><?= appointment_type_label($a['appointment_type_id'] ?? 1) ?></td><td><?= status_badge($a['status']) ?></td></tr>
        <?php endforeach; ?>
        <?php if (empty($todayQueue)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Chưa có lịch hẹn hôm nay</td></tr><?php endif; ?>
    </tbody>
</table></div></div></div>
