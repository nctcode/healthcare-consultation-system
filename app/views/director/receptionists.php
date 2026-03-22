<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Danh sách Lễ tân</h4>
</div>
<div class="table-custom">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>Điện thoại</th><th>Quầy số</th><th>Ca trực</th><th>Trạng thái</th></tr></thead>
            <tbody>
                <?php foreach ($receptionists as $i => $r): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= e($r['full_name']) ?></strong></td>
                    <td><?= e($r['email']) ?></td>
                    <td><?= e($r['phone'] ?? '') ?></td>
                    <td><span class="badge bg-secondary"><?= e($r['desk_number'] ?? 'N/A') ?></span></td>
                    <td><?= e($r['shift'] ?? 'Chưa rõ') ?></td>
                    <td><?= status_badge($r['status']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($receptionists)): ?><tr><td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu lễ tân</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
