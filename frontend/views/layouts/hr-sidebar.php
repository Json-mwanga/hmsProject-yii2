<!-- views/layouts/hr-sidebar.php -->
<?php
use yii\helpers\Html;

function badge($count) {
    return $count > 0 ? "<span class='badge bg-danger rounded-pill ms-2'>$count</span>" : '';
}

$pendingApprovals = $this->params['pendingApprovals'] ?? 0;
?>

<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i class="fas fa-user-tie"></i>  <strong>HR DEPARTMENT</strong>
    </h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Dashboard', 
                ['dashboard/hr'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-user-plus"></i> Register Staff', 
                ['hr/register'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-users"></i> Staff Directory', 
                ['hr/list'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-attendance">
                <i class="fas fa-calendar-alt"></i> Attendance
            </a>
            <div class="collapse" id="menu-attendance">
                <div class="ms-4 small">
                    <?= Html::a('Daily Log', ['hr/attendance'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Leave Requests', ['hr/leave'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-wallet"></i> Payroll', 
                ['hr/payroll'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-chalkboard-teacher"></i> Training', 
                ['hr/training'], ['class' => 'nav-link text-light']) ?>
        </li>
    </ul>
</div>