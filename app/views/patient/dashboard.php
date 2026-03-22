<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Lịch khám</div><div class="stat-value"><?= count($appointments) ?></div></div><div class="stat-icon bg-gradient-primary"><i class="fas fa-calendar-check"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Sắp tới</div><div class="stat-value"><?= count(array_filter($appointments, fn($a) => $a['status'] === 'confirmed')) ?></div></div><div class="stat-icon bg-gradient-accent"><i class="fas fa-clock"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Hoàn thành</div><div class="stat-value"><?= count(array_filter($appointments, fn($a) => $a['status'] === 'completed')) ?></div></div><div class="stat-icon bg-success"><i class="fas fa-check-circle"></i></div></div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Thông báo mới</div><div class="stat-value"><?= $unreadNotifs ?></div></div><div class="stat-icon bg-warning"><i class="fas fa-bell"></i></div></div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-custom">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Lịch khám gần đây</h5>
                <a href="<?= url('/patient/appointments/book') ?>" class="btn btn-sm btn-gradient"><i class="fas fa-plus me-2"></i>Đặt lịch</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive"><table class="table mb-0">
                    <thead><tr><th>Ngày</th><th>Bác sĩ</th><th>Hình thức</th><th>Trạng thái</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach (array_slice($appointments, 0, 5) as $a): ?>
                        <tr>
                            <td><?= format_date($a['appointment_date']) ?><br><small class="text-muted"><?= format_time($a['appointment_time']) ?></small></td>
                            <td><strong><?= e($a['doctor_name'] ?? '') ?></strong></td>
                            <td><?= appointment_type_label($a['appointment_type_id'] ?? 1) ?></td>
                            <td><?= status_badge($a['status']) ?></td>
                            <td><a href="<?= url('/patient/appointments/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($appointments)): ?><tr><td colspan="5" class="text-center py-4 text-muted">Chưa có lịch khám nào</td></tr><?php endif; ?>
                    </tbody>
                </table></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-custom">
            <div class="card-header bg-white"><h5 class="mb-0">Truy cập nhanh</h5></div>
            <div class="card-body">
                <a href="<?= url('/patient/appointments/book') ?>" class="btn btn-gradient w-100 mb-2"><i class="fas fa-calendar-plus me-2"></i>Đặt lịch khám</a>
                <a href="<?= url('/patient/medical-records') ?>" class="btn btn-outline-primary w-100 mb-2"><i class="fas fa-file-medical me-2"></i>Hồ sơ bệnh án</a>
                <a href="<?= url('/patient/prescriptions') ?>" class="btn btn-outline-primary w-100 mb-2"><i class="fas fa-prescription me-2"></i>Đơn thuốc</a>
                <a href="<?= url('/patient/payments') ?>" class="btn btn-outline-primary w-100"><i class="fas fa-credit-card me-2"></i>Thanh toán</a>
            </div>
        </div>
    </div>
</div>
