<?php if (!$payment): ?><div class="alert alert-warning">Không tìm thấy hóa đơn.</div><?php return; endif; ?>
<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Thanh toán hóa đơn #<?= $payment['id'] ?></h5></div><div class="card-body">
    <div class="text-center mb-4"><h2 class="text-primary"><?= format_money($payment['amount']) ?></h2><p class="text-muted">Lịch khám ngày <?= format_date($payment['created_at']) ?></p></div>
    <form method="POST"><?= csrf_field() ?>
        <div class="mb-3"><label class="form-label">Phương thức thanh toán</label>
            <div class="row g-3">
                <div class="col-md-4"><label class="card p-3 text-center cursor-pointer"><input type="radio" name="method" value="cash" class="d-none" checked><i class="fas fa-money-bill-wave fa-2x text-success mb-2 d-block"></i>Tiền mặt</label></div>
                <div class="col-md-4"><label class="card p-3 text-center cursor-pointer"><input type="radio" name="method" value="bank_transfer" class="d-none"><i class="fas fa-university fa-2x text-primary mb-2 d-block"></i>Chuyển khoản</label></div>
                <div class="col-md-4"><label class="card p-3 text-center cursor-pointer"><input type="radio" name="method" value="card" class="d-none"><i class="fas fa-credit-card fa-2x text-info mb-2 d-block"></i>Thẻ</label></div>
            </div>
        </div>
        <button type="submit" class="btn btn-gradient btn-lg w-100"><i class="fas fa-check-circle me-2"></i>Xác nhận thanh toán</button>
    </form>
</div></div>
