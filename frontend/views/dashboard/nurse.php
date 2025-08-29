<!-- views/dashboard/nurse.php -->
<?php
$this->title = 'Nurse Station';
$this->params['sidebar'] = 'nurse-sidebar';
?>

<h3><i class="fas fa-procedures"></i> Ward <?= $ward ?> — Bed Status</h3>

<div class="row g-3 mb-4">
    <?php foreach ($beds as $bed): ?>
    <div class="col-md-2">
        <div class="card <?= $bed['occupied'] ? 'border-primary' : 'border-secondary' ?> text-center">
            <div class="card-body p-2">
                                <div class="status-dot <?= $bed['critical'] ? 'status-critical' : 'status-stable' ?>"></div>
                                <strong>Bed <?= $bed['number'] ?></strong>
                                <div><?= $bed['occupied'] ? $bed['patient_name'] : 'Vacant' ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
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
                        <div class="card">
                            <div class="card-header">⚠️ Critical Patients</div>
                            <!-- views/dashboard/nurse.php -->
<div class="list-group">
    <?php foreach ($criticalPatients as $p): ?>
        <a href="/nurse/vitals?patient=<?= $p->id ?>" class="list-group-item list-group-item-danger">
            <?= $p->name ?> | Temp: <?= $p->temp ?>°C | BP: <?= $p->bp ?>
        </a>
    <?php endforeach; ?>
</div>
                        </div>
                    </div>
                </div>