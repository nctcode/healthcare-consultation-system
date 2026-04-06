<h4 class="mb-4">Thông báo</h4>
<?php foreach ($notifications as $n): ?>
<div class="card card-custom mb-2 <?= $n['is_read'] ? '' : 'border-start border-3 border-primary' ?>">
    <div class="card-body py-3 d-flex justify-content-between align-items-center">
        <div><h6 class="mb-1"><?= e($n['title']) ?></h6><p class="mb-0 small text-muted"><?= e($n['message']) ?></p></div>
        <div class="text-end"><small class="text-muted"><?= time_ago($n['created_at']) ?></small>
        <?php if ($n['link']): ?><br><a href="<?= url($n['link']) ?>" class="btn btn-sm btn-outline-primary mt-1">Xem</a><?php endif; ?></div>
    </div>
</div>
<?php endforeach; ?>
<?php if (empty($notifications)): ?><div class="text-center py-5 text-muted"><i class="fas fa-bell-slash fa-3x mb-3 d-block"></i>Không có thông báo nào.</div><?php endif; ?>
