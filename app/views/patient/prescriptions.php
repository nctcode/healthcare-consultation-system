<h4 class="mb-4">Đơn thuốc</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Ngày kê</th><th>Bác sĩ</th><th>Ghi chú</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($prescriptions as $p): ?>
        <tr><td>#<?= $p['id'] ?></td><td><?= format_date($p['created_at']) ?></td><td><?= e($p['doctor_name'] ?? '') ?></td><td><?= truncate($p['notes'] ?? '',50) ?></td>
        <td><a href="<?= url('/patient/prescriptions/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td></tr>
        <?php endforeach; ?>
        <?php if (empty($prescriptions)): ?><tr><td colspan="5" class="text-center py-4 text-muted">Chưa có đơn thuốc</td></tr><?php endif; ?>
    </tbody>
</table></div></div>
