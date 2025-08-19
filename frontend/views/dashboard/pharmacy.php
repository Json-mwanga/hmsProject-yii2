<!-- views/dashboard/pharmacy.php -->
<?php
$this->title = 'Pharmacy Hub';
$this->params['sidebar'] = 'pharmacy-sidebar';
?>

<h3><i class="fas fa-pills"></i> Pharmacy — <?= date('M j, Y') ?></h3>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-prescription"></i> Prescriptions</h5>
                <p class="display-6"><?= $pendingPrescriptions ?></p>
                <small>awaiting dispensing</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark text-center">
            <div class="card-body">
                <h5><i class="fas fa-exclamation-triangle"></i> Low Stock</h5>
                <p class="display-6"><?= $lowStockCount ?></p>
                <small>meds below reorder</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-check-circle"></i> Dispensed</h5>
                <p class="display-6"><?= $dispensedToday ?></p>
                <small>today</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-boxes"></i> Total Stock</h5>
                <p class="display-6"><?= $totalMeds ?></p>
                <small>unique medicines</small>
            </div>
        </div>
    </div>
</div>

<!-- Low Stock Alert Table -->
<div class="card mb-4">
    <div class="card-header bg-danger text-white">⚠️ Critical Low Stock</div>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Medicine</th>
                <th>Batch</th>
                <th>Expiry</th>
                <th>Current</th>
                <th>Reorder</th>
                <th>Action</th>
            </tr>
            <?php foreach ($criticalStock as $m): ?>
            <tr class="table-danger">
                <td><strong><?= $m['name'] ?></strong></td>
                <td><?= $m['batch'] ?></td>
                <td><?= $m['expiry'] ?></td>
                <td><?= $m['stock'] ?></td>
                <td><?= $m['reorder'] ?></td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="orderStock(<?= $m['id'] ?>)">
                        Reorder
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- Pending Prescriptions -->
<div class="card">
    <div class="card-header">📋 Prescriptions to Dispense</div>
    <div class="list-group list-group-flush">
        <?php foreach ($pendingPrescriptionsList as $p): ?>
        <a href="/pharmacy/dispense?prescription=<?= $p['id'] ?>" class="list-group-item d-flex justify-content-between">
            <div>
                <strong><?= $p['patient_name'] ?></strong>
                <div class="text-muted"><?= $p['med_count'] ?> meds</div>
            </div>
            <span class="badge bg-primary align-self-center">Process</span>
        </a>
        <?php endforeach; ?>
    </div>
</div>