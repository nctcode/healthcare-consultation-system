<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Bệnh án đã tạo</h4>
</div>

<?php if (get_flash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= e(get_flash('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="table-custom">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ngày</th>
                    <th>Bệnh nhân</th>
                    <th>Chẩn đoán</th>
                    <th>Tái khám</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($records)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox me-2"></i>Chưa có bệnh án nào
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($records as $r): ?>
                        <tr>
                            <td><strong>#<?= $r['id'] ?></strong></td>
                            <td><?= format_date($r['created_at']) ?></td>
                            <td><?= e($r['patient_name'] ?? '') ?></td>
                            <td><?= truncate($r['diagnosis'] ?? '', 60) ?></td>
                            <td><?= $r['follow_up_date'] ? format_date($r['follow_up_date']) : '-' ?></td>
                            <td>
                                <a href="<?= url('/doctor/medical-records/edit/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php clear_old_input(); ?>
