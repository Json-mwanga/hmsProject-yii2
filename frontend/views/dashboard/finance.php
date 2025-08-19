<!-- views/dashboard/finance.php -->
<?php
$this->title = 'Finance Hub';
$this->params['sidebar'] = 'finance-sidebar';
?>

<h3><i class="fas fa-coins"></i> Finance Dashboard — <?= date('M j, Y') ?></h3>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-yuan-sign"></i> Today's Revenue</h5>
                <p class="display-6">¥<?= number_format($dailyRevenue, 2) ?></p>
                <small><?= $transactions ?> payments</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-file-invoice"></i> Unpaid Bills</h5>
                <p class="display-6"><?= $unpaidCount ?></p>
                <small>¥<?= number_format($unpaidAmount) ?> total</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-credit-card"></i> WeChat/Alipay</h5>
                <p class="display-6"><?= $digitalPayments ?></p>
                <small><?= round($digitalPct, 1) ?>% of total</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-file-contract"></i> Control Numbers</h5>
                <p class="display-6"><?= $controlsIssued ?></p>
                <small>today</small>
            </div>
        </div>
    </div>
</div>

<!-- Unpaid Bills Table -->
<div class="card">
    <div class="card-header">🚨 Unpaid Bills (Top Priority)</div>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Hosp ID</th>
                <th>Patient</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Insurance</th>
                <th>Action</th>
            </tr>
            <?php foreach ($unpaidBills as $b): ?>
            <tr class="table-warning">
                <td><?= $b['hosp_id'] ?></td>
                <td><?= $b['name'] ?></td>
                <td>¥<?= $b['total'] ?></td>
                <td>¥<?= $b['paid'] ?></td>
                <td><strong>¥<?= $b['balance'] ?></strong></td>
                <td><span class="badge bg-info"><?= $b['insurance'] ?></span></td>
                <td>
                    <button class="btn btn-sm btn-success" onclick="collectPayment(<?= $b['bill_id'] ?>)">
                        Collect
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- Revenue Chart -->
<div class="card mt-4">
    <div class="card-body">
        <canvas id="revenueChart" height="100"></canvas>
    </div>
</div>

<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Daily Revenue (¥)',
             [8420, 9150, 7630, 10240, 12500, 14300, 6200],
            backgroundColor: '#20c997'
        }]
    }
});
</script>