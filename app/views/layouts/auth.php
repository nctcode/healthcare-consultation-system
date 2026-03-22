<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Xác thực') ?> | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <?php if ($msg = get_flash('success')): ?>
        <div class="toast-container"><div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i><?= e($msg) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    <?php endif; ?>
    <?php if ($msg = get_flash('error')): ?>
        <div class="toast-container"><div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i><?= e($msg) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>
    <?php endif; ?>

    <?= $content ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>setTimeout(() => document.querySelectorAll('.toast-container .alert').forEach(a => a.remove()), 5000);</script>
</body>
</html>
