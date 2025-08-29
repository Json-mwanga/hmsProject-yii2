<!-- views/dashboard/lab.php -->
<h3><i class="fas fa-microscope"></i> Lab Dashboard — <?= date('M j, Y') ?></h3>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h5>Pending</h5>
                <p class="display-6"><?= $pending ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <h5>Urgent</h5>
                <p class="display-6"><?= $urgent ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h5>Finalized</h5>
                <p class="display-6"><?= $completed ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white text-center">
            <div class="card-body">
                <h5>Today's Total</h5>
                <p class="display-8"><?= $total ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="card mt-4">
    <div class="card-header">🔬 Lab Orders (Pending)</div>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Patient</th>
                <th>Test</th>
                <th>Ward</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
            <?php foreach ($pendingOrders as $o): ?>
            <tr>
                <td><?= $o['patient_name'] ?></td>
                <td><span class="badge bg-primary"><?= $o['test_type'] ?></span></td>
                <td><?= $o['ward'] ?></td>
                <td><?= date('H:i', $o['ordered_at']) ?></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="startLab(<?= $o['id'] ?>)">
                        Process
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>