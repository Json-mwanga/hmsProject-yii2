<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    private $_user = null; // ← Add this

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved user model or null if saving fails
     */
    public function signup()
{
    if (!$this->validate()) {
        return null;
    }

    $user = new \common\models\User();
    $user->username = $this->username;
    $user->email = $this->email;
    $user->setPassword($this->password);
    $user->generateAuthKey();
    $user->generateEmailVerificationToken();
    $user->status = 10; // 🔥 Activate user automatically

    // 🔥 Set role to super_admin for EVERY new user
    $user->role = 'super_admin';

    // Save to database
    if ($user->save()) {
        return $user; // return user object
    }

    return null;
}

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->_user;
    }
}
