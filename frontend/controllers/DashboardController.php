<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class DashboardController extends Controller
{
    public function actionAdmin()    { return $this->render('admin'); }
    public function actionDoctor()   { return $this->render('doctor'); }
    public function actionNurse()    { return $this->render('nurse'); }
    public function actionHr()       { return $this->render('hr'); }
    public function actionFinance()  { return $this->render('finance'); }
    public function actionReception(){ return $this->render('reception'); }
    public function actionPharmacy() { return $this->render('pharmacy'); }
    public function actionLab()      { return $this->render('lab'); }
}
