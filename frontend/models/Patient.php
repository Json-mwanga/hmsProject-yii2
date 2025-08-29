<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Patient extends ActiveRecord
{
    public static function tableName()
    {
        return 'patient';
    }

    public function getFull_name()
{
    $names = [$this->first_name];

    // add middle name if it exists
    if (!empty($this->middle_name)) {
        $names[] = $this->middle_name;
    }

    $names[] = $this->last_name;

    return implode(' ', $names);
}


    public function rules()
    {
        return [
            [['first_name', 'last_name', 'date_of_birth', 'gender'], 'required'],
            [['registration_date', 'date_of_birth'], 'safe'],
            [['first_name', 'middle_name', 'last_name', 'occupation', 'religion', 'citizenship', 'address', 'city', 'ward', 'district', 'region'], 'string', 'max' => 100],
            [['age'], 'integer'],
            [['registration_number'], 'unique'],
            [['gender'], 'in', 'range' => ['Male', 'Female', 'Other']],
            [['marital_status'], 'in', 'range' => ['Single', 'Married', 'Divorced', 'Widowed']],
            [['payer_type'], 'in', 'range' => ['private_cash', 'nhif', 'insurance']],
            [['country'], 'default', 'value' => 'Tanzania'],
        ];
    }

     public function attributeLabels()
    {
        return [
            'registration_number' => 'Registration Number',
            'registration_date' => 'Registration Date',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date of Birth',
            'age' => 'Age',
            'gender' => 'Gender',
            'marital_status' => 'Marital Status',
            'occupation' => 'Occupation',
            'religion' => 'Religion',
            'citizenship' => 'Citizenship',
            'address' => 'Address',
            'country' => 'Country',
            // 'city' => 'City',
            'ward' => 'Ward',
            'district' => 'District',
            'region' => 'Region',
            'payer_type' => 'Payer Information',
        ];
    }

// In frontend/models/Patient.php

public function beforeSave($insert)
{
    if ($insert) {
        // Generate REG-2025-0001 format
        $last = self::find()->select('registration_number')->orderBy(['id' => SORT_DESC])->one();
        $num = 1;
        if ($last !== null && preg_match('/REG-\d{4}-(\d+)/', $last->registration_number, $matches)) {
            $num = $matches[1] + 1;
        }
        $this->registration_number = 'REG-' . date('Y') . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);

        // Set registration date
        if (empty($this->registration_date)) {
            $this->registration_date = date('Y-m-d');
        }
    }

    // Calculate age from date_of_birth if available
    if ($this->date_of_birth) {
        $dob = new \DateTime($this->date_of_birth);
        $now = new \DateTime();
        $age = $now->diff($dob)->y;
        $this->age = $age;
    }

    return parent::beforeSave($insert);
}
    /**
     * Get patients awaiting consultation with a specific doctor
     * @param int $doctorId
     * @return array
     */
    public static function getAwaitingPatients($doctorId)
    {
        return self::find()
            ->innerJoinWith('appointment')
            ->where(['appointment.assigned_to' => $doctorId])
            ->andWhere(['appointment.status' => 'In-Consultation'])
            ->all();
    }

    /**
     * Get recent consults for a doctor
     * @param int $doctorId
     * @return array
     */
    public static function getRecentConsults($doctorId)
    {
        return DoctorConsult::find()
            ->where(['doctor_id' => $doctorId])
            ->orderBy(['visit_date' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    // frontend/models/Patient.php
public function getAppointments()
{
    return $this->hasMany(Appointment::class, ['patient_id' => 'id']);
}


}