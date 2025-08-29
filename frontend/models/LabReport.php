<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $order_id
 * @property int $patient_id
 * @property int $technician_id
 * @property string $test_type
 * @property string $department
 * @property string $macroscopic
 * @property string $microscopic
 * @property string $culture_results
 * @property string $radiology_findings
 * @property string $impression
 * @property string $recommendation
 * @property array $images
 * @property string $pdf_report
 * @property string $status
 * @property bool $is_critical
 * @property int $reviewed_by
 * @property int $signed_at
 * @property int $created_at
 * @property int $updated_at
 */
class LabReport extends ActiveRecord
{
    public static function tableName()
    {
        return 'lab_report';
    }

    public function getOrder()
    {
        return $this->hasOne(LabOrder::class, ['id' => 'order_id']);
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getTechnician()
    {
        return $this->hasOne(Staff::class, ['id' => 'technician_id']);
    }
}