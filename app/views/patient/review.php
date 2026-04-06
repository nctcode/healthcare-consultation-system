<?php if (!$appointment): ?><div class="alert alert-warning">Không tìm thấy lịch khám.</div><?php return; endif; ?>
<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Đánh giá bác sĩ <?= e($appointment['doctor_name'] ?? '') ?></h5></div><div class="card-body">
    <form method="POST"><?= csrf_field() ?>
        <div class="mb-3 text-center"><label class="form-label d-block">Đánh giá</label>
            <div class="rating-stars" style="font-size:2rem;color:var(--warning)">
                <?php for ($i = 1; $i <= 5; $i++): ?><label><input type="radio" name="rating" value="<?= $i ?>" class="d-none" <?= $i==5?'checked':'' ?>><i class="fas fa-star" style="cursor:pointer"></i></label><?php endfor; ?>
            </div>
        </div>
        <div class="mb-3"><label class="form-label">Nhận xét</label><textarea name="comment" class="form-control" rows="4" placeholder="Chia sẻ trải nghiệm của bạn..." required></textarea></div>
        <button type="submit" class="btn btn-gradient"><i class="fas fa-paper-plane me-2"></i>Gửi đánh giá</button>
    </form>
</div></div>
