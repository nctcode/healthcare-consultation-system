<div class="d-flex justify-content-between align-items-center mb-4"><h4>Quản lý người dùng</h4><a href="<?= url('/admin/users/create') ?>" class="btn btn-gradient"><i class="fas fa-plus me-2"></i>Thêm</a></div>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Vai trò</th><th>Trạng thái</th><th>Ngày tạo</th><th>Thao tác</th></tr></thead>
    <tbody>
        <?php foreach ($users as $i => $u): ?>
        <tr><td><?= $i+1 ?></td><td><strong><?= e($u['full_name']) ?></strong></td><td><?= e($u['email']) ?></td><td><?= e($u['phone'] ?? '') ?></td>
        <td><span class="badge bg-info"><?= e($u['role_display'] ?? $u['role_name']) ?></span></td><td><?= status_badge($u['status']) ?></td><td><?= format_datetime($u['created_at']) ?></td>
        <td><a href="<?= url('/admin/users/edit/'.$u['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a> <a href="<?= url('/admin/users/delete/'.$u['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
