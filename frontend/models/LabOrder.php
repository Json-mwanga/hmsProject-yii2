<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $patient_id
 * @property string $test_type
 * @property string $department
 * @property int $ordered_by
 * @property int $lab_tech_id
 * @property bool $specimen_collected
 * @property string $result_text
 * @property string $result_file
 * @property string $status
 * @property int $ordered_at
 * @property int $completed_at
 */
class LabOrder extends ActiveRecord
{
    public static function tableName()
    {
        return 'lab_order';
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Staff::class, ['id' => 'ordered_by']);
    }

    public function getTechnician()
    {
        return $this->hasOne(Staff::class, ['id' => 'lab_tech_id']);
    }
}