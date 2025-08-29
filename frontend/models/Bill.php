<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $patient_id
 * @property string $control_number
 * @property float $total_amount
 * @property float $paid_amount
 * @property string $status
 * @property int $created_at
 * @property int $created_by
 */
class Bill extends ActiveRecord
{
    public static function tableName()
    {
        return 'bill';
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['bill_id' => 'id']);
    }

    public function getBalance()
    {
        return $this->total_amount - $this->paid_amount;
    }
}