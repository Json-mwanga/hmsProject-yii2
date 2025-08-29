<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Patient */

$this->title = 'Edit Patient: ' . $model->first_name . ' ' . $model->last_name;
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'registration_number')->textInput(['readonly' => true]) ?>
            <?= $form->field($model, 'registration_date')->textInput(['type' => 'date']) ?>

            <h6>Personal Details</h6>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'first_name')->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'middle_name')->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'last_name')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'date_of_birth')->textInput(['type' => 'date']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'age')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'gender')->dropDownList([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other'
                    ], ['prompt' => 'Select']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'marital_status')->dropDownList([
                        'Single' => 'Single',
                        'Married' => 'Married',
                        'Divorced' => 'Divorced',
                        'Widowed' => 'Widowed'
                    ], ['prompt' => 'Select']) ?>
                </div>
            </div>

            <?= $form->field($model, 'occupation')->textInput() ?>
            <?= $form->field($model, 'religion')->dropDownList([
                'Christianity' => 'Christianity',
                'Islam' => 'Islam',
                'Hinduism' => 'Hinduism',
                'Buddhism' => 'Buddhism',
                'Traditional African' => 'Traditional African',
                'Atheist' => 'Atheist',
                'Agnostic' => 'Agnostic',
                'Other' => 'Other'
            ], ['prompt' => 'Select']) ?>

            <h6>Address</h6>
            <?= $form->field($model, 'address')->textInput() ?>
            <?= $form->field($model, 'country')->textInput(['value' => 'Tanzania', 'readonly' => true]) ?>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'ward')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'district')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'region')->dropDownList([
                        'Arusha' => 'Arusha',
                        'Dar es Salaam' => 'Dar es Salaam',
                        'Dodoma' => 'Dodoma',
                        'Geita' => 'Geita',
                        'Iringa' => 'Iringa',
                        'Kagera' => 'Kagera',
                        'Katavi' => 'Katavi',
                        'Kigoma' => 'Kigoma',
                        'Kilimanjaro' => 'Kilimanjaro',
                        'Lindi' => 'Lindi',
                        'Manyara' => 'Manyara',
                        'Mara' => 'Mara',
                        'Mbeya' => 'Mbeya',
                        'Morogoro' => 'Morogoro',
                        'Mtwara' => 'Mtwara',
                        'Mwanza' => 'Mwanza',
                        'Njombe' => 'Njombe',
                        'Pwani' => 'Pwani',
                        'Rukwa' => 'Rukwa',
                        'Ruvuma' => 'Ruvuma',
                        'Shinyanga' => 'Shinyanga',
                        'Simiyu' => 'Simiyu',
                        'Singida' => 'Singida',
                        'Tabora' => 'Tabora',
                        'Tanga' => 'Tanga',
                        'Zanzibar Central/South' => 'Zanzibar Central/South',
                        'Zanzibar North' => 'Zanzibar North',
                        'Zanzibar Urban/West' => 'Zanzibar Urban/West',
                        'Songwe' => 'Songwe',
                        'Kaskazini Pemba' => 'Kaskazini Pemba',
                        'Kusini Pemba' => 'Kusini Pemba',
                    ], ['prompt' => 'Select Region']) ?>
                </div>
            </div>

            <?= $form->field($model, 'payer_type')->radioList([
                'private_cash' => 'Private Cash',
                'nhif' => 'NHIF',
                'insurance' => 'Private/Company Insurance'
            ]) ?>

            <div class="form-group mt-3">
                <?= Html::a('❌ Cancel', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton('💾 Save Changes', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
document.getElementById('patient-date_of_birth').addEventListener('change', function () {
    const dob = new Date(this.value);
    if (isNaN(dob)) return;
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
    document.getElementById('patient-age').value = age;
});
</script>