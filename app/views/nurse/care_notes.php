<div class="card card-custom"><div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-notes-medical me-2"></i>Ghi chú chăm sóc</h5></div><div class="card-body">
    <form method="POST"><?= csrf_field() ?>
        <div class="mb-3"><label class="form-label">Ghi chú</label><textarea name="notes" class="form-control" rows="5"><?= e($assignment['notes'] ?? '') ?></textarea></div>
        <div class="mb-3"><label class="form-label">Trạng thái</label>
            <select name="status" class="form-select"><option value="active" <?= ($assignment['status']??'')=='active'?'selected':'' ?>>Đang chăm sóc</option><option value="completed" <?= ($assignment['status']??'')=='completed'?'selected':'' ?>>Hoàn thành</option></select>
        </div>
        <button type="submit" class="btn btn-gradient"><i class="fas fa-save me-2"></i>Lưu</button> <a href="<?= url('/nurse/patients') ?>" class="btn btn-outline-secondary">Quay lại</a>
    </form>
</div></div>
