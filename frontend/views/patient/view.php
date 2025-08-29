<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Patient */

$this->title = 'Patient Profile: ' . $model->first_name . ' ' . $model->last_name;
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'registration_number',
                    'registration_date',
                    [
                        'label' => 'Full Name',
                        'value' => $model->first_name . ' ' . ($model->middle_name ?? '') . ' ' . $model->last_name,
                    ],
                    'date_of_birth',
                    'age',
                    'gender',
                    'marital_status',
                    'occupation',
                    'religion',
                    'citizenship',
                    'address',
                    'country',
                    'city',
                    'ward',
                    'district',
                    'region',
                    'payer_type',
                ],
            ]) ?>
     <!-- <?= Html::a('📄 Export to PDF', ['pdf', 'id' => $model->id], [
        'class' => 'btn btn-primary',
        'target' => '_blank'
        ]) ?> -->
    <?= Html::a('✏️ Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>

            <div class="mt-3">
    <?= Html::a('⬅️ Back to List', ['patient/index'], ['class' => 'btn btn-primary']) ?>

    <div class="btn-group ml-2">
        <?= Html::button('⚙️ Options', [
            'class' => 'btn btn-info dropdown-toggle',
            'data-toggle' => 'dropdown'
        ]) ?>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="javascript:printRegistrationCard();">
            🖨️ Print Registration Card
            </a>
            <a class="dropdown-item" href="javascript:printPatientInfo();">
            🖨️ Print Patient Info
            </a>
        </div>
        </div>
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
    <div style="font-family:Arial; padding:20px;">
        <h2>Patient Full Information</h2>
        <p><strong>Registration Number:</strong> <span id="full-regno"></span></p>
        <p><strong>Name:</strong> <span id="full-name"></span></p>
        <p><strong>Date of Birth:</strong> <span id="full-dob"></span></p>
        <p><strong>Age:</strong> <span id="full-age"></span></p>
        <p><strong>Gender:</strong> <span id="full-gender"></span></p>
        <p><strong>Address:</strong> <span id="full-address"></span></p>
        <p><strong>Region:</strong> <span id="full-region"></span></p>
        <p><strong>Payer:</strong> <span id="full-payer"></span></p>
    </div>
</div>

<?php
$this->registerJs(<<<JS
function printRegistrationCard() {
    const name = "$model->first_name $model->middle_name $model->last_name";
    const regNo = "$model->registration_number";
    const dob = "$model->date_of_birth";
    const gender = "$model->gender";

    document.getElementById('print-name').textContent = name;
    document.getElementById('print-regno').textContent = regNo;
    document.getElementById('print-dob').textContent = dob;
    document.getElementById('print-gender').textContent = gender;
    document.getElementById('print-barcode').src = '/index.php?r=site/barcode&text=' + encodeURIComponent(regNo);

    const w = window.open('', '', 'height=400,width=300');
    w.document.write('<html><head><title>Card</title></head><body>');
    w.document.write(document.getElementById('print-registration-card').innerHTML);
    w.document.write('</body></html>');
    w.document.close();
    w.print();
}

function printPatientInfo() {
    // Fill patient info
    document.getElementById('full-regno').textContent = "$model->registration_number";
    document.getElementById('full-name').textContent = "$model->first_name $model->middle_name $model->last_name";
    document.getElementById('full-dob').textContent = "$model->date_of_birth";
    document.getElementById('full-age').textContent = "$model->age";
    document.getElementById('full-gender').textContent = "$model->gender";
    document.getElementById('full-address').textContent = "$model->address, $model->ward, $model->district, $model->region";
    document.getElementById('full-region').textContent = "$model->region";
    document.getElementById('full-payer').textContent = "$model->payer_type".replace('_', ' ').toUpperCase();

    const w = window.open('', '', 'height=500,width=600');
    w.document.write('<html><head><title>Patient Info</title></head><body>');
    w.document.write(document.getElementById('print-patient-info').innerHTML);
    w.document.write('</body></html>');
    w.document.close();
    w.print();
}
JS
);
?>

</div>

<!-- Reuse existing print script -->
<script>
function printRegistrationCard() {
    const name = "<?= Html::encode($model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name) ?>";
    const regNo = "<?= $model->registration_number ?>";
    const dob = "<?= $model->date_of_birth ?>";
    const gender = "<?= $model->gender ?>";

    document.getElementById('print-name').textContent = name;
    document.getElementById('print-regno').textContent = regNo;
    document.getElementById('print-dob').textContent = dob;
    document.getElementById('print-gender').textContent = gender;
    document.getElementById('print-barcode').src = '/index.php?r=site/barcode&text=' + encodeURIComponent(regNo);

    const printWindow = window.open('', '', 'height=400,width=300');
    printWindow.document.write('<html><head><title>Registration Card</title></head><body>');
    printWindow.document.write(document.getElementById('print-registration-card').innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>