<h4 class="mb-4">Thanh toán</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Ngày</th><th>Số tiền</th><th>Phương thức</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($payments as $p): ?>
        <tr><td>#<?= $p['id'] ?></td><td><?= format_date($p['created_at']) ?></td><td class="fw-bold"><?= format_money($p['amount']) ?></td><td><?= e($p['method'] ?? 'Chưa chọn') ?></td><td><?= status_badge($p['status']) ?></td>
        <td><?php if ($p['status'] === 'pending'): ?><a href="<?= url('/patient/payments/pay/' . $p['id']) ?>" class="btn btn-sm btn-gradient"><i class="fas fa-credit-card me-1"></i>Thanh toán</a><?php endif; ?></td></tr>
        <?php endforeach; ?>
        <?php if (empty($payments)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Chưa có thanh toán</td></tr><?php endif; ?>
    </tbody>
</table></div></div>
