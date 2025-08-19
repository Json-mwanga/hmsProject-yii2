<!-- views/layouts/lab-sidebar.php -->
<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i class="fas fa-microscope"></i> 🧫 <strong>LAB CENTER</strong>
    </h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Dashboard', 
                ['dashboard/lab'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-tests">
                <i class="fas fa-vial"></i> Lab Tests
            </a>
            <div class="collapse" id="menu-tests">
                <div class="ms-4 small">
                    <?= Html::a('CBC & LFT', ['lab/cbc'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Culture & Sensitivity', ['lab/culture'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-imaging">
                <i class="fas fa-x-ray"></i> Radiology
            </a>
            <div class="collapse" id="menu-imaging">
                <div class="ms-4 small">
                    <?= Html::a('X-Ray', ['lab/xray'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('CT & MRI', ['lab/ctscan'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-upload"></i> Upload Results', 
                ['lab/upload'], ['class' => 'nav-link text-light']) . badge($pendingUploads ?? 0) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-file-medical"></i> Reports', 
                ['lab/results'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-radiation"></i> Equipment Log', 
                ['lab/equipment'], ['class' => 'nav-link text-light']) ?>
        </li>
    </ul>
</div>