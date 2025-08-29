<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $patient_id
 * @property int $nurse_id
 * @property string $shift
 * @property string $ward
 * @property string $bed_number
 * @property string $date_served
 * @property array $vital_signs
 * @property array $intake_output
 * @property array $medications_given
 * @property string $procedures_done
 * @property string $patient_behavior
 * @property string $observations
 * @property string $nursing_interventions
 * @property string $handover_notes
 * @property bool $is_signed
 * @property int $signed_at
 * @property int $created_at
 */
class NurseShiftReport extends ActiveRecord
{
    public static function tableName()
    {
        return 'nurse_shift_report';
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getNurse()
    {
        return $this->hasOne(Staff::class, ['id' => 'nurse_id']);
    }
}