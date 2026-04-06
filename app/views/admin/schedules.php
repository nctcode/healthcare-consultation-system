<h4 class="mb-4">Lịch làm việc bác sĩ</h4>
<div class="card card-custom mb-4"><div class="card-header bg-white"><h5 class="mb-0">Thêm lịch mới</h5></div><div class="card-body"><form method="POST"><?= csrf_field() ?>
    <div class="row">
        <div class="col-md-3 mb-3"><label class="form-label">Bác sĩ</label><select name="doctor_id" class="form-select" required><option value="">Chọn</option><?php foreach ($doctors as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['full_name']) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-2 mb-3"><label class="form-label">Ngày</label><select name="day_of_week" class="form-select"><?php for ($i=0;$i<7;$i++): ?><option value="<?= $i ?>"><?= day_name($i) ?></option><?php endfor; ?></select></div>
        <div class="col-md-2 mb-3"><label class="form-label">Giờ bắt đầu</label><input type="time" name="start_time" class="form-control" value="08:00" required></div>
        <div class="col-md-2 mb-3"><label class="form-label">Giờ kết thúc</label><input type="time" name="end_time" class="form-control" value="12:00" required></div>
        <div class="col-md-2 mb-3"><label class="form-label">Số BN tối đa</label><input type="number" name="max_patients" class="form-control" value="20"></div>
        <div class="col-md-1 mb-3"><label class="form-label">&nbsp;</label><button type="submit" class="btn btn-gradient w-100"><i class="fas fa-plus"></i></button></div>
    </div>
</form></div></div>
<div class="table-custom"><div class="table-responsive"><table class="table">
    <thead><tr><th>Bác sĩ</th><th>Chuyên khoa</th><th>Thứ</th><th>Giờ</th><th>Tối đa BN</th></tr></thead>
    <tbody>
        <?php foreach ($schedules as $s): ?>
        <tr><td><strong><?= e($s['doctor_name']) ?></strong></td><td><?= e($s['specialty_name'] ?? '') ?></td><td><?= day_name($s['day_of_week']) ?></td><td><?= format_time($s['start_time']) ?> - <?= format_time($s['end_time']) ?></td><td><?= $s['max_patients'] ?></td></tr>
        <?php endforeach; ?>
    </tbody>
</table></div></div>
