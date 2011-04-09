<?php

class AccountCreateForm extends CFormModel
{
    public $username;
    //public $email;
    public $password;
    public $verifyPassword;
    public $locale;
    //public $verifyCode; // Captcha
  
    public function rules()
    {
        return array(
            array('username, locale, password, verifyPassword', 'required'),
            array('username', 'unique', 'attributeName'=>'username', 'className'=>'Account'),
            //array('email', 'email'),
            array('password', 'compare',
                'compareAttribute'=>'verifyPassword',
                'message' => 'Retype password is incorrect.'),
            //array('verifyCode', 'captcha', 'allowEmpty'=>CCaptcha::checkRequirements()),
        );
    }
}