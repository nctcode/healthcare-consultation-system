<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Quản lý bệnh nhân</h4>
    <a href="<?= url('/admin/patients/create') ?>" class="btn btn-gradient"><i class="fas fa-plus me-2"></i>Thêm bệnh nhân</a>
</div>

<?php if (get_flash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= e(get_flash('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (get_flash('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= e(get_flash('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="table-custom">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Bảo hiểm</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($patients)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-inbox me-2"></i>Chưa có bệnh nhân nào
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($patients as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><strong><?= e($p['full_name']) ?></strong></td>
                            <td><?= e($p['email']) ?></td>
                            <td><?= e($p['phone'] ?? '') ?></td>
                            <td><?= format_date($p['date_of_birth'] ?? '') ?></td>
                            <td>
                                <?php
                                $genders = ['male' => 'Nam', 'female' => 'Nữ', 'other' => 'Khác'];
                                echo e($genders[$p['gender'] ?? 'other'] ?? 'N/A');
                                ?>
                            </td>
                            <td><?= e($p['insurance_number'] ?? 'N/A') ?></td>
                            <td><?= status_badge($p['status'] ?? 'active') ?></td>
                            <td>
                                <a href="<?= url('/admin/patients/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= url('/admin/patients/delete/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa bệnh nhân này?')">
                                    <i class="fas fa-trash"></i>
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
