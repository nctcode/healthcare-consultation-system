<h4 class="mb-4"><i class="fas fa-qrcode me-2"></i>Check-in bệnh nhân</h4>
<div class="row">
    <div class="col-md-6">
        <div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Nhập mã QR</h5></div><div class="card-body">
            <form method="POST">
                <div class="mb-3"><label class="form-label">Mã QR</label><input type="text" name="qr_code" class="form-control form-control-lg" placeholder="Nhập hoặc scan mã QR..." autofocus required></div>
                <button type="submit" class="btn btn-gradient btn-lg w-100"><i class="fas fa-check-circle me-2"></i>Check-in</button>
            </form>
        </div></div>
    </div>
    <div class="col-md-6">
        <?php if ($result): ?>
        <div class="card card-custom">
            <div class="card-body text-center py-5">
                <?php if ($result['success']): ?>
                    <div class="text-success mb-3"><i class="fas fa-check-circle fa-4x"></i></div>
                    <h3 class="text-success"><?= e($result['message']) ?></h3>
                    <p class="mt-2">Bệnh nhân: <strong><?= e($result['appointment']['patient_name'] ?? '') ?></strong></p>
                    <p>Bác sĩ: <strong><?= e($result['appointment']['doctor_name'] ?? '') ?></strong></p>
                <?php else: ?>
                    <div class="text-danger mb-3"><i class="fas fa-times-circle fa-4x"></i></div>
                    <h3 class="text-danger"><?= e($result['message']) ?></h3>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
