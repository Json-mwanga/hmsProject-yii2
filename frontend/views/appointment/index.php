<?php
use yii\helpers\Html;
?>
<h3>All Appointments</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($appointments as $app): ?>
        <tr>
            <td><?= Html::encode($app->id) ?></td>
            <td><?= Html::encode($app->patient->full_name) ?></td>
            <td><?= Html::encode($app->doctor->fullName) ?></td>
            <td><?= Html::encode($app->appointment_date) ?></td>
            <td><?= Html::encode($app->status) ?></td>
            <td>
                <?= Html::a('Confirm', ['appointment/update-status', 'id' => $app->id, 'status' => 'confirmed'], ['class'=>'btn btn-sm btn-primary']) ?>
                <?= Html::a('Complete', ['appointment/update-status', 'id' => $app->id, 'status' => 'completed'], ['class'=>'btn btn-sm btn-success']) ?>
                <?= Html::a('Cancel', ['appointment/update-status', 'id' => $app->id, 'status' => 'cancelled'], ['class'=>'btn btn-sm btn-danger']) ?>
                 <!-- Delete button -->
    <?= Html::a('Delete', ['appointment/delete', 'id' => $app->id], [
        'class' => 'btn btn-sm btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this appointment permanently?',
            'method' => 'post', // important for safety
        ],
    ]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
