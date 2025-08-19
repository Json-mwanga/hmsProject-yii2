<!-- views/layouts/doctor-sidebar.php -->
<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i class="fas fa-user-md"></i> 👨‍⚕️ <strong>DOCTOR HUB</strong>
    </h5>

    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Home', 
                ['dashboard/doctor'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Patients -->
        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-patients">
                <i class="fas fa-procedures"></i> My Patients
            </a>
            <div class="collapse" id="menu-patients">
                <div class="ms-4 small">
                    <?= Html::a('Today\'s List', ['doctor/today'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Chronic Cases', ['doctor/chronic'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Follow-Ups', ['doctor/followup'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <!-- Consultation -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-stethoscope"></i> New Consult', 
                ['doctor/consult'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Lab -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-flask"></i> Lab Requests', 
                ['lab/orders'], ['class' => 'nav-link text-light']) . badge($pendingLabs ?? 0) ?>
        </li>

        <!-- Pharmacy -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-prescription"></i> Prescriptions', 
                ['pharmacy/prescribe'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Records -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-book-medical"></i> EHR Access', 
                ['record/index'], ['class' => 'nav-link text-light']) ?>
        </li>

        <!-- Schedule -->
        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-calendar-check"></i> My Schedule', 
                ['doctor/schedule'], ['class' => 'nav-link text-light']) ?>
        </li>
    </ul>
</div>