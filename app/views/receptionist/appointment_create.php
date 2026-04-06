<h4 class="mb-4">Tạo lịch hẹn tại quầy</h4>

<div class="card card-custom">
    <div class="card-header bg-white">
        <h5 class="mb-0">Thông tin lịch hẹn</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bệnh nhân <span class="text-danger">*</span></label>
                    <select name="patient_id" class="form-select" required>
                        <option value="">-- Chọn bệnh nhân --</option>
                        <?php foreach ($patients as $p): ?>
                            <option value="<?= (int)$p['id'] ?>"><?= e($p['full_name']) ?> - <?= e($p['phone'] ?? 'N/A') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Bác sĩ <span class="text-danger">*</span></label>
                    <select name="doctor_id" class="form-select" required>
                        <option value="">-- Chọn bác sĩ --</option>
                        <?php foreach ($doctors as $d): ?>
                            <option value="<?= (int)$d['id'] ?>">BS. <?= e($d['full_name']) ?><?= !empty($d['specialty_name']) ? ' - ' . e($d['specialty_name']) : '' ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Loại khám <span class="text-danger">*</span></label>
                    <select name="appointment_type_id" class="form-select" required>
                        <option value="">-- Chọn loại khám --</option>
                        <?php foreach ($appointmentTypes as $t): ?>
                            <option value="<?= (int)$t['id'] ?>"><?= e($t['display_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Ngày khám <span class="text-danger">*</span></label>
                    <input type="date" name="appointment_date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Giờ khám <span class="text-danger">*</span></label>
                    <input type="time" name="appointment_time" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Dịch vụ</label>
                    <select name="service_id" class="form-select">
                        <option value="">-- Không chọn --</option>
                        <?php foreach ($services as $s): ?>
                            <option value="<?= (int)$s['id'] ?>"><?= e($s['name']) ?> (<?= format_money($s['price']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Địa chỉ (khám tại nhà)</label>
                    <input type="text" name="address" class="form-control" placeholder="Địa chỉ nếu là lịch khám tại nhà">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Triệu chứng</label>
                    <textarea name="symptoms" class="form-control" rows="2"></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Tạo lịch hẹn</button>
            <a href="<?= url('/receptionist/appointments') ?>" class="btn btn-outline-secondary">Quay lại</a>
        </form>
    </div>
</div>
