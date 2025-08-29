<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $diagnosis
 * @property string $notes
 * @property string $status
 * @property int $issued_at
 */
class Prescription extends ActiveRecord
{
    public static function tableName()
    {
        return 'prescription';
    }

     // ✅ Static method: Get low stock count
    public static function getLowStockCount()
    {
        return self::find()
            ->where(['<=', 'quantity', 10]) // kama quantity <= 10 = low stock
            ->count();
    }

    // ✅ Static method: Get dispensed today
    public static function getDispensedToday()
    {
        return self::find()
            ->where(['DATE(dispensed_at)' => date('Y-m-d')])
            ->count();
    }

        // ✅ Static method: Get critical stock items
    public static function getCriticalStock()
    {
        return self::find()
            ->where(['<=', 'quantity', 5]) // kama <= 5 = critical
            ->orderBy(['quantity' => SORT_ASC])
            ->limit(5)
            ->all();
    }

    // ✅ Static method: Get pending prescriptions
    public static function getPendingList()
    {
        return self::find()
            ->where(['status' => 'pending'])
            ->with('patient', 'doctor')
            ->limit(10)
            ->all();
    }

    // Relations
    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Staff::class, ['id' => 'doctor_id']);
    }

    public function getItems()
    {
        return $this->hasMany(PrescriptionItem::class, ['prescription_id' => 'id']);
    }
}