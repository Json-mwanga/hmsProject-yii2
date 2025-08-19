<!-- views/dashboard/hr.php -->
<?php
$this->title = 'HR Portal';
$this->params['sidebar'] = 'hr-sidebar';
?>

<h3><i class="fas fa-user-tie"></i> Human Resources — <?= date('M Y') ?></h3>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-users"></i> Total Staff</h5>
                <p class="display-6"><?= $totalStaff ?></p>
                <small><?= $doctors ?> doctors, <?= $nurses ?> nurses</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark text-center">
            <div class="card-body">
                <h5><i class="fas fa-calendar-check"></i> On Leave</h5>
                <p class="display-6"><?= $onLeave ?></p>
                <small>today</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-wallet"></i> Payroll</h5>
                <p class="display-6">¥<?= number_format($monthlyPayroll / 1e6, 1) ?>M</p>
                <small>this month</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h5><i class="fas fa-user-plus"></i> New Hires</h5>
                <p class="display-6"><?= $newHires ?></p>
                <small>this month</small>
            </div>
        </div>
    </div>
</div>

<!-- Staff Table -->
<div class="card">
    <div class="card-header">📋 Staff Directory</div>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Department</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($staffList as $s): ?>
            <tr>
                <td><?= $s['emp_id'] ?></td>
                <td><?= $s['name'] ?></td>
                <td><span class="badge bg-<?= roleColor($s['role']) ?>"><?= ucfirst($s['role']) ?></span></td>
                <td><?= $s['department'] ?></td>
                <td><span class="badge bg-<?= $s['status'] === 'Active' ? 'success' : 'secondary' ?>"><?= $s['status'] ?></span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editStaff(<?= $s['id'] ?>)">
                        Edit
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- Attendance Chart -->
<div class="card mt-4">
    <div class="card-body">
        <canvas id="attendanceChart"></canvas>
    </div>
</div>

<script>
new Chart(document.getElementById('attendanceChart'), {
    type: 'doughnut',
    data: {
        labels: ['Present', 'On Leave', 'Absent'],
         [87, 10, 3],
        backgroundColor: ['#198754', '#fd7e14', '#dc3545']
    }
});
</script>