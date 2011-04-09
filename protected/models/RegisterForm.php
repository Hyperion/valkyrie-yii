<?php

class RegisterForm extends CFormModel
{
	public $email;
	public $password;
    public $verifyPassword;
    public $first_name;
    public $last_name;
    public $verifyCode;

	public function rules()
    {
		return array(
			array('email, password, verifyPassword, first_name, last_name', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'attributeName'=>'email', 'className'=>'User'),
            array('password', 'compare', 'compareAttribute'=>'verifyPassword', 'message' => 'Retype password is incorrect.'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

    public function attributeLabels()
    {
        return array(
            'verifyCode'=>'Verification Code',
        );
    }
}
