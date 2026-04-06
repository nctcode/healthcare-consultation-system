<h4 class="mb-4">Quản lý lễ tân</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Quầy</th><th>Ca trực</th><th>Trạng thái</th></tr></thead>
    <tbody>
        <?php foreach ($receptionists as $i => $r): ?>
        <tr><td><?= $i+1 ?></td><td><strong><?= e($r['full_name']) ?></strong></td><td><?= e($r['email']) ?></td><td><?= e($r['phone']) ?></td><td><?= e($r['desk_number'] ?? '') ?></td><td><?= e($r['shift'] ?? '') ?></td><td><?= status_badge($r['status']) ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
