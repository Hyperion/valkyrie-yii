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

    public function attributeLabels()
    {
        return array(
            'username'   => Yii::t('UserModule.user', 'Username'),
            'password'   => Yii::t('UserModule.user', 'Password'),
            'rememberMe' => Yii::t('UserModule.user', 'Remember me next time'),
        );
    }

    public function authenticate($user)
    {
        $identity = new UserIdentity($user->username, $this->password);
        $identity->authenticate();
        switch($identity->errorCode)
        {
            case UserIdentity::ERROR_NONE:
                $duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
                Yii::app()->user->login($identity,$duration);
                return $user;
                break;
            case UserIdentity::ERROR_EMAIL_INVALID:
                $this->addError("password",Yii::t('UserModule.user', 'Username or Password is incorrect'));
                break;
            case UserIdentity::ERROR_STATUS_NOTACTIVE:
                $this->addError("status",Yii::t('UserModule.user', 'This account is not activated.'));
                break;
            case UserIdentity::ERROR_STATUS_BANNED:
                $this->addError("status",Yii::t('UserModule.user', 'This account is blocked.'));
                break;
            case UserIdentity::ERROR_STATUS_REMOVED:
                $this->addError('status', Yii::t('UserModule.user', 'Your account has been deleted.'));
                break;
            case UserIdentity::ERROR_PASSWORD_INVALID:
                $this->addError("password",Yii::t('UserModule.user', 'Username or Password is incorrect'));
                break;
        }

        return false;
    }
}
