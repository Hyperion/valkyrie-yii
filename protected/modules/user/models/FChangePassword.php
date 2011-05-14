<?php

class FChangePassword extends CFormModel 
{
//	private $_errors;
	public $password;
	public $verifyPassword;
	public $currentPassword;

	public function addError($attribute, $error) {
		parent::addError($attribute, Yii::t('UserModule.user', $error));
	}

	public function rules() {
		$passwordRequirements = Yii::app()->controller->module->passwordRequirements;
		$passwordrule = array_merge(array('password', 'PasswordValidator'), $passwordRequirements);
		$rules[] = $passwordrule;
		$rules[] = array('currentPassword', 'safe');
		$rules[] = array('password, verifyPassword', 'required');
		$rules[] = array('password', 'compare', 'compareAttribute' =>'verifyPassword', 'message' => Yii::t('UserModule.user', 'Retyped password is incorrect'));

		return $rules;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'password'=>Yii::t('UserModule.user', 'New password'),
			'verifyPassword'=>Yii::t('UserModule.user', 'Retype your new password'),
			'currentPassword'=>Yii::t('UserModule.user', 'Your actual password'),
		);
	}

	public function createRandomPassword() {

		$lowercase = Yii::app()->controller->module->minLowerCase;
		$uppercase = Yii::app()->controller->module->minUpperCase;
		$minnumbers = Yii::app()->controller->module->minDigits;
		$max = Yii::app()->controller->module->maxLen;

		$chars = "abcdefghijkmnopqrstuvwxyz";
		$numbers = "1023456789";
		srand((double) microtime() * 1000000);
		$i = 0;
		$current_lc = 0;
		$current_uc = 0;
		$current_dd = 0;
		$password = '';
		while ($i <= $max) {
			if ($current_lc < $lowercase) {
				$charnum = rand() % 22;
				$tmpchar = substr($chars, $charnum, 1);
				$password = $password . $tmpchar;
				$i++;
			}

			if ($current_uc < $uppercase) {
				$charnum = rand() % 22;
				$tmpchar = substr($chars, $charnum, 1);
				$password = $password . strtoupper($tmpchar);
				$i++;
			}

			if ($current_dd < $minnumbers) {
				$charnum = rand() % 9;
				$tmpchar = substr($numbers, $charnum, 1);
				$password = $password . $tmpchar;
				$i++;
			}

			if ($current_lc == $lowercase && $current_uc == $uppercase && $current_dd == $numbers && $i < $max) {
				$charnum = rand() % 22;
				$tmpchar = substr($chars, $charnum, 1);
				$password = $password . $tmpchar;
				$i++;
				if ($i < $max) {
					$charnum = rand() % 9;
					$tmpchar = substr($numbers, $charnum, 1);
					$password = $password . $tmpchar;
					$i++;
				}
				if ($i < $max) {
					$charnum = rand() % 22;
					$tmpchar = substr($chars, $charnum, 1);
					$password = $password . strtoupper($tmpchar);
					$i++;
				}
			}
		}
		return $password;
	}
}
