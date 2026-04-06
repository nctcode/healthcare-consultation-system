<h4 class="mb-4">Quản lý điều dưỡng</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Khoa</th><th>Ca trực</th><th>Trạng thái</th></tr></thead>
    <tbody>
        <?php foreach ($nurses as $i => $n): ?>
        <tr><td><?= $i+1 ?></td><td><strong><?= e($n['full_name']) ?></strong></td><td><?= e($n['email']) ?></td><td><?= e($n['phone']) ?></td><td><?= e($n['department'] ?? '') ?></td><td><?= e($n['shift'] ?? '') ?></td><td><?= status_badge($n['status']) ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
