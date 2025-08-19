<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

class LoginForm extends Model
{
    public $email;        // MUST exist
    public $password;     // MUST exist
    public $rememberMe = true;

    private $_user = false;

    // Validation rules
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
        ];
    }

    // Custom password validator
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !Yii::$app->getSecurity()->validatePassword($this->password, $user->password_hash)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    // Login function
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login(
                $this->getUser(), 
                $this->rememberMe ? 3600 * 24 * 30 : 0
            );
        }
        return false;
    }

    // Get user by email
    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }
}
