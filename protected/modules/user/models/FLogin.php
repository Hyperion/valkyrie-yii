<?php

class FLogin extends CFormModel {
	public $username;
	public $password;
	public $rememberMe;

	public function rules()
	{
		if(!isset($this->scenario))
			$this->scenario = 'login';

		$rules = array(
			array('username, password', 'required', 'on' => 'login'),
			array('username', 'required', 'on' => 'openid'),
			array('rememberMe', 'boolean'),
		);

		return $rules;
	}

	public function attributeLabels() {
		return array(
			'username'   => Yii::t('UserModule.user', 'Username'),
			'password'   => Yii::t('UserModule.user', 'Password'),
			'rememberMe' => Yii::t('UserModule.user', 'Remember me next time'),
		);
	}

}
