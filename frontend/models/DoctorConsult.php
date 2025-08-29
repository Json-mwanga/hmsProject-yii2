<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property int $appointment_id
 * @property int $visit_date
 * @property string $department
 * @property string $chief_complaint
 * @property string $history_of_present_illness
 * @property string $physical_exam
 * @property array $diagnosis_icd10
 * @property string $diagnosis_text
 * @property string $differential_diagnosis
 * @property string $treatment_plan
 * @property string $follow_up
 * @property string $doctor_notes
 * @property bool $is_finalized
 * @property int $finalized_at
 * @property int $created_at
 * @property int $updated_at
 */
class DoctorConsult extends ActiveRecord
{
    public static function tableName()
    {
        return 'doctor_consult';
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Staff::class, ['id' => 'doctor_id']);
    }
}