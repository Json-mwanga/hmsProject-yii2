<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Appointment extends ActiveRecord
{
    public static function tableName()
    {
        return 'appointment';
    }

    public function rules()
    {
        return [
            [['patient_id', 'doctor_id', 'appointment_date'], 'required'],
            [['patient_id', 'doctor_id'], 'integer'],
            ['status', 'default', 'value' => 'pending'],
            ['status', 'in', 'range' => ['pending','confirmed','completed','cancelled']],
            ['appointment_date', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::class, ['id' => 'doctor_id']);
    }

    public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        if ($this->appointment_date) {
            // convert 2025-08-28T14:30 -> 2025-08-28 14:30:00
            $this->appointment_date = str_replace('T', ' ', $this->appointment_date) . ':00';
        }
        return true;
    }
    return false;
}

public function beforeValidate()
{
    if (parent::beforeValidate()) {
        if ($this->appointment_date) {
            // convert 2025-08-28T14:30 -> 2025-08-28 14:30:00
            $this->appointment_date = str_replace('T', ' ', $this->appointment_date) . ':00';
        }
        return true;
    }
    return false;
}

}
