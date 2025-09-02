<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\IdentityInterface;
use yii\web\Identity;
use frontend\models\Patient;
use frontend\models\Doctor;
use frontend\models\Staff;
use frontend\models\Payment;
use frontend\models\LabReport;
use frontend\models\Prescription;
use frontend\models\Bed;
use frontend\models\Bill;
use frontend\models\Medicine;
use frontend\models\LabOrder;


class DashboardController extends Controller
{
    // Admin Dashboard
    public function actionAdmin()
{
    $this->view->params['sidebar'] = 'admin-sidebar';
    $today = strtotime('today'); // ✅ Tumia kama threshold

    // ✅ Lab: critical reports
    $criticalLabs = LabReport::find()->where(['is_critical' => 1])->count();

    // ✅ Bill: overdue payments
    $overduePayments = Bill::find()
        ->where(['status' => 'Unpaid'])
        ->andWhere(['<', 'created_at', $today - 7 * 86400])
        ->count();

    // ✅ Patients
    $totalPatients = Patient::find()->count();
    $newToday = Patient::find()->where(['>=', 'created_at', $today])->count();

    // ✅ Staff who logged in today (mock for "online")
    $staffOnline = Staff::find()
        ->where(['>=', 'last_login', $today])
        ->count();

    // ✅ Doctors who logged in today
    $doctorsOnline = Staff::find()
        ->where(['role' => 'doctor'])
        ->andWhere(['>=', 'last_login', $today])
        ->count();

    // ✅ Nurses who logged in today
    $nursesOnline = Staff::find()
        ->where(['role' => 'nurse'])
        ->andWhere(['>=', 'last_login', $today])
        ->count();

    // ✅ Finance
    $dailyRevenue = Payment::find()
        ->where(['>=', 'created_at', $today])
        ->sum('amount') ?? 0;

    $paymentsToday = Payment::find()
        ->where(['>=', 'created_at', $today])
        ->count();

    // ✅ Low stock meds
    $lowStockMeds = Medicine::find()
        ->where(['<=', 'stock_quantity', 'reorder_level'])
        ->count();

    // ✅ Live patients (mock)
    $livePatients = [];

    return $this->render('admin', [
        'criticalLabs' => (int)$criticalLabs,
        'overduePayments' => (int)$overduePayments,
        'totalPatients' => (int)$totalPatients,
        'newToday' => (int)$newToday,
        'staffOnline' => (int)$staffOnline,
        'doctorsOnline' => (int)$doctorsOnline,
        'nursesOnline' => (int)$nursesOnline,
        'dailyRevenue' => (float)$dailyRevenue,
        'paymentsToday' => (int)$paymentsToday,
        'lowStockMeds' => (int)$lowStockMeds,
        'livePatients' => $livePatients,
    ]);
}

    // Doctor Dashboard
// frontend/controllers/DashboardController.php
public function actionDoctor()
{
    // 🔓 DEVELOPMENT MODE: Auto-login as super user
    if (YII_ENV_DEV) {
        // Mock user identity (simulate logged-in super user)
        $user = new \stdClass();
        $user->id = 1;
        $user->username = 'D-0001'; // matches staff emp_id
        $user->role = 'doctor';

       // Create mock identity that implements IdentityInterface
        $identity = new class($user) implements IdentityInterface {
            private $id;
            private $username;
            private $role;

            public function __construct($user) {
                $this->id = $user->id;
                $this->username = $user->username;
                $this->role = $user->role;
            }
            public static function findIdentity($id) { return null; }
            public static function findIdentityByAccessToken($token, $type = null) { return null; }
            public function getId() { return $this->id; }
            public function getAuthKey() { return ''; }
            public function validateAuthKey($authKey) { return true; }
             public function getUsername()
            {
                return $this->username;
            }

            public function getRole()
            {
                return $this->role;
            }
        };
    
    // Simulate logged-in user
        Yii::$app->user->setIdentity($identity);
    }

    // Now proceed as logged-in
    $user = Yii::$app->user->identity;

    $doctor = Staff::find()
        ->where(['emp_id' => $user->getUsername()]) // ✅ Badilisha hapa
        ->one();

    if (!$doctor) {
        // Create mock doctor if not found
        $doctor = new Staff();
        $doctor->id = 1;
        $doctor->first_name = 'John';
        $doctor->last_name = 'Doe';
        $doctor->emp_id = 'D-0001';
        $doctor->role = 'doctor';
        $doctor->specialty = 'General Practice';
    }

    // Mock data
    $awaitingPatients = [
    (object)[
        'id' => 1,
        'name' => 'Li Wei',
        'age' => 45,
        'gender' => 'Male',
        'chief_complaint' => 'Chest pain for 2 days',
        'priority' => 'normal',
    ],
    (object)[
        'id' => 2,
        'name' => 'Zhang Mei',
        'age' => 32,
        'gender' => 'Female',
        'chief_complaint' => 'Severe headache',
        'priority' => 'urgent',
    ],
];

    $recentConsults = [];

    // ✅ Set sidebar
    $this->view->params['sidebar'] = '_doctor-sidebar';
    $this->view->params['criticalLabs'] = 3;
    $this->view->params['pendingPrescriptions'] = 2;

    return $this->render('doctor', compact('doctor', 'awaitingPatients', 'recentConsults'));
}

    // Finance Dashboard
public function actionFinance()
{
    $dailyRevenue = Payment::find()
        ->where(['>=', 'created_at', date('Y-m-d 00:00:00')])
        ->andWhere(['<=', 'created_at', date('Y-m-d 23:59:59')])
        ->sum('amount') ?? 0;

    $transactions = Payment::find()
        ->where(['>=', 'created_at', date('Y-m-d 00:00:00')])
        ->andWhere(['<=', 'created_at', date('Y-m-d 23:59:59')])
        ->count();

    $digitalPayments = Payment::find()
        ->where(['method' => 'Mobile Money']) // kama unatumia Mobile Money
        ->orWhere(['method' => 'WeChat'])
        ->orWhere(['method' => 'Alipay'])
        ->count();

     $digitalPct = $transactions > 0 ? ($digitalPayments / $transactions * 100) : 0;

    $controlsIssued = rand(3, 8); // mock

     // ✅ Mock: Unpaid bills (data ya mtihani)
    $unpaidBills = [
        [
            'bill_id' => 1,
            'hosp_id' => 'H-001',
            'name' => 'Li Wei',
            'total' => 1200,
            'paid' => 400,
            'balance' => 800,
            'insurance' => 'Urban'
        ],
        [
            'bill_id' => 2,
            'hosp_id' => 'H-002',
            'name' => 'Zhang Mei',
            'total' => 950,
            'paid' => 150,
            'balance' => 800,
            'insurance' => 'Commercial'
        ],
        [
            'bill_id' => 3,
            'hosp_id' => 'H-003',
            'name' => 'John Doe',
            'total' => 600,
            'paid' => 0,
            'balance' => 600,
            'insurance' => 'None'
        ],
    ];
    
    $unpaidCount = Payment::find()->where(['status' => 'unpaid'])->count();
    $unpaidAmount = Payment::find()->where(['status' => 'unpaid'])->sum('amount') ?? 0;
    $digitalPayments = Payment::find()->where(['method' => ['Mobile Money', 'WeChat', 'Alipay']])->count();
    $digitalPct = $transactions > 0 ? ($digitalPayments / $transactions * 100) : 0;

    // Mock: Controls issued today
    $controlsIssued = rand(3, 8);

    // ✅ Set sidebar
    $this->view->params['sidebar'] = 'finance-sidebar';
    $this->view->params['pendingPayments'] = $unpaidCount;

    return $this->render('finance', compact(
        'dailyRevenue',
        'transactions',
        'unpaidCount',
        'unpaidAmount',
        'digitalPayments',
        'digitalPct',
        'unpaidBills',
        'controlsIssued'
    ));
}

    // HR Dashboard
public function actionHr()
{
    $totalStaff = Staff::find()->count();
    $doctors = Staff::find()->where(['role' => 'doctor'])->count();
    $nurses = Staff::find()->where(['role' => 'nurse'])->count();
    $onLeave = Staff::find()->where(['status' => 'On Leave'])->count();
    $monthlyPayroll = Staff::getMonthlyPayroll(); // sasa itafanya kazi
    $newHires = Staff::find()
        ->where(['>=', 'hire_date', date('Y-m-01 00:00:00')])
        ->count();
    $staffList = Staff::find()->limit(10)->all(); // limit kwa performance

    // ✅ Set sidebar
    $this->view->params['sidebar'] = 'hr-sidebar';
    $this->view->params['pendingApprovals'] = 2; // mock

    return $this->render('hr', compact(
        'totalStaff',
        'doctors',
        'nurses',
        'onLeave',
        'monthlyPayroll',
        'newHires',
        'staffList'
    ));
}

    // Lab Dashboard
    public function actionLab()
{
    $pending = LabOrder::find()->where(['status' => 'pending'])->count();
    $urgent = LabOrder::find()->where(['priority' => 'urgent'])->count();
    $completed = LabOrder::find()->where(['status' => 'completed'])->count();
    $total = LabOrder::find()
        ->where(['DATE(ordered_at)' => date('Y-m-d')])
        ->count();

    // Mock pending orders
    $pendingOrders = LabOrder::find()
        ->where(['status' => 'pending'])
        ->with('patient', 'doctor')
        ->limit(10)
        ->all();

    // ✅ Set sidebar
    $this->view->params['sidebar'] = 'lab-sidebar';
    $this->view->params['criticalLabs'] = $urgent;

    return $this->render('lab', compact('pending', 'urgent', 'completed', 'total', 'pendingOrders'));
}

// Nurse Dashboard
public function actionNurse()
{
    // 🔓 DEVELOPMENT MODE: Auto-login as nurse
    if (YII_ENV_DEV) {
        $user = new \stdClass();
        $user->id = 2;
        $user->username = 'N-0001'; // matches staff emp_id
        $user->role = 'nurse';

        $identity = new class($user) implements \yii\web\IdentityInterface {
            private $id;
            private $username;
            private $role;

            public function __construct($user) {
                $this->id = $user->id;
                $this->username = $user->username;
                $this->role = $user->role;
            }

            public function getUsername() { return $this->username; }
            public function getRole() { return $this->role; }

            public static function findIdentity($id) { return null; }
            public static function findIdentityByAccessToken($token, $type = null) { return null; }
            public function getId() { return $this->id; }
            public function getAuthKey() { return 'test123'; }
            public function validateAuthKey($authKey) { return true; }
        };

        Yii::$app->user->setIdentity($identity);
    }

    $user = Yii::$app->user->identity;

    // Find nurse profile
    $nurse = Staff::find()
        ->where(['emp_id' => $user->getUsername()])
        ->one();

    if (!$nurse) {
        $nurse = new Staff();
        $nurse->id = 2;
        $nurse->first_name = 'Mary';
        $nurse->last_name = 'Smith';
        $nurse->emp_id = 'N-0001';
        $nurse->role = 'nurse';
        $nurse->ward = 'Ward 3A';
    }

    // ✅ Nurse ward
    $ward = $nurse->ward;

    // Mock critical patients
    $criticalPatients = [
        (object)[
            'id' => 1,
            'name' => 'Li Wei',
            'age' => 68,
            'gender' => 'Male',
            'temp' => 39.2,
            'bp' => '90/60',
            'vitals' => 'BP: 90/60, HR: 120, SpO2: 88%',
            'condition' => 'Post-op, low oxygen',
            'time_in' => time() - 300,
        ],
        (object)[
            'id' => 2,
            'name' => 'Zhang Mei',
            'age' => 75,
            'gender' => 'Female',
            'temp' => 38.8,
            'bp' => '85/55',
            'vitals' => 'BP: 85/55, HR: 110, SpO2: 90%',
            'condition' => 'Sepsis suspected',
            'time_in' => time() - 600,
        ],
    ];

    // Mock beds (across multiple wards)
    $beds = [];
    $wards = ['Ward 3A', 'Ward 3B', 'ICU', 'Maternity'];
    foreach ($wards as $w) {
        for ($i = 1; $i <= 10; $i++) {
            $occupied = rand(0, 1);
            $critical = $occupied && rand(0, 3) === 1;

            $beds[] = [
                'ward' => $w,
                'number' => $i,
                'occupied' => $occupied,
                'patient_name' => $occupied ? 'Patient ' . rand(100, 999) : null,
                'critical' => $critical,
            ];
        }
    }

    // ✅ Mock stats for dashboard cards
    $pendingMeds = 12;
    $upcomingAppointments = 5;

    // ✅ Mock Chats & Notifications
    $newChats = 3;
    $newNotifications = 2;

    // ✅ Pass sidebar params (badges)
    $this->view->params['sidebar'] = '_nurse-sidebar';
    $this->view->params['criticalAlerts'] = count($criticalPatients);
    $this->view->params['pendingTasks'] = 5;

    // ✅ Render with all needed variables
    return $this->render('nurse', [
        'nurse' => $nurse,
        'ward' => $ward,
        'beds' => $beds,
        'criticalPatients' => $criticalPatients,
        'pendingMeds' => $pendingMeds,
        'upcomingAppointments' => $upcomingAppointments,
        'newChats' => $newChats,
        'newNotifications' => $newNotifications,
    ]);
}


    // Pharmacy Dashboard
public function actionPharmacy()
{
    $pendingPrescriptions = Prescription::find()->where(['status' => 'pending'])->count();
    $lowStockCount = Prescription::getLowStockCount();
    $dispensedToday = Prescription::getDispensedToday();
    $totalMeds = Prescription::find()->count();
    $criticalStock = Prescription::getCriticalStock();
    $pendingPrescriptionsList = Prescription::getPendingList();

    // ✅ Set sidebar
    $this->view->params['sidebar'] = 'pharmacy-sidebar';
    $this->view->params['lowStockAlerts'] = $lowStockCount;

    return $this->render('pharmacy', compact(
        'pendingPrescriptions',
        'lowStockCount',
        'dispensedToday',
        'totalMeds',
        'criticalStock',
        'pendingPrescriptionsList'
    ));
}

    // Reception Dashboard
public function actionReception()
{
    $today = date('Y-m-d');

    // ✅ New registrations today — created_at is DATETIME (e.g., '2025-04-05 10:30:00')
    $patients = Patient::find()
        ->where(['>=', 'created_at', "$today 00:00:00"])
        ->andWhere(['<=', 'created_at', "$today 23:59:59"])
        ->count();

// ✅ Check-Ins = Patients in queue today
$checkIns = (new \yii\db\Query())
    ->from('patient_queue')
    ->innerJoin('patient', 'patient.id = patient_queue.patient_id')
    ->where(['>=', 'patient_queue.check_in_time', "$today 00:00:00"])
    ->andWhere(['<=', 'patient_queue.check_in_time', "$today 23:59:59"])
    ->count();

// ✅ Cash patients in queue today
$cashPatients = (new \yii\db\Query())
    ->from('patient_queue')
    ->innerJoin('patient', 'patient.id = patient_queue.patient_id')
    ->where(['patient.payer_type' => 'private_cash'])
    ->andWhere(['>=', 'patient_queue.check_in_time', "$today 00:00:00"])
    ->andWhere(['<=', 'patient_queue.check_in_time', "$today 23:59:59"])
    ->count();

// ✅ Insurance patients in queue today
$insurancePatients = (new \yii\db\Query())
    ->from('patient_queue')
    ->innerJoin('patient', 'patient.id = patient_queue.patient_id')
    ->where(['patient.payer_type' => ['nhif', 'insurance']])
    ->andWhere(['>=', 'patient_queue.check_in_time', "$today 00:00:00"])
    ->andWhere(['<=', 'patient_queue.check_in_time', "$today 23:59:59"])
    ->count();
    // ✅ Fetch doctors
    $doctors = Doctor::find()
        ->select(['id', 'first_name', 'last_name'])
        ->asArray()
        ->all();

    // ✅ Get queue — all patients in patient_queue
    $queue = (new \yii\db\Query())
        ->select([
            'pq.id',
            'pq.check_in_time',
            'pq.status',
            'pq.doctor_id',
            'p.registration_number',
            'p.first_name',
            'p.last_name',
            'p.payer_type',
        ])
        ->from(['pq' => 'patient_queue'])
        ->innerJoin(['p' => 'patient'], 'p.id = pq.patient_id')
        ->orderBy(['pq.check_in_time' => SORT_ASC])
        ->all();

    // ✅ Restructure queue — include doctor_name if assigned
    $structuredQueue = [];
    foreach ($queue as $item) {
        // Build doctor name
        $doctorName = '-';
        if (!empty($item['doctor_id'])) {
            $assignedDoc = array_filter($doctors, fn($d) => $d['id'] == $item['doctor_id']);
            if (!empty($assignedDoc)) {
                $doc = array_values($assignedDoc)[0];
                $doctorName = 'Dr. ' . trim($doc['first_name'] . ' ' . $doc['last_name']);
            } else {
                $doctorName = 'Dr. Assigned';
            }
        }

        $structuredQueue[] = [
            'id' => $item['id'],
            'check_in_time' => $item['check_in_time'],
            'status' => $item['status'],
            'doctor_name' => $doctorName,
            'patient' => [
                'registration_number' => $item['registration_number'],
                'full_name' => trim($item['first_name'] . ' ' . $item['last_name']),
                'payer_type' => $item['payer_type'],
            ]
        ];
    }

    // ✅ Set sidebar
    $this->view->params['sidebar'] = '_reception-sidebar';

    // ✅ Pass all data to view
    return $this->render('reception', compact(
        'patients',
        'today',
        'checkIns',
        'cashPatients',
        'insurancePatients',
        'structuredQueue',
        'doctors'
    ));
}
}
