<!-- views/dashboard/reception.php -->
<?php
$this->title = 'Reception Hub';
$this->params['sidebar'] = 'reception-sidebar';
?>

<h3><i class="fas fa-deskpro"></i> Reception Desk — <?= date('D, M j, Y') ?></h3>

<div class="row g-4 mb-4">
    <!-- New Registrations Today -->
    <div class="col-md-3">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-id-card"></i> New Patients</h5>
                <p class="display-6"><?= $newRegistrations ?></p>
                <small><?= $today ?> today</small>
            </div>
        </div>
    </div>

    <!-- Check-Ins -->
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-sign-in-alt"></i> Check-Ins</h5>
                <p class="display-6"><?= $checkIns ?></p>
                <small>cash: <?= $cashPatients ?> | insurance: <?= $insurancePatients ?></small>
            </div>
        </div>
    </div>

    <!-- Queue Length -->
    <div class="col-md-3">
        <div class="card bg-warning text-dark text-center">
            <div class="card-body">
                <h5><i class="fas fa-users"></i> Waiting</h5>
                <p class="display-6"><?= $waitingCount ?></p>
                <small>avg wait: 18 min</small>
            </div>
        </div>
    </div>

    <!-- Barcode Scanner Status -->
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-qrcode"></i> Scanners</h5>
                <p class="display-6"><i class="fas fa-check-circle"></i></p>
                <small>All 4 active</small>
            </div>
        </div>
    </div>
</div>

<!-- Live Queue Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <strong>👥 Live Patient Queue</strong>
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
            <i class="fas fa-plus"></i> Register New
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Hosp ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Check-In</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($queue as $q): ?>
                <tr class="<?= $q['priority'] === 'urgent' ? 'table-danger fw-bold' : '' ?>">
                    <td><strong><?= $q['hosp_id'] ?></strong></td>
                    <td><?= $q['name'] ?></td>
                    <td>
                        <span class="badge bg-<?= $q['payment_type'] === 'Insurance' ? 'info' : 'secondary' ?>">
                            <?= $q['payment_type'] ?>
                        </span>
                    </td>
                    <td><?= date('H:i', $q['check_in']) ?></td>
                    <td><span class="badge bg-<?= statusClass($q['status']) ?>"><?= $q['status'] ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-success" onclick="assignDoctor(<?= $q['id'] ?>)">
                            Assign
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Register Patient -->
<div class="modal fade" id="registerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/reception/register" method="post">
                <div class="modal-header">
                    <h5>Register New Patient</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name" required>
                    <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name" required>
                    <input type="date" name="dob" class="form-control mb-2" required>
                    <select name="insurance_type" class="form-control mb-2">
                        <option value="None">Cash</option>
                        <option value="Urban">Urban Insurance</option>
                        <option value="Rural">Rural Insurance</option>
                        <option value="Commercial">Commercial</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate ID & Card</button>
                </div>
            </form>
        </div>
    </div>
</div>