<?php
use yii\helpers\Html;
use yii\helpers\Url;


use frontend\models\MenuItem;

$menuItems = MenuItem::getMenuByRole(Yii::$app->user->identity->role);
foreach ($menuItems as $item) {
    echo '<li>' . Html::a($item->label, [$item->url]) . '</li>';
}


/* @var $this \yii\web\View */
/* @var $content string */
/* @var $role string */

$role = Yii::$app->user->identity->role;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="<?= Url::to('@web/css/dashboard.css') ?>">
</head>
<body>
<?php $this->beginBody() ?>

<div class="dashboard-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <?= Html::img('@web/assets/images/logo.png', ['alt' => 'HMS Logo']) ?>
        </div>
        <ul class="menu">
            <?php if($role === 'admin'): ?>
                <li><?= Html::a('Admin Home', ['dashboard/admin']) ?></li>
                <li><?= Html::a('Manage Users', ['user/index']) ?></li>
                <li><?= Html::a('Reports', ['reports/index']) ?></li>
            <?php elseif($role === 'doctor'): ?>
                <li><?= Html::a('My Patients', ['doctor/patients']) ?></li>
                <li><?= Html::a('Appointments', ['doctor/appointments']) ?></li>
            <?php elseif($role === 'nurse'): ?>
                <li><?= Html::a('Patient Monitoring', ['nurse/patients']) ?></li>
            <?php elseif($role === 'pharmacy'): ?>
                <li><?= Html::a('Medicine Stock', ['pharmacy/stock']) ?></li>
                <li><?= Html::a('Prescriptions', ['pharmacy/prescriptions']) ?></li>
            <?php elseif($role === 'finance'): ?>
                <li><?= Html::a('Billing', ['finance/bills']) ?></li>
                <li><?= Html::a('Reports', ['finance/reports']) ?></li>
            <?php elseif($role === 'hr'): ?>
                <li><?= Html::a('Staff Management', ['hr/staff']) ?></li>
            <?php elseif($role === 'reception'): ?>
                <li><?= Html::a('Appointments', ['reception/appointments']) ?></li>
                <li><?= Html::a('Patient Registration', ['reception/register']) ?></li>
            <?php elseif($role === 'lab'): ?>
                <li><?= Html::a('Lab Tests', ['lab/tests']) ?></li>
                <li><?= Html::a('Results', ['lab/results']) ?></li>
            <?php endif; ?>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="dashboard-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="user-menu">
                <?= Html::encode(Yii::$app->user->identity->email) ?>
                <?= Html::a('Logout', ['site/logout'], ['data-method' => 'post']) ?>
            </div>
        </header>

        <!-- Content -->
        <section class="dashboard-body">
            <?= $content ?>
        </section>

        <!-- Footer -->
        <footer class="dashboard-footer">
            <p>&copy; <?= date('Y') ?> HMS System. All rights reserved.</p>
        </footer>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
