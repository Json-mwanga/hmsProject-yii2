<!-- views/layouts/nurse-sidebar.php -->
<?php
// Add these at the top
use yii\helpers\Html;
use yii\helpers\Url;

// Helper: badge function
function badge($count) {
    return $count > 0 ? "<span class='badge bg-danger rounded-pill ms-2'>$count</span>" : '';
}

// Get data from params
$criticalAlerts = $this->params['criticalAlerts'] ?? 0;
$pendingTasks = $this->params['pendingTasks'] ?? 0;
?>

<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i class="fas fa-notes-medical"></i> <strong>NURSE STATION</strong>
    </h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Dashboard', 
                ['dashboard/nurse'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-ward">
                <i class="fas fa-hospital-symbol"></i> My Ward
            </a>
            <div class="collapse" id="menu-ward">
                <div class="ms-4 small">
                    <?= Html::a('Bed Status', ['nurse/ward'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Critical Patients', ['nurse/critical'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-heartbeat"></i> Vital Signs', 
                ['nurse/vitals'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-syringe"></i> Medication Admin', 
                ['nurse/meds'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-clipboard"></i> Shift Report', 
                ['nurse/report'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-user-injured"></i> Patient History', 
                ['nurse/history'], ['class' => 'nav-link text-light']) ?>
        </li>
    </ul>
</div>