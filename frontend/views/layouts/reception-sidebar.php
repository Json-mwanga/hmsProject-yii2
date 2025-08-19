<!-- views/layouts/reception-sidebar.php -->
<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i class="fas fa-deskpro"></i> 📝 <strong>RECEPTION</strong>
    </h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Dashboard', 
                ['dashboard/reception'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-id-card"></i> Register Patient', 
                ['reception/register'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-sign-in-alt"></i> Check-In', 
                ['reception/checkin'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-search"></i> Patient Search', 
                ['reception/search'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-pay">
                <i class="fas fa-money-check-alt"></i> Pre-Payment
            </a>
            <div class="collapse" id="menu-pay">
                <div class="ms-4 small">
                    <?= Html::a('Cash Patients', ['finance/cash'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Insurance Verify', ['finance/insurance'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-qrcode"></i> Barcode Scanner', 
                ['reception/scan'], ['class' => 'nav-link text-light']) ?>
        </li>
    </ul>
</div>