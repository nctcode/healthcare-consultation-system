<!-- Hero Section -->
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-star me-1"></i> Hệ thống y tế thông minh hàng đầu</span>
                <h1>Smart Healthcare <br><span style="color:#93c5fd">Consultation System</span></h1>
                <p>Tư vấn & Khám bệnh Online • Tại nhà • Trực tiếp. Kết nối với đội ngũ bác sĩ chuyên khoa hàng đầu.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?= url('/dang-ky') ?>" class="btn btn-light btn-lg px-4"><i class="fas fa-calendar-plus me-2"></i>Đặt lịch khám ngay</a>
                    <a href="<?= url('/bac-si') ?>" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-user-md me-2"></i>Xem bác sĩ</a>
                </div>
                <div class="row mt-4 pt-3">
                    <div class="col-4">
                        <h3 class="fw-bold mb-0">50+</h3><small class="opacity-75">Bác sĩ chuyên khoa</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold mb-0">10K+</h3><small class="opacity-75">Bệnh nhân tin tưởng</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold mb-0">4.8★</h3><small class="opacity-75">Đánh giá trung bình</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner shadow-lg" style="border-radius: 1.5rem; overflow: hidden; border: 4px solid white;">
                        <div class="carousel-item active" data-bs-interval="4000">
                            <img src="<?= asset('images/hero-slide-1.png') ?>" class="d-block w-100" alt="Khám trực tiếp">
                        </div>
                        <div class="carousel-item" data-bs-interval="4000">
                            <img src="<?= asset('images/hero-slide-2.png') ?>" class="d-block w-100" alt="Khám Online">
                        </div>
                        <div class="carousel-item" data-bs-interval="4000">
                            <img src="<?= asset('images/hero-slide-3.png') ?>" class="d-block w-100" alt="Khám tại nhà">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section bg-white">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Hình thức khám bệnh</h2>
            <p class="section-subtitle">Lựa chọn hình thức khám phù hợp với nhu cầu của bạn</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="specialty-card h-100">
                    <div class="icon"><i class="fas fa-hospital"></i></div>
                    <h5>Khám trực tiếp</h5>
                    <p>Đến khám tại bệnh viện với đầy đủ trang thiết bị y tế hiện đại</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="specialty-card h-100" style="border-bottom:3px solid var(--primary)">
                    <div class="icon"><i class="fas fa-video"></i></div>
                    <h5>Khám Online</h5>
                    <p>Tư vấn trực tuyến qua video call, tiện lợi không cần di chuyển</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="specialty-card h-100">
                    <div class="icon"><i class="fas fa-home"></i></div>
                    <h5>Khám tại nhà</h5>
                    <p>Bác sĩ đến tận nhà khám bệnh, phù hợp người già và trẻ nhỏ</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Specialties Section -->
<section class="section">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Chuyên khoa</h2>
            <p class="section-subtitle">Đa dạng chuyên khoa phục vụ mọi nhu cầu sức khỏe</p>
        </div>
        <div class="row g-4">
            <?php foreach ($specialties as $spec): ?>
            <div class="col-6 col-md-3">
                <a href="<?= url('/bac-si?specialty=' . $spec['id']) ?>" class="text-decoration-none">
                    <div class="specialty-card h-100">
                        <div class="icon"><i class="<?= e($spec['icon']) ?>"></i></div>
                        <h5><?= e($spec['name']) ?></h5>
                        <p><?= $spec['doctor_count'] ?? 0 ?> bác sĩ</p>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Doctors Section -->
<section class="section bg-white">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Bác sĩ nổi bật</h2>
            <p class="section-subtitle">Đội ngũ bác sĩ giỏi, giàu kinh nghiệm</p>
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
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star<?= $i <= round($doc['rating']) ? '' : '-half-alt' ?>"></i>
                            <?php endfor; ?>
                            <span class="text-muted ms-1"><?= number_format($doc['rating'], 1) ?></span>
                        </div>
                        <p class="text-muted small mt-2">Phí khám: <?= format_money($doc['consultation_fee']) ?></p>
                        <a href="<?= url('/bac-si/' . $doc['id']) ?>" class="btn btn-outline-primary btn-sm mt-2">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= url('/bac-si') ?>" class="btn btn-gradient btn-lg"><i class="fas fa-users me-2"></i>Xem tất cả bác sĩ</a>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="section">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Đánh giá từ bệnh nhân</h2>
            <p class="section-subtitle">Những phản hồi thực tế từ bệnh nhân</p>
        </div>
        <div class="row g-4">
            <?php foreach ($reviews as $review): ?>
            <div class="col-md-6">
                <div class="card card-custom review-card h-100">
                    <div class="card-body">
                        <div class="stars mb-2">
                            <?php for ($i = 0; $i < $review['rating']; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                        </div>
                        <p class="mb-2">"<?= e($review['comment']) ?>"</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-primary"><?= e($review['patient_name']) ?></strong>
                            <small class="text-muted">Bác sĩ: <?= e($review['doctor_name']) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section bg-gradient-primary text-white text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Đặt lịch khám ngay hôm nay</h2>
        <p class="mb-4 opacity-75">Chăm sóc sức khỏe của bạn là ưu tiên hàng đầu của chúng tôi</p>
        <a href="<?= url('/dang-ky') ?>" class="btn btn-light btn-lg px-5"><i class="fas fa-calendar-plus me-2"></i>Đăng ký & Đặt lịch</a>
    </div>
</section>
