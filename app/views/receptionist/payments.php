<h4 class="mb-4">Quản lý thanh toán</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Bệnh nhân</th><th>Số tiền</th><th>Ngày tạo</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($payments as $p): ?>
        <tr><td>#<?= $p['id'] ?></td><td><strong><?= e($p['patient_name'] ?? '') ?></strong></td><td class="fw-bold text-primary"><?= format_money($p['amount']) ?></td><td><?= format_date($p['created_at']) ?></td><td><?= status_badge($p['status']) ?></td>
        <td>
            <?php if ($p['status'] === 'pending'): ?>
            <form method="POST" action="<?= url('/receptionist/payments/confirm/' . $p['id']) ?>" class="d-inline">
                <?= csrf_field() ?>
                <select name="method" class="form-select form-select-sm d-inline w-auto">
                    <option value="cash">Tiền mặt</option><option value="transfer">Chuyển khoản</option><option value="ewallet">Ví điện tử</option><option value="qr_code">QR Code</option>
                </select>
                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Xác nhận thanh toán?')"><i class="fas fa-check me-1"></i>Xác nhận</button>
            </form>
            <?php else: ?><span class="text-success"><i class="fas fa-check-circle"></i> Đã thu</span><?php endif; ?>
        </td></tr>
        <?php endforeach; ?>
        <?php if (empty($payments)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Không có khoản thanh toán chờ</td></tr><?php endif; ?>
    </tbody>
</table></div></div>
