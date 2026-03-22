<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Cập nhật chỉ số sức khỏe</h5></div><div class="card-body">
    <form method="POST"><?= csrf_field() ?>
        <div class="row">
            <div class="col-md-4 mb-3"><label class="form-label">Huyết áp</label><input type="text" name="blood_pressure" class="form-control" value="<?= e($metrics['blood_pressure'] ?? '') ?>" placeholder="120/80 mmHg"></div>
            <div class="col-md-4 mb-3"><label class="form-label">Nhiệt độ (°C)</label><input type="text" name="temperature" class="form-control" value="<?= e($metrics['temperature'] ?? '') ?>" placeholder="37.0"></div>
            <div class="col-md-4 mb-3"><label class="form-label">Nhịp tim (bpm)</label><input type="text" name="heart_rate" class="form-control" value="<?= e($metrics['heart_rate'] ?? '') ?>" placeholder="80"></div>
            <div class="col-md-4 mb-3"><label class="form-label">SpO2 (%)</label><input type="text" name="spo2" class="form-control" value="<?= e($metrics['spo2'] ?? '') ?>" placeholder="98"></div>
            <div class="col-md-4 mb-3"><label class="form-label">Cân nặng (kg)</label><input type="text" name="weight" class="form-control" value="<?= e($metrics['weight'] ?? '') ?>"></div>
            <div class="col-12 mb-3"><label class="form-label">Ghi chú</label><textarea name="health_note" class="form-control" rows="2"><?= e($metrics['note'] ?? '') ?></textarea></div>
        </div>
        <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Cập nhật</button> <a href="<?= url('/nurse/patients') ?>" class="btn btn-outline-secondary">Quay lại</a>
    </form>
</div></div>
