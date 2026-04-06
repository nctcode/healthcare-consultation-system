<div class="d-flex justify-content-between align-items-center mb-4"><h4>Quản lý thuốc</h4><a href="<?= url('/admin/medicines/create') ?>" class="btn btn-gradient"><i class="fas fa-plus me-2"></i>Thêm thuốc</a></div>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Tên thuốc</th><th>Tên gốc</th><th>Đơn vị</th><th>Giá</th><th>Tồn kho</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
    <tbody>
        <?php foreach ($medicines as $i => $m): ?>
        <tr><td><?= $i+1 ?></td><td><strong><?= e($m['name']) ?></strong></td><td><?= e($m['generic_name'] ?? '') ?></td><td><?= e($m['unit']) ?></td><td><?= format_money($m['price']) ?></td><td><?= $m['stock'] ?></td><td><?= status_badge($m['status']) ?></td>
        <td><a href="<?= url('/admin/medicines/edit/'.$m['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a> <a href="<?= url('/admin/medicines/delete/'.$m['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
