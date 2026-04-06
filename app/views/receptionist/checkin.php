<h4 class="mb-4"><i class="fas fa-qrcode me-2"></i>Check-in bệnh nhân</h4>
<div class="row">
    <div class="col-md-6">
        <div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Nhập mã QR</h5></div><div class="card-body">
            <div id="qr-reader" class="mb-3"></div>
            <p class="text-muted small mb-3">Bạn có thể quét bằng camera hoặc nhập mã thủ công.</p>
            <form method="POST" id="checkin-form">
                <?= csrf_field() ?>
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

<script src="https://unpkg.com/html5-qrcode" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let submitted = false;
    const input = document.querySelector('input[name="qr_code"]');
    const form = document.getElementById('checkin-form');

    function onScanSuccess(decodedText) {
        if (submitted || !decodedText) return;
        submitted = true;
        input.value = decodedText;
        form.submit();
    }

    if (window.Html5QrcodeScanner) {
        const scanner = new Html5QrcodeScanner('qr-reader', {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            rememberLastUsedCamera: true,
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
        }, false);

        scanner.render(onScanSuccess, function () {});
    }
});
</script>
