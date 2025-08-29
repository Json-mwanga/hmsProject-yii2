<!-- views/layouts/finance-sidebar.php -->
 <?php
use yii\helpers\Html;

function badge($count) {
    return $count > 0 ? "<span class='badge bg-danger rounded-pill ms-2'>$count</span>" : '';
}

$pendingPayments = $this->params['pendingPayments'] ?? 0;
?>

<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i ></i> 💰 <strong>FINANCE</strong>
    </h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Dashboard', 
                ['dashboard/finance'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-file-invoice"></i> Generate Bill', 
                ['finance/bill'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-cash-register"></i> Process Payment', 
                ['finance/pay'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-barcode"></i> Control Numbers', 
                ['finance/controls'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-credit-card"></i> Digital Payments', 
                ['finance/digital'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link text-light dropdown-toggle" data-bs-toggle="collapse" href="#menu-reports">
                <i class="fas fa-chart-pie"></i> Reports
            </a>
            <div class="collapse" id="menu-reports">
                <div class="ms-4 small">
                    <?= Html::a('Daily Revenue', ['report/finance'], ['class' => 'd-block text-secondary mb-1']) ?>
                    <?= Html::a('Insurance Claims', ['finance/claims'], ['class' => 'd-block text-secondary mb-1']) ?>
                </div>
            </div>
        </li>
    </ul>
</div>