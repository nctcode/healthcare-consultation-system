<h4 class="mb-4">Báo cáo thống kê</h4>
<div class="row g-4 mb-4">
    <div class="col-md-4"><div class="stat-card"><div class="stat-label">Tổng doanh thu</div><div class="stat-value text-success"><?= format_money($totalRevenue) ?></div></div></div>
    <div class="col-md-4"><div class="stat-card"><div class="stat-label">Doanh thu hôm nay</div><div class="stat-value text-primary"><?= format_money($todayRevenue) ?></div></div></div>
    <div class="col-md-4"><div class="stat-card"><div class="stat-label">Tổng lượt khám</div><div class="stat-value"><?= $totalAppts ?></div></div></div>
</div>
<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="stat-card"><div class="stat-label">Hoàn thành</div><div class="stat-value text-success"><?= $completedAppts ?></div></div></div>
    <div class="col-md-3"><div class="stat-card"><div class="stat-label">Đã hủy</div><div class="stat-value text-danger"><?= $cancelledAppts ?></div></div></div>
    <div class="col-md-2"><div class="stat-card"><div class="stat-label">Trực tiếp</div><div class="stat-value"><?= $directCount ?></div></div></div>
    <div class="col-md-2"><div class="stat-card"><div class="stat-label">Online</div><div class="stat-value"><?= $onlineCount ?></div></div></div>
    <div class="col-md-2"><div class="stat-card"><div class="stat-label">Tại nhà</div><div class="stat-value"><?= $homeCount ?></div></div></div>
</div>
