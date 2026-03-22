<div class="container section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="doctor-avatar me-3" style="width:80px;height:80px;font-size:2rem"><?= mb_substr($doctor['full_name'], 0, 1) ?></div>
                        <div>
                            <h3 class="mb-1"><?= e($doctor['full_name']) ?></h3>
                            <span class="badge bg-primary"><?= e($doctor['specialty_name'] ?? '') ?></span>
                            <div class="text-warning mt-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?><i class="fas fa-star<?= $i <= round($doctor['rating']) ? '' : ' text-muted' ?>"></i><?php endfor; ?>
                                <span class="text-muted ms-1">(<?= number_format($doctor['rating'], 1) ?>)</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6"><strong>Bằng cấp:</strong> <?= e($doctor['qualification'] ?? '') ?></div>
                        <div class="col-sm-6"><strong>Kinh nghiệm:</strong> <?= e($doctor['experience_years'] ?? 0) ?> năm</div>
                    </div>
                    <div class="mb-3"><strong>Phí khám:</strong> <span class="text-primary fw-bold"><?= format_money($doctor['consultation_fee'] ?? 0) ?></span></div>
                    <div><strong>Giới thiệu:</strong><p class="mt-1"><?= nl2br(e($doctor['bio'] ?? '')) ?></p></div>
                </div>
            </div>
            <!-- Đánh giá -->
            <div class="card card-custom">
                <div class="card-header bg-white"><h5 class="mb-0">Đánh giá từ bệnh nhân</h5></div>
                <div class="card-body">
                    <?php foreach ($reviews as $r): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between"><strong><?= e($r['patient_name']) ?></strong><small class="text-muted"><?= time_ago($r['created_at']) ?></small></div>
                        <div class="text-warning mb-1"><?php for ($i = 0; $i < $r['rating']; $i++): ?><i class="fas fa-star"></i><?php endfor; ?></div>
                        <p class="mb-0"><?= e($r['comment']) ?></p>
                    </div>
                    <?php endforeach; ?>
                    <?php if (empty($reviews)): ?><p class="text-muted">Chưa có đánh giá nào.</p><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- Lịch làm việc -->
            <div class="card card-custom mb-4">
                <div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Lịch làm việc</h5></div>
                <div class="card-body">
                    <?php if (empty($schedules)): ?><p class="text-muted">Chưa có lịch.</p><?php endif; ?>
                    <?php foreach ($schedules as $s): ?>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span><?= day_name($s['day_of_week']) ?></span>
                        <span class="text-primary"><?= format_time($s['start_time']) ?> - <?= format_time($s['end_time']) ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Đặt lịch -->
            <div class="card card-custom">
                <div class="card-body text-center p-4">
                    <h5 class="mb-3">Đặt lịch khám ngay</h5>
                    <?php if (Auth::check()): ?>
                        <a href="<?= url('/patient/appointments/book') ?>" class="btn btn-gradient w-100 btn-lg"><i class="fas fa-calendar-plus me-2"></i>Đặt lịch</a>
                    <?php else: ?>
                        <a href="<?= url('/dang-nhap') ?>" class="btn btn-gradient w-100 btn-lg"><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để đặt lịch</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
