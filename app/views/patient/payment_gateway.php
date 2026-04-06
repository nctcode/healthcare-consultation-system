<?php if (!$payment): ?>
<div class="alert alert-warning">Không tìm thấy giao dịch.</div>
<?php return; endif; ?>

<div class="card card-custom">
    <div class="card-header bg-white">
        <h5 class="mb-0">Cổng thanh toán mô phỏng</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <div><strong>Mã hóa đơn:</strong> #<?= (int)$payment['id'] ?></div>
            <div><strong>Mã giao dịch:</strong> <?= e($txn) ?></div>
            <div><strong>Số tiền:</strong> <span class="text-primary fw-bold"><?= format_money($payment['amount']) ?></span></div>
            <div><strong>Phương thức:</strong> <?= e($payment['method']) ?></div>
        </div>

        <p class="text-muted">Trang này mô phỏng cổng thanh toán bên thứ ba cho môi trường phát triển.</p>

        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-success"
               href="<?= url('/payment-gateway/callback?payment_id=' . (int)$payment['id'] . '&txn=' . urlencode($txn) . '&result=success') ?>">
                <i class="fas fa-check me-1"></i>Mô phỏng thành công
            </a>
            <a class="btn btn-danger"
               href="<?= url('/payment-gateway/callback?payment_id=' . (int)$payment['id'] . '&txn=' . urlencode($txn) . '&result=failed') ?>">
                <i class="fas fa-times me-1"></i>Mô phỏng thất bại
            </a>
            <a class="btn btn-outline-secondary" href="<?= url('/patient/payments') ?>">Quay lại</a>
        </div>
    </div>
</div>
