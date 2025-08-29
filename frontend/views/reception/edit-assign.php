<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Edit Doctor Assignment";
?>

<div class="container mt-4">
    <h4>Edit Doctor Assignment for <?= Html::encode($queue->patient->full_name) ?></h4>

    <!-- Flash messages -->
    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <div class="alert alert-<?= $type === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>

    <form method="post" action="<?= Url::to(['reception/edit-assign', 'id' => $queue->id]) ?>">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>

        <div class="mb-3">
            <label class="form-label">Select Doctor</label>
            <select name="doctor_id" class="form-select" required>
                <option value="">-- choose doctor --</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= $doctor->id ?>" <?= $queue->doctor_id == $doctor->id ? 'selected' : '' ?>>
                        <?= Html::encode($doctor->fullName) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Update Assignment</button>
            <a href="<?= Url::to(['reception/patient-queue']) ?>" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
