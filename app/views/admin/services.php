<div class="d-flex justify-content-between align-items-center mb-4"><h4>Quản lý dịch vụ</h4><a href="<?= url('/admin/services/create') ?>" class="btn btn-gradient"><i class="fas fa-plus me-2"></i>Thêm</a></div>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Tên dịch vụ</th><th>Mô tả</th><th>Giá</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
    <tbody>
        <?php foreach ($services as $i => $s): ?>
        <tr><td><?= $i+1 ?></td><td><strong><?= e($s['name']) ?></strong></td><td><?= truncate($s['description'] ?? '',50) ?></td><td><?= format_money($s['price']) ?></td><td><?= status_badge($s['status']) ?></td>
        <td><a href="<?= url('/admin/services/edit/'.$s['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a> <a href="<?= url('/admin/services/delete/'.$s['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
