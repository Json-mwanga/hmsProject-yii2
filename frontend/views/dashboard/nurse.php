<!-- views/dashboard/nurse.php -->
<?php
$this->title = 'Nurse Station';
$this->params['sidebar'] = 'nurse-sidebar';

// Example counters (could be fetched from DB/controller)
$newChats = $this->params['newChats'] ?? 3;
$newNotifications = $this->params['newNotifications'] ?? 2;
?>

<!-- Top Bar with Chats / Notifications -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-user-nurse"></i> Nurse Dashboard</h3>

    <div class="d-flex align-items-center">
        <!-- Notifications -->
        <div class="dropdown me-3">
            <a class="btn btn-light position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <?php if ($newNotifications > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $newNotifications ?>
                    </span>
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
                <li><h6 class="dropdown-header">Notifications</h6></li>
                <li><a class="dropdown-item" href="#">New lab report available</a></li>
                <li><a class="dropdown-item" href="#">Patient discharge scheduled</a></li>
                <li><a class="dropdown-item text-primary" href="#">View all</a></li>
            </ul>
        </div>

        <!-- Chats -->
        <div class="dropdown">
            <a class="btn btn-light position-relative" href="#" id="chatDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-comments"></i>
                <?php if ($newChats > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                        <?= $newChats ?>
                    </span>
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chatDropdown">
                <li><h6 class="dropdown-header">Chats</h6></li>
                <li><a class="dropdown-item" href="#">Dr. Smith: "Update me on Bed 3"</a></li>
                <li><a class="dropdown-item" href="#">Lab: "Results uploaded"</a></li>
                <li><a class="dropdown-item text-primary" href="#">Open Chat Panel</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="fas fa-procedures fa-2x text-primary mb-2"></i>
                <h5><?= count($beds) ?> Beds</h5>
                <small class="text-muted">Total capacity</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="fas fa-user-injured fa-2x text-danger mb-2"></i>
                <h5><?= count($criticalPatients) ?> Critical</h5>
                <small class="text-muted">Patients requiring attention</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="fas fa-pills fa-2x text-success mb-2"></i>
                <h5><?= $pendingMeds ?? 12 ?> Pending</h5>
                <small class="text-muted">Medications to administer</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="fas fa-calendar-check fa-2x text-warning mb-2"></i>
                <h5><?= $upcomingAppointments ?? 5 ?></h5>
                <small class="text-muted">Upcoming Admissions</small>
            </div>
        </div>
    </div>
</div>

<!-- Ward Bed Status -->
<h5 class="mb-3"><i class="fas fa-procedures"></i>  <?= $ward ?> — Bed Status</h5>
<div class="row g-3 mb-4">
    <?php foreach ($beds as $bed): ?>
        <div class="col-md-2">
            <div class="card <?= $bed['occupied'] ? 'border-primary' : 'border-secondary' ?> text-center shadow-sm">
                <div class="card-body p-2">
                    <div class="status-dot <?= $bed['critical'] ? 'status-critical' : 'status-stable' ?>"></div>
                    <strong>Bed <?= $bed['number'] ?></strong>
                    <div><?= $bed['occupied'] ? $bed['patient_name'] : 'Vacant' ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Tasks & Critical Patients -->
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">📋 Shift Tasks</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Administer meds to Room 305</span>
                    <input type="checkbox">
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Check vitals — Bed 4</span>
                    <input type="checkbox">
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">⚠️ Critical Patients</div>
            <div class="list-group">
                <?php foreach ($criticalPatients as $p): ?>
                    <a href="/nurse/vitals?patient=<?= $p->id ?>" 
                       class="list-group-item list-group-item-danger">
                        <?= $p->name ?> | Temp: <?= $p->temp ?>°C | BP: <?= $p->bp ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Reports Overview -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">📝 Reports & Documentation</div>
            <div class="card-body">
                <p>Latest nursing notes, shift summaries, and incident reports will appear here.</p>
                <a href="/nurse/reports" class="btn btn-sm btn-primary">View Reports</a>
            </div>
        </div>
    </div>
</div>
