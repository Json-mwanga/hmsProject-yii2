<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $emp_id
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property string $department
 * @property string $specialty
 * @property string $license_no
 * @property string $phone
 * @property string $wechat_id
 * @property string $hire_date
 * @property string $status
 * @property int $created_at
 */
class Staff extends ActiveRecord
{
    public static function tableName()
    {
        return 'staff';
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

     // ✅ Static method: Get monthly payroll
    public static function getMonthlyPayroll()
    {
        // Kama una sifa ya `salary` kwenye meza ya staff
        return self::find()
            ->select('SUM(salary) as total')
            ->scalar() ?? 0;
    }

    // Optional: Get staff on leave
    public static function getOnLeaveCount()
    {
        return self::find()
            ->where(['status' => 'On Leave'])
            ->count();
    }

    // Relations
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'dept_id']);
    }

    
    // Optional: Update last_login when user logs in
    public function setLastLogin()
    {
        $this->last_login = time();
        $this->save(false); // bypass validation
    }
}