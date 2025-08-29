<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Our Hospital Management System (HMS) is a modern digital platform designed to streamline healthcare operations and improve patient care. <br>
        The system provides an integrated solution that connects patients, doctors, nurses, and administrators through one centralized platform. <br>
        With HMS, hospitals can efficiently manage patient records, appointments, billing, pharmacy, laboratory results, and inventory all in real time. <br>
        The platform ensures accuracy, reduces paperwork, and speeds up service delivery, creating a smoother experience for both patients and healthcare providers. <br>
        Security and privacy are at the core of HMS, with robust data protection measures that keep sensitive medical information safe. <br>
        Scalable and customizable, the system can serve small clinics, medium-sized hospitals, and large healthcare networks. <br>
        Our mission is to empower healthcare institutions with digital tools that enhance efficiency, support medical staff, and ultimately save lives.
    </p>
    <p>
        <strong>HMS Version 1.0.0</strong>
    </p>
    
    <p>
        &copy; <?= date('Y') ?>  developed by <strong>CØDEMΛMBΛ.</strong> All rights reserved.
    </p>
    <img src="/assets/images/logo.png" style="width:10%; height:10%; object-fit:cover;" alt="Hospital" />
    
</div>
