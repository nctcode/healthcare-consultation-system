<h4 class="mb-4">Bệnh nhân được phân công</h4>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Bệnh nhân</th><th>Bác sĩ</th><th>Ngày</th><th>Ghi chú</th><th>Trạng thái</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($assignments as $i => $a): ?>
        <tr><td><?= $i+1 ?></td><td><strong><?= e($a['patient_name'] ?? '') ?></strong></td><td><?= e($a['doctor_name'] ?? '') ?></td><td><?= format_date($a['created_at']) ?></td><td><?= truncate($a['notes'] ?? '', 40) ?></td><td><?= status_badge($a['status']) ?></td>
        <td><a href="<?= url('/nurse/health-update/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-heartbeat"></i></a> <a href="<?= url('/nurse/care-notes/' . $a['id']) ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-notes-medical"></i></a></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
