<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $patient_id
 * @property float $temperature
 * @property string $blood_pressure
 * @property int $heart_rate
 * @property int $respiratory_rate
 * @property int $oxygen_saturation
 * @property float $height
 * @property float $weight
 * @property int $recorded_by
 * @property string $ward
 * @property string $bed_number
 * @property int $recorded_at
 */
class VitalSign extends ActiveRecord
{
    public static function tableName()
    {
        return 'vital_sign';
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getNurse()
    {
        return $this->hasOne(Staff::class, ['id' => 'recorded_by']);
    }
}