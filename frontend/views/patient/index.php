<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'All Patients';
?>

<div class="container mt-4">
    <h4>📋 All Registered Patients</h4>

    <?php if (empty($patients)): ?>
        <div class="alert alert-info">No patients registered yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Reg No</th>
                        <th>Patient Name</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Region</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $p): ?>
                        <tr>
                            <td><?= Html::encode($p->registration_number) ?></td>
                            <td>
                                <?= Html::encode("{$p->first_name} {$p->middle_name} {$p->last_name}") ?>
                            </td>
                            <td><?= Yii::$app->formatter->asDate($p->date_of_birth) ?></td>
                            <td><?= Html::encode($p->gender) ?></td>
                            <td><?= Html::encode($p->region) ?></td>
                            <td><?= Yii::$app->formatter->asDate($p->registration_date) ?></td>
                            <td>
                                <?= Html::a('👁️ View', ['view', 'id' => $p->id], ['class' => 'btn btn-sm btn-info']) ?>
                                <?= Html::a('✏️ Edit', ['update', 'id' => $p->id], ['class' => 'btn btn-sm btn-warning']) ?>
                                <?= Html::a('🗑️ Delete', ['delete', 'id' => $p->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this patient?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <!-- <?= Html::a('📥 Export All to PDF', ['pdf-all'], ['class' => 'btn btn-success mt-3']) ?> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>