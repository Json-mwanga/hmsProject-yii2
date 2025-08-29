<!-- <?php
use yii\helpers\Html;
use yii\helpers\Url; // ✅ Add this line
?>

<?php
// Generate URL to patient profile
$text = Yii::$app->urlManager->createAbsoluteUrl(['patient/view', 'id' => $model->id]);

// QR code image URL
$qrUrl = Url::to(['site/qrcode', 'text' => $text], true);
?>

<div style="text-align:center; margin-top:30px;">
    <img src="<?= $qrUrl ?>" alt="QR Code" style="width:100px;height:100px;">
    <br>
    <small>Scan to view profile</small>
</div>

<table border="1" width="100%" style="border-collapse: collapse; font-size:14px;">
    <tr><th width="30%">Field</th><th>Information</th></tr>
    <tr><td><strong>Registration No</strong></td><td><?= $model->registration_number ?></td></tr>
    <tr><td><strong>Name</strong></td><td><?= "$model->first_name $model->middle_name $model->last_name" ?></td></tr>
    <tr><td><strong>Date of Birth</strong></td><td><?= Yii::$app->formatter->asDate($model->date_of_birth) ?></td></tr>
    <tr><td><strong>Age</strong></td><td><?= $model->age ?></td></tr>
    <tr><td><strong>Gender</strong></td><td><?= $model->gender ?></td></tr>
    <tr><td><strong>Marital Status</strong></td><td><?= $model->marital_status ?></td></tr>
    <tr><td><strong>Occupation</strong></td><td><?= $model->occupation ?></td></tr>
    <tr><td><strong>Religion</strong></td><td><?= $model->religion ?></td></tr>
    <tr><td><strong>Citizenship</strong></td><td><?= $model->citizenship ?></td></tr>
    <tr><td><strong>Address</strong></td><td><?= "$model->address, $model->ward, $model->district, $model->region, $model->country" ?></td></tr>
    <tr><td><strong>Payer</strong></td><td><?= ucfirst(str_replace('_', ' ', $model->payer_type)) ?></td></tr>
    <tr><td><strong>Registration Date</strong></td><td><?= Yii::$app->formatter->asDate($model->registration_date) ?></td></tr>
</table>

<div style="text-align:center; margin-top:30px;">
    <img src="data:image/png;base64,YOUR_BARCODE_BASE64" alt="Barcode" style="width:200px;height:50px;">
    <br>
    <small>Generated on <?= date('Y-m-d H:i:s') ?></small>
</div> -->