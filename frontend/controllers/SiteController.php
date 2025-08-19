<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use frontend\models\SignupForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // ----------------------
    // LOGIN
    // ----------------------
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;

            // DEV MODE: First user = super admin
            if (!$user->role) {
                $userCount = \common\models\User::find()->count();
                if ($userCount === 1) {
                    $user->role = 'super_admin';
                    $user->save(false);
                } else {
                    $user->role = 'user';
                    $user->save(false);
                }
            }

            if ($user->role === 'super_admin') {
                return $this->redirect(['site/select-dashboard']);
            }

            // Normal role redirects
            switch ($user->role) {
                case 'admin': return $this->redirect(['dashboard/admin']);
                case 'doctor': return $this->redirect(['dashboard/doctor']);
                case 'nurse': return $this->redirect(['dashboard/nurse']);
                case 'hr_officer': return $this->redirect(['dashboard/hr']);
                case 'finance_officer': return $this->redirect(['dashboard/finance']);
                case 'receptionist': return $this->redirect(['dashboard/reception']);
                case 'pharmacist': return $this->redirect(['dashboard/pharmacy']);
                case 'lab_technician': return $this->redirect(['dashboard/lab']);
                default: return $this->goHome();
            }
        }

        $model->password = '';

        return $this->render('@frontend/views/site/login.php', [
            'model' => $model,
        ]);
    }

    // ----------------------
    // SIGNUP
    // ----------------------
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {

            // Assign super_admin to first user
            $userCount = \common\models\User::find()->count();
            if ($userCount === 1) {
                $user = \common\models\User::findOne(['id' => $model->id]);
                $user->role = 'super_admin';
                $user->save(false);
            }

            Yii::$app->session->setFlash('success', 'Registration successful. Please login.');
            return $this->redirect(['login']);
        }

        return $this->render('@frontend/views/site/signup.php', [
            'model' => $model,
        ]);
    }

    // ----------------------
    // DASHBOARD SELECT (Super Admin)
    // ----------------------
    public function actionSelectDashboard()
    {
        return $this->render('@frontend/views/site/select-dashboard.php');
    }

    // ----------------------
    // LOGOUT
    // ----------------------
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
