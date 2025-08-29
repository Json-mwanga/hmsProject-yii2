<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $bill_id
 * @property float $amount
 * @property string $method
 * @property string $transaction_id
 * @property int $paid_at
 */
class Payment extends ActiveRecord
{
    public static function tableName()
    {
        return 'payment';
    }

    public function getBill()
    {
        return $this->hasOne(Bill::class, ['id' => 'bill_id']);
    }
}