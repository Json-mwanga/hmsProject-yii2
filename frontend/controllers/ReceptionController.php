<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Patient;
use frontend\models\Doctor;
use frontend\models\PatientQueue; // new model for live queue
use Yii;

class ReceptionController extends Controller
{
    public function actionPatientRegister()
    {
        $model = new Patient(); // ← This line creates the model

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', '✅ Patient registered successfully!');

        // Redirect to patient profile
        return $this->redirect(['patient/view', 'id' => $model->id]);
        
        return $this->refresh(); // This reloads the page with the message
    }

        // ✅ Pass $model to the view
        return $this->render('patient-register', [
            'model' => $model,
        ]);
    }

    // Display the live queue
    public function actionPatientQueue()
    {
        $queue = PatientQueue::find()->with(['patient', 'doctor'])->all();
        return $this->render('patient-queue', [
            'queue' => $queue,
        ]);
    }

    // Add patient into queue (from registered patients)
    public function actionAddToQueue($patient_id)
    {
        $model = new PatientQueue();
        $model->patient_id = $patient_id;
        $model->check_in_time = date('Y-m-d H:i:s');
        $model->status = 'waiting';
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Patient added to queue');
        }
        return $this->redirect(['patient-queue']);
    }

    // Assign patient to doctor
   // inside actionAssign
public function actionAssign($id)
{
    $queue = PatientQueue::findOne($id);
    $doctor_id = Yii::$app->request->post('doctor_id');

    $doctor = Doctor::findOne($doctor_id);

    if ($queue && $doctor) {
        $queue->doctor_id = $doctor_id;
        $queue->status = 'assigned';
        $queue->save();
        Yii::$app->session->setFlash('success', 'Patient assigned successfully.');
    } else {
        Yii::$app->session->setFlash('error', 'Invalid patient or doctor.');
    }

    return $this->redirect(['patient-queue']);
}

public function actionEditAssign($id)
{
    $queue = PatientQueue::findOne($id);
    if (!$queue) {
        Yii::$app->session->setFlash('error', 'Queue record not found.');
        return $this->redirect(['patient-queue']);
    }

    if (Yii::$app->request->isPost) {
        $doctor_id = Yii::$app->request->post('doctor_id');
        $doctor = Doctor::findOne($doctor_id);

        if ($doctor) {
            $queue->doctor_id = $doctor_id;
            $queue->status = 'assigned';
            $queue->save();
            Yii::$app->session->setFlash('success', 'Doctor assignment updated.');
            return $this->redirect(['patient-queue']);
        } else {
            Yii::$app->session->setFlash('error', 'Invalid doctor.');
        }
    }

    $doctors = Doctor::find()->where(['status' => 'active'])->all();
    return $this->render('edit-assign', [
        'queue' => $queue,
        'doctors' => $doctors,
    ]);
}

// Ajax search for patients
public function actionPatientList($q = null) {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $query = Patient::find()
        ->select(['id', "CONCAT(registration_number, ' - ', first_name, ' ', last_name) AS text"])
        ->where(['like', 'registration_number', $q])
        ->orWhere(['like', 'first_name', $q])
        ->orWhere(['like', 'last_name', $q])
        ->limit(20) // limit results for performance
        ->asArray()
        ->all();

    return ['results' => $query];
}


}