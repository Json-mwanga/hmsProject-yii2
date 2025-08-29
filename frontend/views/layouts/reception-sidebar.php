<!-- views/layouts/reception-sidebar.php -->
<?php
use yii\helpers\Html;
?>

<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        📝<strong>RECEPTION</strong>
    </h5>

    <ul class="nav flex-column">

        <!-- Register Patient -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-id-card"></i> Register Patient', 
                ['reception/patient-register'], 
                ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- View Patients -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-users"></i> View Patients',
                ['patient/index'],
                ['class' => 'nav-link text-light']
            ) ?>
        </li>

        <!-- Live Patient Queue -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-stream"></i> Live Patient Queue', 
                ['reception/patient-queue'], 
                ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Appointment Management -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-appointment">
                <i class="fas fa-calendar-alt"></i> Appointments
            </a>
            <div class="collapse" id="menu-appointment">
                <div class="ms-4 small">
                    <?= Html::a('Book Appointment', ['appointment/book'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Bookings', ['appointment/index'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Visitors -->
        <!-- <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-visitors">
                <i class="fas fa-user-friends"></i> Visitors
            </a>
            <div class="collapse" id="menu-visitors">
                <div class="ms-4 small">
                    <?= Html::a('Visitor Registration', ['visitor/register'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('View Visitors', ['visitor/index'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li> -->

        <!-- Referral Management -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-referrals">
                <i class="fas fa-share-alt"></i> Referral Management
            </a>
            <div class="collapse" id="menu-referrals">
                <div class="ms-4 small">
                    <?= Html::a('Internal Referrals', ['referral/internal'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('External Referrals', ['referral/external'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Reports & Logs -->
        <!-- <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-file-alt"></i> Reports & Logs', 
                ['reports/index'], 
                ['class' => 'nav-link text-light']) ?>
        </li> -->

    </ul>
</div>
