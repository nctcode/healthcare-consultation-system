<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Danh sách Bệnh nhân</h4>
</div>
<div class="table-custom">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Họ tên</th><th>Năm sinh</th><th>Giới tính</th><th>Điện thoại</th><th>Nhóm máu</th><th>SĐT Khẩn cấp</th></tr></thead>
            <tbody>
                <?php foreach ($patients as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= e($p['full_name']) ?></strong></td>
                    <td><?= $p['date_of_birth'] ? date('d/m/Y', strtotime($p['date_of_birth'])) : '' ?></td>
                    <td><?= $p['gender'] === 'male' ? 'Nam' : ($p['gender'] === 'female' ? 'Nữ' : 'Khác') ?></td>
                    <td><?= e($p['phone'] ?? '') ?></td>
                    <td><span class="badge bg-info text-dark"><?= e($p['blood_type'] ?? 'N/A') ?></span></td>
                    <td><?= e($p['emergency_contact'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($patients)): ?><tr><td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu bệnh nhân</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
