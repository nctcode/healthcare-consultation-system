<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Danh sách Bác sĩ</h4>
</div>
<div class="table-custom">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>Chuyên khoa</th><th>Kinh nghiệm</th><th>Phí khám</th><th>Rating</th><th>Trạng thái</th></tr></thead>
            <tbody>
                <?php foreach ($doctors as $i => $d): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= e($d['full_name']) ?></strong></td>
                    <td><?= e($d['email']) ?></td>
                    <td><span class="badge bg-primary"><?= e($d['specialty_name'] ?? '') ?></span></td>
                    <td><?= $d['experience_years'] ?? 0 ?> năm</td>
                    <td><?= format_money($d['consultation_fee'] ?? 0) ?></td>
                    <td><span class="text-warning"><i class="fas fa-star"></i></span> <?= number_format($d['rating'] ?? 0, 1) ?></td>
                    <td><?= status_badge($d['status']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($doctors)): ?><tr><td colspan="8" class="text-center py-4 text-muted">Không có dữ liệu bác sĩ</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
