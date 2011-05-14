<?php

class FRecovery extends CFormModel {
	public $login_or_email, $user_id;
	
	public function rules()
	{
		return array(
			// username and password are required
			array('login_or_email', 'required'),
			array('login_or_email', 'match', 'pattern' => '/^[A-Za-z0-9@.\s,]+$/u','message' => Yii::t("UserModule.user", "Incorrect symbol's. (A-z0-9)")),
			// password needs to be authenticated
			array('login_or_email', 'checkexists'),
		);
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'login_or_email'=>Yii::t('UserModule.user', 'Username or email'),
		);
	}
	
	public function checkexists($attribute,$params) {
		// we only want to authenticate when no input errors
		if(!$this->hasErrors()) {
			if (strpos($this->login_or_email,"@")) {
				$profile = Profile::model()->findByAttributes(array(
							'email'=>$this->login_or_email));
				$user = isset($profile->user) ? $profile->user : null;
			} else {
				$user = User::model()->findByAttributes(array(
							'username'=>$this->login_or_email));
			}

			if($user === null) 
			{
				if (strpos($this->login_or_email, "@")) 
					$this->addError("login_or_email",
							Yii::t("UserModule.user", "Email is incorrect."));
				else
					$this->addError("login_or_email",
							Yii::t("UserModule.user", "Username is incorrect."));
			} 
			else
			{
				$this->user_id = $user->id;
			}
		}
	}
}
