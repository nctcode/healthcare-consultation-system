<h4 class="mb-4">Đặt lịch khám</h4>
<div class="card card-custom"><div class="card-body"><form method="POST" action="<?= url('/patient/appointments/book') ?>"><?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Hình thức khám *</label>
            <select name="appointment_type_id" class="form-select" required>
                <option value="">Chọn hình thức</option>
                <?php foreach ($appointmentTypes as $t): ?><option value="<?= $t['id'] ?>"><?= e($t['name']) ?> - <?= format_money($t['price'] ?? 0) ?></option><?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Chuyên khoa *</label>
            <select id="specialty_select" class="form-select" required>
                <option value="">Chọn chuyên khoa</option>
                <?php foreach ($specialties as $s): ?><option value="<?= $s['id'] ?>"><?= e($s['name']) ?></option><?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Bác sĩ *</label>
            <select name="doctor_id" id="doctor_select" class="form-select" required><option value="">Chọn chuyên khoa trước</option></select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Dịch vụ</label>
            <select name="service_id" class="form-select"><option value="">Không chọn</option><?php foreach ($services as $s): ?><option value="<?= $s['id'] ?>"><?= e($s['name']) ?> - <?= format_money($s['price']) ?></option><?php endforeach; ?></select>
        </div>
        <div class="col-md-6 mb-3"><label class="form-label">Ngày khám *</label><input type="date" name="appointment_date" class="form-control" min="<?= date('Y-m-d') ?>" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Giờ khám *</label><input type="time" name="appointment_time" class="form-control" value="08:00" required></div>
        <div class="col-12 mb-3"><label class="form-label">Triệu chứng / Lý do khám</label><textarea name="symptoms" class="form-control" rows="3" placeholder="Mô tả triệu chứng hoặc lý do khám..."></textarea></div>
        <div class="col-12 mb-3" id="address_field" style="display:none"><label class="form-label">Địa chỉ khám tại nhà</label><input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ"></div>
    </div>
    <button type="submit" class="btn btn-gradient btn-lg"><i class="fas fa-calendar-check me-2"></i>Xác nhận đặt lịch</button>
</form></div></div>

<script>
document.getElementById('specialty_select').addEventListener('change', function() {
    const docSelect = document.getElementById('doctor_select');
    docSelect.innerHTML = '<option value="">Đang tải...</option>';
    fetch('<?= url('/api/doctors-by-specialty/') ?>' + this.value)
        .then(r => r.json())
        .then(data => {
            docSelect.innerHTML = '<option value="">Chọn bác sĩ</option>';
            data.doctors.forEach(d => {
                docSelect.innerHTML += `<option value="${d.id}">${d.full_name} - ${d.consultation_fee ? d.consultation_fee.toLocaleString() + 'đ' : ''}</option>`;
            });
        });
});
document.querySelector('[name="appointment_type_id"]').addEventListener('change', function() {
    document.getElementById('address_field').style.display = this.value == '3' ? 'block' : 'none';
});
</script>
