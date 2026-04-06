<div class="container section">
    <h2 class="section-title mb-4">Đội ngũ bác sĩ</h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">
                <a href="<?= url('/bac-si') ?>" class="btn btn-sm <?= !$currentSpecialty ? 'btn-primary' : 'btn-outline-primary' ?>">Tất cả</a>
                <?php foreach ($specialties as $s): ?>
                    <a href="<?= url('/bac-si?specialty=' . $s['id']) ?>" class="btn btn-sm <?= $currentSpecialty == $s['id'] ? 'btn-primary' : 'btn-outline-primary' ?>"><?= e($s['name']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <?php foreach ($doctors as $doc): ?>
        <div class="col-md-6 col-lg-3">
            <div class="card card-custom doctor-card h-100">
                <div class="card-body">
                    <div class="doctor-avatar"><?= mb_substr($doc['full_name'], 0, 1) ?></div>
                    <div class="doctor-name"><?= e($doc['full_name']) ?></div>
                    <div class="doctor-specialty"><?= e($doc['specialty_name'] ?? '') ?></div>
                    <div class="doctor-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?><i class="fas fa-star<?= $i <= round($doc['rating'] ?? 0) ? '' : ' text-muted' ?>"></i><?php endfor; ?>
                        <span class="text-muted ms-1"><?= number_format($doc['rating'] ?? 0, 1) ?></span>
                    </div>
                    <p class="text-muted small mt-2">Phí khám: <?= format_money($doc['consultation_fee'] ?? 0) ?></p>
                    <a href="<?= url('/bac-si/' . $doc['id']) ?>" class="btn btn-outline-primary btn-sm mt-2 w-100">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($doctors)): ?>
            <div class="col-12 text-center py-5 text-muted"><i class="fas fa-user-md fa-3x mb-3 d-block"></i>Không tìm thấy bác sĩ nào.</div>
        <?php endif; ?>
    </div>
</div>
