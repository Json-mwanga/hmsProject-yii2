<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Patient;
use frontend\models\Doctor;
use yii\helpers\ArrayHelper;

// Fetch patients and active doctors
$patients = Patient::find()->all();
$doctors = Doctor::find()->where(['status' => 'active'])->all();
?>

<div class="appointment-form">

    <h3 style="margin-bottom: 20px;">📅 Book Appointment</h3>

    <?php $form = ActiveForm::begin(); ?>

    <!-- Patient -->
    <?= $form->field($model, 'patient_id')->dropDownList(
        ArrayHelper::map($patients, 'id', function($p) {
            return $p->registration_number . ' - ' . $p->full_name;
        }),
        ['prompt' => '-- Select Patient --']
    )->label('Patient') ?>

    <!-- Doctor -->
    <?= $form->field($model, 'doctor_id')->dropDownList(
        ArrayHelper::map($doctors, 'id', 'fullName'), // make sure 'fullName' is correct
        ['prompt' => '-- Select Doctor --']
    )->label('Doctor') ?>

    <!-- Purpose -->
    <?= $form->field($model, 'purpose')->textarea([
        'rows' => 3,
        'placeholder' => 'Enter purpose of appointment'
    ])->label('Purpose') ?>

    <!-- Appointment Date -->
    <?= $form->field($model, 'appointment_date')->input('datetime-local')->label('Appointment Date & Time') ?>

    <!-- Submit -->
    <div class="form-group" style="margin-top: 20px;">
        <?= Html::submitButton('Book Appointment', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
/* Add spacing between form fields */
.appointment-form .form-group {
    margin-bottom: 1.5rem;
}
</style>
