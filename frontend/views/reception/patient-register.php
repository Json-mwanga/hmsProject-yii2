<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\Dropdown;

/* @var $this yii\web\View */
/* @var $model frontend\models\Patient */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Patient Registration';
?>

<div class="container-fluid mt-4">
    <?php
    if (Yii::$app->session->hasFlash('success')) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
            . Yii::$app->session->getFlash('success') .
            '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
    }
    ?>
    <div class="d-flex justify-content-end mb-3">
        <!-- Profile Button -->
        <!-- <?= Html::a('👤 Profile', ['profile/view'], ['class' => 'btn btn-outline-secondary btn-sm mx-1']) ?> -->

        <!-- Save Button -->
        <?= Html::button('💾 Save', ['type' => 'submit', 'form' => 'patient-form', 'class' => 'btn btn-success btn-sm mx-1']) ?>

        <!-- Options Dropdown -->
        <!-- <div class="btn-group mx-1">
            <?= Html::button('⚙️ Options', [
                'type' => 'button',
                'class' => 'btn btn-info btn-sm dropdown-toggle',
                'data-toggle' => 'dropdown'
            ]) ?>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="javascript:printRegistrationCard();">
                    🖨️ Print Registration Card (with Barcode)
                </a>
                <a class="dropdown-item" href="javascript:printPatientInfo();">
                    🖨️ Print Patient Info
                </a>
            </div> -->
        </div>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'patient-form']); ?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Patient Registration Form</h5>
        </div>
        <div class="card-body">

            <!-- Registration Info -->
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'registration_number')->textInput([
                        'readonly' => true,
                       
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'registration_date')->textInput([
                        'type' => 'date',
                        'value' => date('Y-m-d'),
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>

            <!-- Personal Details -->
            <h6 class="border-bottom pb-1 mt-4">Personal Details</h6>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'date_of_birth')->textInput([
                        'type' => 'date',
                        'class' => 'form-control',
                        'id' => 'dob-input'
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'age')->textInput([
                        'id' => 'age-input',
                        'readonly' => true
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'gender')->dropDownList([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other'
                    ], ['prompt' => 'Select Gender']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'marital_status')->dropDownList([
                        'Single' => 'Single',
                        'Married' => 'Married',
                        'Divorced' => 'Divorced',
                        'Widowed' => 'Widowed'
                    ], ['prompt' => 'Select Status']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'religion')->dropDownList([
                        'Christianity' => 'Christianity',
                        'Islam' => 'Islam',
                        'Hinduism' => 'Hinduism',
                        'Buddhism' => 'Buddhism',
                        'Traditional African Religions' => 'Traditional African',
                        'Atheist' => 'Atheist',
                        'Agnostic' => 'Agnostic',
                        'Other' => 'Other'
                    ], ['prompt' => 'Select Religion']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'citizenship')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <!-- Home Address -->
            <h6 class="border-bottom pb-1 mt-4">Home Address</h6>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'country')->textInput([
                        'value' => 'Tanzania',
                        'readonly' => true
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'ward')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>
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
            </div>

            <!-- Payer Information -->
            <h6 class="border-bottom pb-1 mt-4">Payer Information</h6>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'payer_type')->radioList([
                        'private_cash' => 'Private Cash',
                        'nhif' => 'NHIF',
                        'insurance' => 'Private/Company Insurance'
                    ], [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            return '<div class="form-check">' .
                                Html::radio($name, $checked, [
                                    'value' => $value,
                                    'class' => 'form-check-input'
                                ]) .
                                '<label class="form-check-label">' . $label . '</label></div>';
                        }
                    ]) ?>
                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<!-- Hidden Print Templates -->
<div id="print-registration-card" style="display:none;">
    <div style="text-align:center; font-family:Arial; padding:20px;">
        <h3>Hospital Name</h3>
        <p><strong>Patient Registration Card</strong></p>
        <p><strong>Name:</strong> <span id="print-name"></span></p>
        <p><strong>Reg No:</strong> <span id="print-regno"></span></p>
        <p><strong>DOB:</strong> <span id="print-dob"></span></p>
        <p><strong>Gender:</strong> <span id="print-gender"></span></p>
        <div style="margin:20px 0;">
            <img src="" alt="Barcode" style="width:200px;height:50px;" id="print-barcode">
        </div>
    </div>
</div>

<div id="print-patient-info" style="display:none;">
    <!-- Dynamic patient info print layout can be added later -->
</div>

<?php
$this->registerJs(<<<JS
// Auto-calculate age when DOB changes
document.getElementById('dob-input').addEventListener('change', function () {
    const dob = new Date(this.value);
    if (isNaN(dob)) return;

    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();
    
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    document.getElementById('age-input').value = age;
});

// Print Registration Card
function printRegistrationCard() {
    const firstName = document.getElementById('patient-first_name').value;
    const middleName = document.getElementById('patient-middle_name').value;
    const lastName = document.getElementById('patient-last_name').value;
    const fullName = firstName + ' ' + (middleName ? middleName + ' ' : '') + lastName;

    const regNo = document.getElementById('patient-registration_number').value;
    const dob = document.getElementById('patient-date_of_birth').value;
    const gender = document.getElementById('patient-gender').value;

    // Fill print template
    document.getElementById('print-name').textContent = fullName;
    document.getElementById('print-regno').textContent = regNo;
    document.getElementById('print-dob').textContent = dob;
    document.getElementById('print-gender').textContent = gender;

    // Update barcode (adjust URL if needed)
    const barcodeImg = document.getElementById('print-barcode');
    barcodeImg.src = '/index.php?r=site/barcode&text=' + encodeURIComponent(regNo);

    // Open print window
    const printWindow = window.open('', '', 'height=400,width=300');
    printWindow.document.write('<html><head><title>Registration Card</title></head><body>');
    printWindow.document.write(document.getElementById('print-registration-card').innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Placeholder for full patient info print
function printPatientInfo() {
    alert("Printing full patient information... (To be implemented)");
}
JS
);
?>