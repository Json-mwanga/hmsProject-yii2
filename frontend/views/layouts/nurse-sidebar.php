<!-- views/layouts/nurse-sidebar.php -->
<?php
use yii\helpers\Html;
use yii\helpers\Url;

// Helper: badge function
function badge($count) {
    return $count > 0 ? "<span class='badge bg-danger rounded-pill ms-2'>$count</span>" : '';
}

// Get data from params
$criticalAlerts = $this->params['criticalAlerts'] ?? 0;
?>

<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i class="fas fa-notes-medical"></i> <strong>NURSE STATION</strong>
    </h5>

    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Dashboard', 
                ['dashboard/nurse'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Clinical Management -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-clinical">
                <i class="fas fa-stethoscope"></i> Clinical Management
            </a>
            <div class="collapse" id="menu-clinical">
                <div class="ms-4 small">
                    <?= Html::a('Medication', ['nurse/meds'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Patient History', ['nurse/history'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Vitals', ['nurse/vitals'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Allergies & Immunization', ['nurse/allergies'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Nurse Assessment (Independent) -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-nurse-assessment">
                <i class="fas fa-clipboard"></i> Nurse Assessment
            </a>
            <div class="collapse" id="menu-nurse-assessment">
                <div class="ms-4 small">
                    <?= Html::a('Advice', ['nurse/advice'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Consultation', ['nurse/consultation'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Observations', ['nurse/observations'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- In-Patient Management -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-inpatient">
                <i class="fas fa-hospital-user"></i> In-Patient Management
            </a>
            <div class="collapse" id="menu-inpatient">
                <div class="ms-4 small">
                    <?= Html::a('Admissions', ['nurse/admissions'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <div class="ms-3 mt-2">
                        <span class="text-secondary fw-bold">Wards</span>
                        <?= Html::a('Bed Status', ['nurse/ward'], ['class' => 'd-block text-secondary mb-1']) ?>
                        <?= Html::a('Patient Status & Reports', ['nurse/patient-status'], ['class' => 'd-block text-secondary mb-1']) ?>
                        <?= Html::a('Medications', ['nurse/ward-meds'], ['class' => 'd-block text-secondary mb-1']) ?>
                    </div>
                    <?= Html::a('Critical Patients', ['nurse/critical'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('History', ['nurse/inpatient-history'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Shift Management -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-shift">
                <i class="fas fa-user-clock"></i> Shift Management
            </a>
            <div class="collapse" id="menu-shift">
                <div class="ms-4 small">
                    <?= Html::a('Shift Tasks', ['nurse/tasks'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Duty Roster', ['nurse/roster'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Handover Notes', ['nurse/handover'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Shift Report', ['nurse/shift-report'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Inventory -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-inventory">
                <i class="fas fa-boxes"></i> Inventory
            </a>
            <div class="collapse" id="menu-inventory">
                <div class="ms-4 small">
                    <?= Html::a('Track Supplies', ['nurse/supplies'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Supply Request', ['nurse/supply-request'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Reports & Documentation -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-file-medical-alt"></i> Reports & Documentation', 
                ['nurse/reports'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Critical Alerts -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-exclamation-triangle"></i> Critical Alerts ' . badge($criticalAlerts), 
                ['nurse/alerts'], ['class' => 'nav-link text-light fw-bold text-danger']) ?>
        </li>

    </ul>
</div>
