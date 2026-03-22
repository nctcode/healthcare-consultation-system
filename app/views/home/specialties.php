<div class="container section">
    <div class="text-center mb-5">
        <h2 class="section-title">Chuyên khoa</h2>
        <p class="section-subtitle">Đa dạng chuyên khoa với đội ngũ bác sĩ giỏi</p>
    </div>
    <div class="row g-4">
        <?php foreach ($specialties as $spec): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <a href="<?= url('/bac-si?specialty=' . $spec['id']) ?>" class="text-decoration-none">
                <div class="specialty-card h-100">
                    <div class="icon"><i class="<?= e($spec['icon']) ?>"></i></div>
                    <h5><?= e($spec['name']) ?></h5>
                    <p><?= truncate($spec['description'] ?? '', 60) ?></p>
                    <span class="badge bg-primary"><?= $spec['doctor_count'] ?? 0 ?> bác sĩ</span>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
