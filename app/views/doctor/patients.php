<h4 class="mb-4">Bệnh nhân của tôi</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Giới tính</th><th>Lượt khám</th><th>Lần cuối</th></tr></thead>
    <tbody>
        <?php foreach ($patients as $i => $p): ?>
        <tr><td><?= $i+1 ?></td><td><strong><?= e($p['full_name']) ?></strong></td><td><?= e($p['email']) ?></td><td><?= e($p['phone']) ?></td><td><?= gender_label($p['gender'] ?? '') ?></td><td><span class="badge bg-primary"><?= $p['visit_count'] ?></span></td><td><?= format_date($p['last_visit']) ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
