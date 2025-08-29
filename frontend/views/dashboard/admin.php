<!-- views/dashboard/admin.php -->
<style>
    .badge.bg-primary { background-color: #0d6efd !important; }
    .badge.bg-info { background-color: #0dcaf0 !important; }
    .badge.bg-warning { background-color: #ffc107 !important; }
    .badge.bg-danger { background-color: #dc3545 !important; }
    .badge.bg-secondary { background-color: #6c757d !important; }
    .badge.bg-dark { background-color: #212529 !important; }

    .badge {
        font-size: 0.8em;
        padding: 0.5em 0.8em;
        font-weight: 600;
    }
</style>

<?php
// Helper function to return Bootstrap color class
function statusColor($status) {
    switch ($status) {
        case 'Checked-In':
        case 'In-Consultation':
            return 'primary';
        case 'Lab':
            return 'info';
        case 'Pharmacy':
            return 'warning';
        case 'Discharged':
            return 'secondary';
        case 'Emergency':
            return 'danger';
        default:
            return 'dark';
    }
}
$this->title = 'Admin Command Center';
$this->params['sidebar'] = 'admin-sidebar';
?>

<div class="row g-4 mb-4">
    <!-- Critical Alerts -->
    <div class="col-md-3">
        <div class="card border-danger">
            <div class="card-body">
                <h5><i class="fas fa-exclamation-triangle text-danger"></i> Critical</h5>
                <p class="display-6"><?= $criticalLabs + $overduePayments ?></p>
                <small><?= $criticalLabs ?> lab results | <?= $overduePayments ?> unpaid bills</small>
            </div>
        </div>
    </div>

    <!-- Total Patients -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5><i class="fas fa-user-injured"></i> Total Patients</h5>
                <p class="display-6"><?= number_format($totalPatients) ?></p>
                <small>+<?= $newToday ?> today</small>
            </div>
        </div>
    </div>

    <!-- Staff Online -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5><i class="fas fa-users"></i> Staff Online</h5>
                <p class="display-6"><?= $staffOnline ?></p>
                <small><?= $doctorsOnline ?> doctors, <?= $nursesOnline ?> nurses</small>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5><i class="fas fa-yuan-sign"></i> Today's Revenue</h5>
                <p class="display-6">¥<?= number_format($dailyRevenue, 2) ?></p>
                <small><?= $paymentsToday ?> transactions</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Live Patient Flow -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <strong>🏥 Live Patient Flow</strong>
                <span class="badge bg-warning">Real-Time</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Status</th>
                            <th>Ward/Dept</th>
                            <th>Time In</th>
                        </tr>
                    </thead>
                    <tbody id="live-patients">
                        <?php foreach ($livePatients as $p): ?>
                        <tr class="fw-bold <?= $p['priority'] === 'urgent' ? 'alert-critical' : '' ?>">
                            <td><?= $p['hosp_id'] ?></td>
                            <td><?= $p['name'] ?></td>
                            <td><span class="badge bg-<?= statusColor($p['status']) ?>"> <?= $p['status'] ?> </span></td>
                            <td><?= $p['ward'] ?></td>
                            <td><?= date('H:i', $p['check_in']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- System Alerts -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">🚨 System Alerts</div>
            <div class="list-group list-group-flush">
                <?php if ($lowStockMeds): ?>
                <a href="/pharmacy/stock" class="list-group-item list-group-item-danger">
                    <i class="fas fa-pills"></i> <?= count($lowStockMeds) ?> meds below reorder level
                </a>
                <?php endif; ?>
                <a href="/lab/reports" class="list-group-item list-group-item-warning">
                    <i class="fas fa-x-ray"></i> 3 critical lab results pending review
                </a>
                <a href="/finance/report" class="list-group-item list-group-item-info">
                    <i class="fas fa-file-invoice"></i> Insurance claim batch failed
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mt-4">
    <div class="col-md-6">
        <canvas id="patientTrend"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="departmentLoad"></canvas>
    </div>
</div>

<script>
// Real-time chart
new Chart(document.getElementById('patientTrend'), {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Daily Patients',
            data: [142, 165, 138, 177, 192, 210, 155],
            borderColor: '#0d6efd',
            tension: 0.4
        }]
    }
});
</script>