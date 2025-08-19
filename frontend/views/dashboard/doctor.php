<!-- views/dashboard/doctor.php -->
<?php
$this->title = 'Doctor Workstation';
$this->params['sidebar'] = 'doctor-sidebar';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-user-md"></i> Dr. <?= $doctor->first_name ?> — Today's Patients</h3>
    <button class="btn btn-outline-primary btn-sm" onclick="startConsult()">
        <i class="fas fa-stethoscope"></i> Start Consult
    </button>
</div>

<div class="row g-4">
    <!-- Patients to See -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-list"></i> Patients Awaiting Consultation
            </div>
            <div class="table-responsive">
                <table class="table">
                    <?php foreach ($awaitingPatients as $p): ?>
                    <tr class="clickable-row" data-href="/doctor/consult?patient=<?= $p['id'] ?>">
                        <td>
                            <strong><?= $p['name'] ?></strong> (<?= $p['age'] ?>, <?= $p['gender'] ?>)
                            <div class="text-muted small"><?= $p['chief_complaint'] ?></div>
                        </td>
                        <td>
                            <span class="badge bg-<?= $p['priority'] === 'urgent' ? 'danger' : 'secondary' ?> badge-priority">
                                <?= ucfirst($p['priority']) ?>
                            </span>
                        </td>
                        <td><?= date('H:i', $p['check_in']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Consults -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">🕒 Recent Consultations</div>
            <div class="list-group list-group-flush">
                <?php foreach ($recentConsults as $c): ?>
                <a href="/doctor/view?id=<?= $c['id'] ?>" class="list-group-item">
                    <strong><?= $c['patient_name'] ?></strong><br>
                    <small><?= substr($c['diagnosis'], 0, 60) ?>...</small>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center py-3" style="cursor: pointer" onclick="window.location='/doctor/lab-requests'">
            <i class="fas fa-flask fa-2x text-danger"></i>
            <h6 class="mt-2">Order Lab</h6>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-3" style="cursor: pointer" onclick="window.location='/doctor/prescribe'">
            <i class="fas fa-prescription fa-2x text-primary"></i>
            <h6 class="mt-2">Prescribe</h6>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-3" style="cursor: pointer" onclick="window.location='/doctor/records'">
            <i class="fas fa-book-medical fa-2x text-success"></i>
            <h6 class="mt-2">Records</h6>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center py-3" style="cursor: pointer" onclick="window.location='/doctor/schedule'">
            <i class="fas fa-calendar-alt fa-2x text-warning"></i>
            <h6 class="mt-2">Schedule</h6>
        </div>
    </div>
</div>