<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Sign in form
 */
class SigninForm extends Model
{
    public $email;
    public $password;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function validatePassword($attribute) : void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Вы ввели неверный email/пароль');
            }
        }
    }

    public function getUser() : ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }

}
