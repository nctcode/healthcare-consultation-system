<!-- Director Dashboard -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between align-items-start">
            <div><div class="stat-label">Tổng bệnh nhân</div><div class="stat-value"><?= $totalPatients ?></div></div>
            <div class="stat-icon bg-gradient-primary"><i class="fas fa-procedures"></i></div>
        </div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between align-items-start">
            <div><div class="stat-label">Tổng bác sĩ</div><div class="stat-value"><?= $totalDoctors ?></div></div>
            <div class="stat-icon bg-gradient-accent"><i class="fas fa-user-md"></i></div>
        </div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between align-items-start">
            <div><div class="stat-label">Khám hôm nay</div><div class="stat-value"><?= $todayAppointments ?></div></div>
            <div class="stat-icon" style="background:linear-gradient(135deg,#f59e0b,#ef4444)"><i class="fas fa-calendar-check"></i></div>
        </div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between align-items-start">
            <div><div class="stat-label">Doanh thu tháng</div><div class="stat-value"><?= format_money($totalRevenue) ?></div></div>
            <div class="stat-icon" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)"><i class="fas fa-money-bill-wave"></i></div>
        </div></div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Doanh thu hôm nay</div><div class="stat-value"><?= format_money($todayRevenue) ?></div></div><div class="stat-icon bg-success"><i class="fas fa-coins"></i></div></div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Ca khám Online</div><div class="stat-value"><?= $onlineCount ?></div></div><div class="stat-icon bg-info"><i class="fas fa-video"></i></div></div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Ca khám tại nhà</div><div class="stat-value"><?= $homeCount ?></div></div><div class="stat-icon bg-warning"><i class="fas fa-home"></i></div></div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card"><div class="d-flex justify-content-between"><div><div class="stat-label">Đánh giá TB</div><div class="stat-value"><?= number_format($avgRating, 1) ?> ★</div></div><div class="stat-icon bg-danger"><i class="fas fa-star"></i></div></div></div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-custom">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Lượt khám theo tháng</h5>
                <span class="badge bg-primary"><?= date('Y') ?></span>
            </div>
            <div class="card-body"><canvas id="appointmentChart" height="120"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-custom">
            <div class="card-header bg-white"><h5 class="mb-0">Doanh thu theo tháng</h5></div>
            <div class="card-body"><canvas id="revenueChart" height="200"></canvas></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyStats = <?= $monthlyStats ?>;
    const monthlyRevenue = <?= $monthlyRevenue ?>;
    const months = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];

    // Appointment Chart
    const apptData = new Array(12).fill(0);
    monthlyStats.forEach(s => { apptData[s.month - 1] = s.total; });
    new Chart(document.getElementById('appointmentChart'), {
        type: 'bar',
        data: { labels: months, datasets: [{ label: 'Lượt khám', data: apptData, backgroundColor: 'rgba(37,99,235,0.8)', borderRadius: 6 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // Revenue Chart
    const revData = new Array(12).fill(0);
    monthlyRevenue.forEach(r => { revData[r.month - 1] = r.total; });
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: { labels: months, datasets: [{ label: 'Doanh thu (VNĐ)', data: revData, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
});
</script>
