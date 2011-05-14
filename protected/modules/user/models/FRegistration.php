<?php

class FRegistration extends User {
	public $username;
	public $password;
	public $verifyPassword;
	public $verifyCode; // Captcha

	public function rules() 
	{
		$rules = parent::rules();

		$rules[] = array('username', 'required');
		$rules[] = array('password, verifyPassword', 'required');
		$rules[] = array('password', 'compare',
				'compareAttribute'=>'verifyPassword',
				'message' => Yii::t('UserModule.user', "Retype password is incorrect."));
		$rules[] = array('verifyCode', 'captcha', 'allowEmpty'=>CCaptcha::checkRequirements() || !Yii::app()->controller->module->enableCaptcha);

		return $rules;
	}
}
