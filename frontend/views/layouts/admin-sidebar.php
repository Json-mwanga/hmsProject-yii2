<!-- views/layouts/admin-sidebar.php -->
 <?php
// Add this at the top of the file
use yii\helpers\Html;
use yii\helpers\Url;

// Helper function: badge
function badge($count) {
    return $count > 0 
        ? "<span class='badge bg-danger rounded-pill ms-2'>$count</span>" 
        : '';
}
?>
<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i class="fas fa-shield-alt"></i> <strong>ADMIN PANEL</strong>
    </h5>

    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-tachometer-alt"></i> Dashboard', 
                ['dashboard/admin'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Users -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-users">
                <i class="fas fa-users-cog"></i> User Management
            </a>
            <div class="collapse" id="menu-users">
                <div class="ms-4 small">
                    <?= Html::a('All Users', ['user/index'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Roles & Permissions', ['rbac/index'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Patients -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-user-injured"></i> Patient Master', 
                ['patient/index'], ['class' => 'nav-link text-light']) . badge(0) ?>
        </li>

        <!-- Departments -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-clinic-medical"></i> Departments', 
                ['department/index'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- System Health -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-system">
                <i class="fas fa-server"></i> System
            </a>
            <div class="collapse" id="menu-system">
                <div class="ms-4 small">
                    <?= Html::a('Logs', ['site/logs'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Backups', ['site/backup'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('API Status', ['site/api-status'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Reports -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-reports">
                <i class="fas fa-chart-line"></i> Reports
            </a>
            <div class="collapse" id="menu-reports">
                <div class="ms-4 small">
                    <?= Html::a('Daily Summary', ['report/daily'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Revenue', ['report/finance'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Staff Performance', ['report/hr'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>
    </ul>
</div>