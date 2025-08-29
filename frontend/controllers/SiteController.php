<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use frontend\models\SignupForm;
use common\models\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
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
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        return $this->render('index');
    }

    // ----------------------
    public function actionAbout()
{
    return $this->render('about');
}


    // LOGIN
    // ----------------------
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $isJson = $request->isAjax || stripos($request->getContentType(), 'application/json') !== false;

        $model = new LoginForm();
        $loaded = $model->load($request->post());

        if (!$loaded && $request->getRawBody()) {
            $data = json_decode($request->getRawBody(), true);
            if (is_array($data)) {
                $model->email = $data['email'] ?? null;
                $model->password = $data['password'] ?? null;
                $model->rememberMe = $data['rememberMe'] ?? true;
                $loaded = true;
            }
        }

        if ($loaded && $model->login()) {
            $user = Yii::$app->user->identity;
            if (!$user->role) {
                $userCount = User::find()->count();
                $user->role = ($userCount === 1) ? 'super_admin' : 'user';
                $user->save(false);
            }

            if ($isJson) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'ok' => true,
                    'role' => $user->role,
                    'redirect' => $this->roleRedirect($user->role),
                ];
            }
            return $this->redirect([$this->roleRedirect($user->role)]);
        }

        if ($isJson) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['ok' => false, 'errors' => $model->getErrors()];
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    private function roleRedirect(string $role): string
    {
        switch ($role) {
            case 'super_admin': return 'site/select-dashboard';
            case 'admin': return 'dashboard/admin';
            case 'doctor': return 'dashboard/doctor';
            case 'nurse': return 'dashboard/nurse';
            case 'hr_officer': return 'dashboard/hr';
            case 'finance_officer': return 'dashboard/finance';
            case 'receptionist': return 'dashboard/reception';
            case 'pharmacist': return 'dashboard/pharmacy';
            case 'lab_technician': return 'dashboard/lab';
            default: return 'site/index';
        }
    }

    // ----------------------
    // SIGNUP
    // ----------------------
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Registration successful. Please login.');
            return $this->redirect(['login']);
        }

        return $this->render('signup', ['model' => $model]);
    }

    // ----------------------
    // DASHBOARD SELECT
    // ----------------------
    public function actionSelectDashboard()
    {
        return $this->render('select-dashboard');
    }

    // ----------------------
    // LOGOUT
    // ----------------------
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    // ✅ QR CODE GENERATOR
    public function actionQrcode($text)
    {
        // Use Bacon QR Code
        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight(200);
        $renderer->setWidth(200);
        $writer = new \BaconQrCode\Writer($renderer);
        $image = $writer->writeString($text);

        Yii::$app->response->headers->add('Content-Type', 'image/png');
        echo $image;
        Yii::$app->end();
    }


public function actionSettings()
{
    if (Yii::$app->user->isGuest) {
        return $this->goHome();
    }

    return $this->render('settings');
}


// Save theme to DB
public function actionSetTheme()
{
    $theme = Yii::$app->request->post('theme');
    $allowed = ['light', 'dark', 'system'];

    if (!in_array($theme, $allowed)) {
        Yii::$app->response->statusCode = 400;
        return ['error' => 'Invalid theme'];
    }

    $user = Yii::$app->user->identity;
    $user->theme = $theme;
    $user->save(false, ['theme']); // Save only theme

    Yii::$app->response->format = Response::FORMAT_JSON;
    return ['success' => true, 'theme' => $theme];
}

// Save language to DB
public function actionSetLanguage()
{
    $lang = Yii::$app->request->post('language');
    $available = ['en', 'es', 'fr', 'de', 'it', 'pt', 'sw', 'ru', 'zh', 'ja', 'ko', 'ar', 'hi', 'bn', 'th', 'vi'];

    if (!in_array($lang, $available)) {
        Yii::$app->response->statusCode = 400;
        return ['error' => 'Invalid language'];
    }

    $user = Yii::$app->user->identity;
    $user->language = $lang;
    $user->save(false, ['language']); // Save only language

    Yii::$app->response->format = Response::FORMAT_JSON;
    return ['success' => true, 'language' => $lang];
}


// ✅ Update Account (Username & Email)
public function actionUpdateAccount()
{
    $user = Yii::$app->user->identity;
    if (!$user) {
        throw new NotFoundHttpException('User not found.');
    }

    Yii::$app->response->format = Response::FORMAT_JSON;

    $username = Yii::$app->request->post('username');
    $email = Yii::$app->request->post('email');

    // Validate
    if (empty($username)) {
        return ['success' => false, 'error' => 'Username is required.'];
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'error' => 'Valid email is required.'];
    }

    // Check if email is already taken by another user
    $existing = User::find()->where(['email' => $email])->andWhere(['!=', 'id', $user->id])->one();
    if ($existing) {
        return ['success' => false, 'error' => 'Email is already in use.'];
    }

    // Save
    $user->username = $username;
    $user->email = $email;

    if ($user->save()) {
        return ['success' => true, 'message' => 'Account updated!'];
    } else {
        return ['success' => false, 'error' => 'Failed to save: ' . json_encode($user->getErrors())];
    }
}

// ✅ Change Password
public function actionChangePassword()
{
    $user = Yii::$app->user->identity;
    if (!$user) {
        throw new NotFoundHttpException('User not found.');
    }

    Yii::$app->response->format = Response::FORMAT_JSON;

    $current = Yii::$app->request->post('current');
    $new = Yii::$app->request->post('new');

    // Validate current password
    if (empty($current) || empty($new)) {
        return ['success' => false, 'error' => 'All fields are required.'];
    }

    if (strlen($new) < 6) {
        return ['success' => false, 'error' => 'New password must be at least 6 characters.'];
    }

    if (!Yii::$app->getSecurity()->validatePassword($current, $user->password_hash)) {
        return ['success' => false, 'error' => 'Current password is incorrect.'];
    }

    // Hash and save new password
    $user->setPassword($new);
    $user->generateAuthKey(); // Regenerate auth key for security

    if ($user->save(false)) {
        return ['success' => true, 'message' => 'Password changed successfully.'];
    } else {
        return ['success' => false, 'error' => 'Failed to update password.'];
    }
}

// ✅ Delete Account
public function actionDeleteAccount()
{
    $user = Yii::$app->user->identity;
    if (!$user) {
        return $this->goHome();
    }

    // Log out first
    Yii::$app->user->logout();

    // Delete from DB
    $user->delete();

    Yii::$app->session->setFlash('success', 'Your account has been permanently deleted.');
    return$this->goHome();
}
};
