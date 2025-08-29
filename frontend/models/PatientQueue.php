<?php
// models/PatientQueue.php
namespace frontend\models;

use yii\db\ActiveRecord;
use Yii;

class PatientQueue extends ActiveRecord
{
    public static function tableName()
    {
        return 'patient_queue'; // create this table
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['id' => 'doctor_id']);
    }
}
