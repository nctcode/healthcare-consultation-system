<h4 class="mb-4">Kê đơn thuốc</h4>
<div class="card card-custom"><div class="card-body"><form method="POST"><?= csrf_field() ?>
    <div class="mb-3"><label class="form-label">Ghi chú đơn thuốc</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
    <h5 class="mb-3">Danh sách thuốc</h5>
    <div id="medicineList">
        <div class="row g-2 mb-2 medicine-row">
            <div class="col-md-3"><select name="medicine_id[]" class="form-select" required><option value="">Chọn thuốc</option><?php foreach ($medicines as $m): ?><option value="<?= $m['id'] ?>"><?= e($m['name']) ?> (<?= format_money($m['price']) ?>)</option><?php endforeach; ?></select></div>
            <div class="col-md-1"><input type="number" name="quantity[]" class="form-control" value="1" min="1" placeholder="SL"></div>
            <div class="col-md-2"><input type="text" name="dosage[]" class="form-control" placeholder="Liều dùng"></div>
            <div class="col-md-2"><input type="text" name="duration[]" class="form-control" placeholder="Thời gian"></div>
            <div class="col-md-3"><input type="text" name="instructions[]" class="form-control" placeholder="Hướng dẫn"></div>
            <div class="col-md-1"><button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.medicine-row').remove()"><i class="fas fa-times"></i></button></div>
        </div>
    </div>
    <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="addMedicineRow()"><i class="fas fa-plus me-1"></i>Thêm thuốc</button>
    <div><button type="submit" class="btn btn-gradient btn-lg"><i class="fas fa-save me-2"></i>Lưu đơn thuốc</button></div>
</form></div></div>
<script>
function addMedicineRow() {
    const list = document.getElementById('medicineList');
    const row = list.querySelector('.medicine-row').cloneNode(true);
    row.querySelectorAll('input').forEach(i => i.value = i.type === 'number' ? '1' : '');
    row.querySelector('select').value = '';
    list.appendChild(row);
}
</script>
