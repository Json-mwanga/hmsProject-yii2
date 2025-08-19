<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;

$this->title = 'Dashboard Chooser';
?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="text-center">
        <h4 class="mb-4 text-dark">Dev Superuser: Choose a Dashboard</h4>

        <div class="d-flex flex-column align-items-center gap-3">
            <?= Html::a(
                '<i class="bi bi-person-badge" style="font-size: 24px; color: #6f42c1;"></i><span class="d-block mt-1">Admin</span>',
                ['dashboard/admin'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>

            <?= Html::a(
                '<i class="bi bi-plus-square" style="font-size: 24px; color: #0d6efd;"></i><span class="d-block mt-1">Doctor</span>',
                ['dashboard/doctor'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>

            <?= Html::a(
                '<i class="bi bi-person" style="font-size: 24px; color: #198754;"></i><span class="d-block mt-1">Nurse</span>',
                ['dashboard/nurse'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>

            <?= Html::a(
                '<i class="bi bi-person-bounding-box" style="font-size: 24px; color: #fd7e14;"></i><span class="d-block mt-1">Reception</span>',
                ['dashboard/reception'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>

            <?= Html::a(
                '<i class="bi bi-droplet" style="font-size: 24px; color: #dc3545;"></i><span class="d-block mt-1">Lab</span>',
                ['dashboard/lab'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>

            <?= Html::a(
                '<i class="bi bi-capsule" style="font-size: 24px; color: #9c27b0;"></i><span class="d-block mt-1">Pharmacy</span>',
                ['dashboard/pharmacy'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>

            <?= Html::a(
                '<i class="bi bi-bank" style="font-size: 24px; color: #20c997;"></i><span class="d-block mt-1">Finance</span>',
                ['dashboard/finance'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>

            <?= Html::a(
                '<i class="bi bi-people" style="font-size: 24px; color: #fd397a;"></i><span class="d-block mt-1">HR</span>',
                ['dashboard/hr'],
                ['class' => 'btn btn-light shadow-sm py-3 px-4', 'style' => 'width: 150px;']
            ) ?>
        </div>
    </div>
</div>

<?php
// Load Bootstrap Icons
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css');

// Custom styles
$this->registerCss("
    .btn-light {
        width: 150px;
        font-size: 14px;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: all 0.2s ease;
    }
    .btn-light:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
");
?>