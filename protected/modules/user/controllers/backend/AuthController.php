<?php

class AuthController extends AdminController
{
    public $defaultAction = 'login';
    public $loginForm = null;

    public function accessRules() {
        return array(
            array('allow',
                'actions'=>array('login'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('logout'),
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function loginByUsername()
    {
        if($this->module->caseSensitiveUsers)
            $user = User::model()->find('username = :username', array(
                ':username' => $this->loginForm->username));
        else
            $user = User::model()->find('upper(username) = :username', array(
                ':username' => strtoupper($this->loginForm->username)));

        if($user)
            return $this->authenticate($user);
        else
            $this->loginForm->addError('password',
                Yii::t('UserModule.user', 'Username or Password is incorrect'));

        return false;
    }

    public function authenticate($user) {
        $identity = new UserIdentity($user->username, $this->loginForm->password);
        $identity->authenticate();
        switch($identity->errorCode) {
            case UserIdentity::ERROR_NONE:
                $duration = $this->loginForm->rememberMe ? 3600*24*30 : 0; // 30 days
                Yii::app()->user->login($identity,$duration);
                return $user;
                break;
            case UserIdentity::ERROR_EMAIL_INVALID:
                $this->loginForm->addError("password",Yii::t('UserModule.user', 'Username or Password is incorrect'));
                break;
            case UserIdentity::ERROR_STATUS_NOTACTIVE:
                $this->loginForm->addError("status",Yii::t('UserModule.user', 'This account is not activated.'));
                break;
            case UserIdentity::ERROR_STATUS_BANNED:
                $this->loginForm->addError("status",Yii::t('UserModule.user', 'This account is blocked.'));
                break;
            case UserIdentity::ERROR_STATUS_REMOVED:
                $this->loginForm->addError('status', Yii::t('UserModule.user', 'Your account has been deleted.'));
                break;

            case UserIdentity::ERROR_PASSWORD_INVALID:
                if(!$this->loginForm->hasErrors())
                    $this->loginForm->addError("password",Yii::t('UserModule.user', 'Username or Password is incorrect'));
                break;
                return false;
        }
    }

    public function loginByEmail()
    {
        $profile = Profile::model()->find('email = :email', array(
            ':email' => $this->loginForm->username));
        if($profile && $profile->user)
            return $this->authenticate($profile->user);

        return false;
    }

    public function loginByIpBoard()
    {
        $bridge = new IpbBridge;
        $bridge->db = $this->module->ipbConfig;
        if($bridge->getUserData(
            $this->loginForm->username,
            $this->loginForm->password)
        )
        {
            $user    = new User;

            $user->username  = $bridge->username;
            $user->superuser = $bridge->userRole;
            $user->status    = $bridge->userStatus;
            $user->setPassword($this->loginForm->password);

            if($user->save())
            {
                $profile = new Profile;
                $profile->user_id = $user->id;
                $profile->email   = $bridge->email;
                if($profile->save())
                    return $this->authenticate($user);
            }
        }

        return false;
    }

    public function actionLogin()
    {
        $this->layout = '//layouts/main';

        // If the user is already logged in send them to the users logged homepage
        //if (!Yii::app()->user->isGuest)
            //$this->redirect(Yii::app()->user->returnUrl);

        $this->loginForm = new FLogin('login');

        $success = false;
        $action = 'login';
        $login_type = null;
        if(isset($_POST['FLogin']))
        {
            $this->loginForm->attributes = $_POST['FLogin'];
            // validate user input for the rest of login methods
            if($this->loginForm->validate())
            {
                if($this->module->loginType & UserModule::LOGIN_BY_USERNAME)
                {
                    $success = $this->loginByUsername();
                    if($success)
                        $login_type = 'username';
                }
                if($this->module->loginType & UserModule::LOGIN_BY_EMAIL && !$success)
                {
                    $success = $this->loginByEmail();
                    if($success)
                        $login_type = 'email';
                }
                if($this->module->loginType & UserModule::LOGIN_BY_IPBOARD && !$success)
                {
                    $success = $this->loginByIpBoard();
                    if($success)
                        $login_type = 'ipboard';
                }
            }
        }
        if ($success instanceof User)
            $this->redirect(Yii::app()->user->returnUrl);

        $this->render('login', array(
            'model' => $this->loginForm));
    }

    public function actionLogout() {
        // If the user is already logged out send them to returnLogoutUrl
        if (Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->user->returnUrl);

        //let's delete the login_type cookie
        $cookie=Yii::app()->request->cookies['login_type'];
        if ($cookie) {
            $cookie->expire = time() - (3600*72);
            Yii::app()->request->cookies['login_type'] = $cookie;
        }

        if($user = User::model()->findByPk(Yii::app()->user->id))
        {
            $username = $user->username;
            $user->logout();

            Yii::app()->user->logout();
        }

        $this->redirect(Yii::app()->user->returnUrl);
    }
}
