<h4 class="mb-4">Hồ sơ bệnh án</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Ngày khám</th><th>Bác sĩ</th><th>Chẩn đoán</th><th>Tái khám</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($records as $r): ?>
        <tr><td>#<?= $r['id'] ?></td><td><?= format_date($r['created_at']) ?></td><td><?= e($r['doctor_name'] ?? '') ?></td><td><?= truncate($r['diagnosis'] ?? '', 60) ?></td><td><?= $r['follow_up_date'] ? format_date($r['follow_up_date']) : '-' ?></td>
        <td><a href="<?= url('/patient/medical-records/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td></tr>
        <?php endforeach; ?>
        <?php if (empty($records)): ?><tr><td colspan="6" class="text-center py-4 text-muted">Chưa có bệnh án</td></tr><?php endif; ?>
    </tbody>
</table></div></div>
