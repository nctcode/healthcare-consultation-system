<?php if (!$prescription): ?><div class="alert alert-warning">Không tìm thấy đơn thuốc.</div><?php return; endif; ?>
<div class="card card-custom mb-4"><div class="card-header bg-white"><h5 class="mb-0">Đơn thuốc #<?= $prescription['id'] ?></h5></div><div class="card-body">
    <div class="row mb-3"><div class="col-md-6"><strong>Ngày kê:</strong> <?= format_date($prescription['created_at']) ?></div><div class="col-md-6"><strong>Bác sĩ:</strong> <?= e($prescription['doctor_name'] ?? '') ?></div></div>
    <?php if ($prescription['notes']): ?><p><strong>Ghi chú:</strong> <?= nl2br(e($prescription['notes'])) ?></p><?php endif; ?>
    <div class="table-responsive"><table class="table table-bordered">
        <thead class="table-light"><tr><th>#</th><th>Thuốc</th><th>Số lượng</th><th>Liều dùng</th><th>Thời gian</th><th>Hướng dẫn</th></tr></thead>
        <tbody>
            <?php foreach ($items as $i => $item): ?>
            <tr><td><?= $i+1 ?></td><td><strong><?= e($item['medicine_name'] ?? '') ?></strong></td><td><?= $item['quantity'] ?></td><td><?= e($item['dosage'] ?? '') ?></td><td><?= e($item['duration'] ?? '') ?></td><td><?= e($item['instructions'] ?? '') ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table></div>
    <button onclick="window.print()" class="btn btn-outline-primary"><i class="fas fa-print me-2"></i>In đơn thuốc</button>
</div></div>
