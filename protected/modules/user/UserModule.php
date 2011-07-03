<?php

class UserModule extends CWebModule
{

    public $offlineIndicationTime = 3600; // 5 Minutes
    public $caseSensitiveUsers = false;

    public $avatarPath = 'images';
    public $avatarMaxWidth = 200;
    public $avatarThumbnailWidth = 50;
    public $avatarDisplayWidth = 200;

    public $password_expiration_time = 30;
    public $activationPasswordSet = false;
    public $autoLogin = false;
    public $activateFromWeb = true;
    public $recoveryFromWeb = false;

    public $registrationEmail='register@website.com';
    public $recoveryEmail='restore@website.com';
    public $facebookConfig = false;
    public $pageSize = 10;

    public $notifyType = 'user';

    public $messageSystem = Message::MSG_DIALOG;

    public $salt = '';
    public $hashFunc = 'md5';

    public static $dateFormat = "m-d-Y";
    public $dateTimeFormat = 'm-d-Y G:i:s';

    const LOGIN_BY_USERNAME     = 1;
    const LOGIN_BY_EMAIL        = 2;
    const LOGIN_BY_OPENID       = 4;
    const LOGIN_BY_FACEBOOK     = 8;
    const LOGIN_BY_IPBOARD      = 16;

    public $loginType = 19;

    public $passwordRequirements = array(
        'minLen' => 8,
        'maxLen' => 32,
        'minLowerCase' => 1,
        'minUpperCase'=>0,
        'minDigits' => 1,
        'maxRepetition' => 3,
    );

    public $usernameRequirements=array(
        'minLen'=>3,
        'maxLen'=>30,
        'match' => '/^[A-Za-z0-9_]+$/u',
        'dontMatchMessage' => 'Incorrect symbol\'s. (A-z0-9)',
    );

    public $ipbConfig = array(
        'connectionString' => 'mysql:host=localhost;dbname=val_ipbforum',
        'username' => 'root',
        'password' => 'ktutylf0pb',
        'charset' => 'utf8',
        'tablePrefix'=>'ipb_',
    );

    public function init()
    {
        $this->setImport(array(
            'user.components.*',
        ));

        Yii::app()->onModuleCreate(new CEvent($this));
    }
}
