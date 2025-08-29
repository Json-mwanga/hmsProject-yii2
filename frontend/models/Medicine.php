<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $generic_name
 * @property string $dosage_form
 * @property string $manufacturer
 * @property string $batch_number
 * @property string $expiry_date
 * @property float $unit_price
 * @property int $stock_quantity
 * @property int $reorder_level
 * @property int $created_at
 */
class Medicine extends ActiveRecord
{
    public static function tableName()
    {
        return 'medicine';
    }

    public function getLowStockAlert()
    {
        return $this->stock_quantity <= $this->reorder_level;
    }
}