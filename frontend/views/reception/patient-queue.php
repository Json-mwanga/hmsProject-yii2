<?php
use frontend\models\Patient;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>📋 Live Patient Queue</h4>
    <!-- Add Button -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Add</button>
</div>

<!-- Flash messages -->
<?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
    <div class="alert alert-<?= $type === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
        <?= $message ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endforeach; ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Registration Number</th>
            <th>Full Name</th>
            <th>Type</th>
            <th>Check-In</th>
            <th>Assign</th>
            <!-- 🔽 New: Delete Column -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($queue as $q): ?>
            <tr>
                <td><?= Html::encode($q->patient->registration_number) ?></td>
                <td><?= Html::encode($q->patient->full_name) ?></td>
                <td><?= Html::encode($q->patient->payer_type) ?></td>
                <td><?= Html::encode($q->check_in_time) ?></td>
                <td>
                    <?php if ($q->status !== 'assigned'): ?>
                        <form method="post" action="<?= Url::to(['reception/assign', 'id' => $q->id]) ?>">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <?= Html::dropDownList(
                                'doctor_id',
                                null,
                                \yii\helpers\ArrayHelper::map(
                                    \frontend\models\Doctor::find()->where(['status' => 'active'])->all(),
                                    'id',
                                    'fullName'
                                ),
                                [
                                    'prompt' => '-- Select Doctor --',
                                    'class' => 'form-select mb-1',
                                    'required' => true
                                ]
                            ) ?>
                            <button type="submit" class="btn btn-success btn-sm">Assign</button>
                        </form>
                    <?php else: ?>
                        <?= Html::encode($q->doctor ? $q->doctor->fullName : '-') ?>
                        <a href="<?= Url::to(['reception/edit-assign', 'id' => $q->id]) ?>" class="btn btn-warning btn-sm ms-2">Edit</a>
                    <?php endif; ?>
                </td>
                <!-- 🔽 Delete Button -->
                <td>
                    <form method="post" 
                          action="<?= Url::to(['reception/remove-from-queue', 'id' => $q->id]) ?>" 
                          style="display: inline;" 
                          onsubmit="return confirm('Are you sure you want to remove this patient from the queue?');">
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal for +Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Patient to Queue</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <!-- Dropdown to pick from registered patients -->
        <form method="get" action="<?= Url::to(['reception/add-to-queue']) ?>">
            <div class="mb-3">
                <label class="form-label">Select Patient</label>
                <select name="patient_id" class="form-select" required>
                    <option value="">-- choose patient --</option>
                    <?php foreach (Patient::find()->all() as $p): ?>
                        <option value="<?= $p->id ?>">
                            <?= Html::encode($p->registration_number . " - " . $p->full_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>

      </div>
    </div>
  </div>
</div>