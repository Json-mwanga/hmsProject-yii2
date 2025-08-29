<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Appointment;

class AppointmentController extends Controller
{
    public function actionBook()
    {
        $model = new Appointment();

        if ($model->load(Yii::$app->request->post())) {
    // Convert datetime-local input to timestamp
    $model->check_in_time = strtotime($model->check_in_time);

    if ($model->save()) {
        Yii::$app->session->setFlash('success', 'Appointment booked!');
        return $this->redirect(['index']);
    }
}


        return $this->render('book', ['model' => $model]);
    }

    public function actionIndex()
    {
        $appointments = Appointment::find()->with(['patient','doctor'])->all();
        return $this->render('index', ['appointments' => $appointments]);
    }

    public function actionUpdateStatus($id, $status)
    {
        $model = Appointment::findOne($id);
        if ($model) {
            $model->status = $status;
            $model->save(false);
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
{
    $model = Appointment::findOne($id);
    if($model) {
        $model->delete(); // permanently deletes the appointment
        Yii::$app->session->setFlash('success', 'Appointment deleted successfully!');
    } else {
        Yii::$app->session->setFlash('error', 'Appointment not found.');
    }
    return $this->redirect(['index']);
}

}
