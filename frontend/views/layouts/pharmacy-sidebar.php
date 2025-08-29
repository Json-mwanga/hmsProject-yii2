<!-- views/layouts/pharmacy-sidebar.php -->
 <?php
// ✅ add this part at the top
use yii\helpers\Html;
use yii\helpers\Url;

// Helper: badge function
function badge($count) {
    return $count > 0 ? "<span class='badge bg-danger rounded-pill ms-2'>$count</span>" : '';
}

// Get data from params
$lowStockAlerts = $this->params['lowStockAlerts'] ?? 0;
?>
<div class="px-3 py-4">
    <h5 class="text-white mb-4">
        <i></i> 💊 <strong>PHARMACY</strong>
    </h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-home"></i> Dashboard', 
                ['dashboard/pharmacy'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-prescription-bottle"></i> Dispense Meds', 
                ['pharmacy/dispense'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-boxes"></i> Inventory', 
                ['pharmacy/stock'], ['class' => 'nav-link text-light']) . badge($lowStockCount ?? 0) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-exclamation-triangle"></i> Low Stock Alert', 
                ['pharmacy/alerts'], ['class' => 'nav-link text-light']) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-file-prescription"></i> Prescription Queue', 
                ['pharmacy/pending'], ['class' => 'nav-link text-light']) . badge($pendingPrescriptions ?? 0) ?>
        </li>

        <li class="nav-item mb-1">
            <?= Html::a('<i class="fas fa-truck"></i> Supplier Orders', 
                ['pharmacy/orders'], ['class' => 'nav-link text-light']) ?>
        </li>
    </ul>
</div>