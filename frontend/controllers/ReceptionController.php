<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Patient;
use frontend\models\Doctor;
use frontend\models\PatientQueue;
use Yii;

class ReceptionController extends Controller
{
    /**
     * Register a new patient
     */
    public function actionPatientRegister()
    {
        $model = new Patient();

        if ($model->load(Yii::$app->request->post())) {
            // ✅ Generate unique hosp_id if not set
            if (empty($model->hosp_id)) {
                $model->hosp_id = $this->generateUniqueHospId();
            }

            // ✅ Generate registration_number if not set
            if (empty($model->registration_number)) {
                $model->registration_number = $this->generateRegistrationNumber();
            }

            // ✅ Set registration_date and created_at
            if (empty($model->registration_date)) {
                $model->registration_date = date('Y-m-d');
            }
            $model->created_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', '✅ Patient registered successfully!');
                return $this->redirect(['patient/view', 'id' => $model->id]);
            }
        }

        return $this->render('patient-register', [
            'model' => $model,
        ]);
    }

    /**
     * Display the live queue
     */
    public function actionPatientQueue()
    {
        $queue = PatientQueue::find()
            ->with(['patient', 'doctor'])
            ->orderBy(['check_in_time' => SORT_ASC])
            ->all();

        return $this->render('patient-queue', [
            'queue' => $queue,
        ]);
    }

    /**
     * Add patient to queue
     */
    public function actionAddToQueue($patient_id)
    {
        $model = new PatientQueue();
        $model->patient_id = $patient_id;
        $model->check_in_time = date('Y-m-d H:i:s');
        $model->status = 'waiting';

        if ($model->save()) {
            Yii::$app->session->setFlash('success', '✅ Patient added to queue.');
        } else {
            Yii::$app->session->setFlash('error', '❌ Failed to add patient to queue.');
        }

        return $this->redirect(['reception/patient-queue']);
    }

    /**
     * Assign patient to doctor
     */
    public function actionAssign($id)
    {
        $queue = PatientQueue::findOne($id);
        $doctor_id = Yii::$app->request->post('doctor_id');
        $doctor = Doctor::findOne($doctor_id);

        if ($queue && $doctor) {
            $queue->doctor_id = $doctor_id;
            $queue->status = 'assigned';
            if ($queue->save()) {
                Yii::$app->session->setFlash('success', '✅ Patient assigned successfully.');
            }
        } else {
            Yii::$app->session->setFlash('error', '❌ Invalid patient or doctor.');
        }

        return $this->redirect(['reception/patient-queue']);
    }

    /**
     * Edit doctor assignment
     */
    public function actionEditAssign($id)
    {
        $queue = PatientQueue::findOne($id);
        if (!$queue) {
            Yii::$app->session->setFlash('error', '❌ Queue record not found.');
            return $this->redirect(['reception/patient-queue']);
        }

        if (Yii::$app->request->isPost) {
            $doctor_id = Yii::$app->request->post('doctor_id');
            $doctor = Doctor::findOne($doctor_id);

            if ($doctor) {
                $queue->doctor_id = $doctor_id;
                $queue->status = 'assigned';
                if ($queue->save()) {
                    Yii::$app->session->setFlash('success', '✅ Doctor assignment updated.');
                }
                return $this->redirect(['reception/patient-queue']);
            } else {
                Yii::$app->session->setFlash('error', '❌ Invalid doctor.');
            }
        }

        $doctors = Doctor::find()->where(['status' => 'active'])->all();
        return $this->render('edit-assign', [
            'queue' => $queue,
            'doctors' => $doctors,
        ]);
    }

    /**
     * Ajax search for patients
     */
    public function actionPatientList($q = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = Patient::find()
            ->select(['id', "CONCAT(registration_number, ' - ', first_name, ' ', last_name) AS text"])
            ->where(['like', 'registration_number', $q])
            ->orWhere(['like', 'first_name', $q])
            ->orWhere(['like', 'last_name', $q])
            ->limit(20)
            ->asArray()
            ->all();

        return ['results' => $query];
    }

    /**
     * Remove patient from queue
     */
    public function actionRemoveFromQueue($id)
    {
        $model = PatientQueue::findOne($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', '✅ Patient removed from queue.');
        } else {
            Yii::$app->session->setFlash('error', '❌ Patient not found in queue.');
        }

        return $this->redirect(['reception/patient-queue']);
    }

    // ✅ Helper: Generate unique hosp_id
    private function generateUniqueHospId()
    {
        do {
            $hospId = 'HOSP-' . date('y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $exists = Patient::find()->where(['hosp_id' => $hospId])->exists();
        } while ($exists);

        return $hospId;
    }

    // ✅ Helper: Generate registration number
    private function generateRegistrationNumber()
    {
        $year = date('Y');
        $count = Patient::find()->where(['like', 'registration_number', "REG-$year-%"])->count();
        $number = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        return "REG-$year-$number";
    }
}