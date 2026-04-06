<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Danh sách Điều dưỡng</h4>
</div>
<div class="table-custom">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>Điện thoại</th><th>Phòng ban</th><th>Ca trực</th><th>Trạng thái</th></tr></thead>
            <tbody>
                <?php foreach ($nurses as $i => $n): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= e($n['full_name']) ?></strong></td>
                    <td><?= e($n['email']) ?></td>
                    <td><?= e($n['phone'] ?? '') ?></td>
                    <td><?= e($n['department'] ?? 'Chưa phân công') ?></td>
                    <td><?= e($n['shift'] ?? 'Chưa rõ') ?></td>
                    <td><?= status_badge($n['status']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($nurses)): ?><tr><td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu điều dưỡng</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
