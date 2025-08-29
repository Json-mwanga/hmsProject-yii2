<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Doctor extends ActiveRecord
{
    public static function tableName()
    {
        return 'doctors';
    }

    // Add any relationships you need, e.g., appointments
    public function getAppointments()
    {
        return $this->hasMany(Appointment::class, ['doctor_id' => 'id']);
    }

    // Optional: full name if you have first_name and last_name columns
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
