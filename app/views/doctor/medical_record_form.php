<div class="card card-custom">
    <div class="card-header bg-white">
        <h5 class="mb-0"><?= e($title) ?></h5>
    </div>
    <div class="card-body">
        <?php if (get_flash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= e(get_flash('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!$record): ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>Không tìm thấy bệnh án.
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <?= csrf_field() ?>

                <!-- Thông tin bệnh nhân -->
                <div class="alert alert-info mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Bệnh nhân:</strong> <?= e($record['patient_name'] ?? '') ?><br>
                            <strong>Ngày sinh:</strong> <?= format_date($record['date_of_birth'] ?? '') ?><br>
                            <strong>Giới tính:</strong> 
                            <?php 
                            $genders = ['male' => 'Nam', 'female' => 'Nữ', 'other' => 'Khác'];
                            echo e($genders[$record['gender'] ?? 'other'] ?? 'N/A');
                            ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Bác sĩ:</strong> <?= e($record['doctor_name'] ?? '') ?><br>
                            <strong>Chuyên khoa:</strong> <?= e($record['specialty_name'] ?? 'N/A') ?><br>
                            <strong>Ngày khám:</strong> <?= format_datetime($record['created_at'] ?? '') ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Triệu chứng</label>
                        <textarea name="symptoms" class="form-control" rows="2"><?= e($record['symptoms'] ?? old('symptoms')) ?></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Chẩn đoán *</label>
                        <textarea name="diagnosis" class="form-control" rows="4" required><?= e($record['diagnosis'] ?? old('diagnosis')) ?></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Phương pháp điều trị *</label>
                        <textarea name="treatment" class="form-control" rows="4" required><?= e($record['treatment'] ?? old('treatment')) ?></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="notes" class="form-control" rows="3"><?= e($record['notes'] ?? old('notes')) ?></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày tái khám</label>
                        <input type="date" name="follow_up_date" class="form-control" 
                            value="<?= e($record['follow_up_date'] ?? old('follow_up_date')) ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cập nhật lần cuối</label>
                        <input type="text" class="form-control" disabled 
                            value="<?= format_datetime($record['updated_at'] ?? '') ?>">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-gradient">
                        <i class="fas fa-save me-2"></i>Lưu bệnh án
                    </button>
                    <a href="<?= url('/doctor/medical-records') ?>" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php clear_old_input(); ?>
