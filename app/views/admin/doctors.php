<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Quản lý bác sĩ</h4>
    <a href="<?= url('/admin/doctors/create') ?>" class="btn btn-gradient"><i class="fas fa-plus me-2"></i>Thêm bác sĩ</a>
</div>
<div class="table-custom">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Họ tên</th><th>Email</th><th>Chuyên khoa</th><th>Kinh nghiệm</th><th>Phí khám</th><th>Rating</th><th>Thao tác</th></tr></thead>
            <tbody>
                <?php foreach ($doctors as $i => $d): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= e($d['full_name']) ?></strong></td>
                    <td><?= e($d['email']) ?></td>
                    <td><span class="badge bg-primary"><?= e($d['specialty_name'] ?? '') ?></span></td>
                    <td><?= $d['experience_years'] ?? 0 ?> năm</td>
                    <td><?= format_money($d['consultation_fee'] ?? 0) ?></td>
                    <td><span class="text-warning"><i class="fas fa-star"></i></span> <?= number_format($d['rating'] ?? 0, 1) ?></td>
                    <td>
                        <a href="<?= url('/admin/doctors/edit/' . $d['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <a href="<?= url('/admin/doctors/delete/' . $d['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa bác sĩ này?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
