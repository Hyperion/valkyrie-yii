<?php

class FAccountCreate extends CFormModel
{
    public $username;
    public $password;
    public $confirmPassword;
    public $locale;

    public function rules()
    {
        return array(
            array('username, locale, password, confirmPassword', 'required'),
            array('username', 'unique', 'attributeName'=>'username', 'className'=>'Account'),
            array('password', 'compare',
                'compareAttribute'=>'confirmPassword',
                'message' => 'Retype password is incorrect.'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'password' => 'Пароль',
            'username' => 'Аккаунт',
            'confirmPassword' => 'Подтвердите пароль',
            'locale' => 'Локаль',
        );
    }
}
