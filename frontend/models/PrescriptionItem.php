<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $prescription_id
 * @property string $medicine_name
 * @property string $dosage
 * @property string $frequency
 * @property int $duration_days
 * @property int $quantity
 * @property string $instructions
 */
class PrescriptionItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'prescription_item';
    }

    public function getPrescription()
    {
        return $this->hasOne(Prescription::class, ['id' => 'prescription_id']);
    }
}