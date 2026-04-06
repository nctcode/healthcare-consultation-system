<h4 class="mb-4">Quản lý bệnh nhân</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Giới tính</th><th>Ngày sinh</th><th>BHYT</th><th>Trạng thái</th></tr></thead>
    <tbody>
        <?php foreach ($patients as $i => $p): ?>
        <tr>
            <td><?= $i + 1 ?></td><td><strong><?= e($p['full_name']) ?></strong></td><td><?= e($p['email']) ?></td>
            <td><?= e($p['phone']) ?></td><td><?= gender_label($p['gender'] ?? '') ?></td>
            <td><?= format_date($p['date_of_birth'] ?? '') ?></td><td><?= e($p['insurance_number'] ?? 'N/A') ?></td>
            <td><?= status_badge($p['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
