<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://source.unsplash.com/random/1600x900/?hospital') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 150px 0;
            text-align: center;
        }
        .btn-xl {
            padding: 12px 30px;
            font-size: 1.2em;
        }
        .features {
            padding: 60px 0;
        }
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Hospital Management System</h1>
        <p>Patient Tracking, Staff Management, and Exceptional Care for Every Patient.</p>
        <p>
            <?= Html::a('SignUp', ['site/signup'], ['class' => 'btn btn-success btn-xl me-3']) ?>
            <?= Html::a('Login', Url::to(['site/login']), ['class' => 'btn btn-light btn-xl']) ?>
        </p>
    </div>
</section>

<!-- Features -->
<section class="features container text-center">
    <h2>Features:</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <h4>Doctor</h4>
            <p>Register patients, prescribe medication, and manage treatments efficiently.</p>
        </div>
        <div class="col-md-4">
            <h4>Administration</h4>
            <p>Oversee payments, staff, and all resources seamlessly.</p>
        </div>
        <div class="col-md-4">
            <h4>Laboratory</h4>
            <p>Easily record and manage lab results.</p>
        </div>
    </div>
</section>

<!-- Footer -->
<div class="footer">
    &copy; <?= date('Y') ?> Hospital Management System. All Rights Reserved.
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/web/js/yii.js"></script>
</body>
</html>