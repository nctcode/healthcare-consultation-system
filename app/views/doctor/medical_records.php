<h4 class="mb-4">Bệnh án đã tạo</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Ngày</th><th>Bệnh nhân</th><th>Chẩn đoán</th><th>Tái khám</th></tr></thead>
    <tbody>
        <?php foreach ($records as $r): ?>
        <tr><td>#<?= $r['id'] ?></td><td><?= format_date($r['created_at']) ?></td><td><?= e($r['patient_name'] ?? '') ?></td><td><?= truncate($r['diagnosis'] ?? '', 60) ?></td><td><?= $r['follow_up_date'] ? format_date($r['follow_up_date']) : '-' ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
