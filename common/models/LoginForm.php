<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = null;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUserRaw(); // find regardless of status to give better error messages
        if (!$user) {
            $this->addError($attribute, 'Incorrect email or password.');
            Yii::warning("Login fail: user not found for {$this->email}", 'login');
            return;
        }

        if ((int)$user->status !== User::STATUS_ACTIVE) {
            $this->addError($attribute, 'Your account is not active. Contact admin.');
            Yii::warning("Login fail: inactive user {$this->email} (status={$user->status})", 'login');
            return;
        }

        if (!$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Incorrect email or password.');
            Yii::warning("Login fail: wrong password for {$this->email}", 'login');
            return;
        }
    }

    public function login()
    {
        Yii::info("Attempting login for: {$this->email}", 'login');

        if (!$this->validate()) {
            Yii::warning(['errors' => $this->getErrors()], 'login');
            return false;
        }

        $user = $this->getActiveUser(); // only active users can log in
        if (!$user) {
            // Shouldn’t reach here because validatePassword already checks
            Yii::warning("Login fail post-validate: no active user for {$this->email}", 'login');
            return false;
        }

        Yii::info("Login successful for: {$user->email}", 'login');
        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /** Return user ignoring status (for messaging) */
    protected function getUserRaw()
    {
        if ($this->_user === null) {
            $this->_user = User::find()->where(['email' => $this->email])->one();
        }
        return $this->_user;
    }

    /** Return active user only (for real login) */
    protected function getActiveUser()
    {
        $user = $this->getUserRaw();
        if ($user && (int)$user->status === User::STATUS_ACTIVE) {
            return $user;
        }
        return null;
    }
}
