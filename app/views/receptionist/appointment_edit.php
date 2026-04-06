<?php if (!$appointment): ?><div class="alert alert-warning">Không tìm thấy.</div><?php return; endif; ?>
<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0">Sửa lịch hẹn #<?= $appointment['id'] ?></h5></div><div class="card-body">
    <form method="POST"><?= csrf_field() ?>
        <div class="row">
            <div class="col-md-4 mb-3"><label class="form-label">Ngày</label><input type="date" name="appointment_date" class="form-control" value="<?= e($appointment['appointment_date']) ?>"></div>
            <div class="col-md-4 mb-3"><label class="form-label">Giờ</label><input type="time" name="appointment_time" class="form-control" value="<?= e($appointment['appointment_time']) ?>"></div>
            <div class="col-md-4 mb-3"><label class="form-label">Trạng thái</label><select name="status" class="form-select">
                <?php foreach (['pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','in_progress'=>'Đang khám','completed'=>'Hoàn thành','cancelled'=>'Đã hủy'] as $v=>$l): ?>
                <option value="<?= $v ?>" <?= $appointment['status']==$v?'selected':'' ?>><?= $l ?></option>
                <?php endforeach; ?></select></div>
            <div class="col-12 mb-3"><label class="form-label">Ghi chú</label><textarea name="notes" class="form-control" rows="2"><?= e($appointment['notes'] ?? '') ?></textarea></div>
        </div>
        <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Cập nhật</button> <a href="<?= url('/receptionist/appointments') ?>" class="btn btn-outline-secondary">Quay lại</a>
    </form>
</div></div>
