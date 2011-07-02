<?php

class AuthController extends Controller
{
    public $defaultAction = 'login';
    public $loginForm = null;

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('login', 'facebook'),
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

    public function loginByFacebook() {
        if (!$this->module->loginType & UserModule::LOGIN_BY_FACEBOOK)
            throw new Exception('actionFacebook was called, but is not activated in application configuration');

        Yii::app()->user->logout();
        Yii::import('application.modules.user.vendors.facebook.*');
        $facebook = new Facebook($this->module->facebookConfig);
        $fb_uid = $facebook->getUser();
        if ($fb_uid) {
            $profile = Profile::model()->findByAttributes(array('facebook_id' => $fb_uid));
            $user = ($profile) ? User::model()->findByPk($profile->user_id) : null;
            try {
                $fb_user = $facebook->api('/me');
                if (isset($fb_user['email']))
                    $profile = Profile::model()->findByAttributes(array('email' => $fb_user['email']));
                else
                    return false;
                if ($user === null && $profile === null) {
                    // New account
                    $user = new User;
                    $user->username = 'fb_'.RegistrationForm::genRandomString($this->module->usernameRequirements['maxLen'] - 3);
                    $user->password = User::encrypt(UserChangePassword::createRandomPassword());
                    $user->activationKey = User::encrypt(microtime().$user->password);
                    $user->createtime = time();
                    $user->superuser = 0;
                    if ($user->save()) {
                        $profile = new Profile;
                        $profile->user_id = $user->id;
                        $profile->facebook_id = $fb_user['id'];
                        $profile->email = $fb_user['email'];
                        $profile->save(false);
                    }
                } else {
                    //Current account and FB account blending
                    $profile->facebook_id = $fb_uid;
                    $profile->save(false);
                    $user->username = 'fb_'.RegistrationForm::genRandomString($this->module->usernameRequirements['maxLen'] - 3);

                    $user->superuser = 0;
                    $user->save();
                }

                $identity = new UserIdentity($fb_uid, $user->id);
                $identity->authenticateFacebook(true);

                switch ($identity->errorCode) {
                    case UserIdentity::ERROR_NONE:
                        $duration = 3600*24*30; //30 days
                        Yii::app()->user->login($identity, $duration);
                        return $user;
                        break;
                    case UserIdentity::ERROR_STATUS_NOTACTIVE:
                        $user->addError('status', Yii::t('UserModule.user', 'Your account is not activated.'));
                        break;
                    case UserIdentity::ERROR_STATUS_BANNED:
                        $user->addError('status', Yii::t('UserModule.user', 'Your account is blocked.'));
                        break;
                    case UserIdentity::ERROR_PASSWORD_INVALID:
                        $user->addError('status', Yii::t('UserModule.user', 'Password incorrect.'));
                        break;
                }
                return false;
            } catch (FacebookApiException $e) {
                /* FIXME: Workaround for avoiding the 'Error validating access token.'
                 * inmediatly after a user logs out. This is nasty. Any other
                 * approach to solve this issue is more than welcomed.
                 */
                return false;
            }
        }
        else
            return false;
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
            return $this->loginForm->authenticate($user);
        else
            $this->loginForm->addError('password',
                Yii::t('UserModule.user', 'Username or Password is incorrect'));

        return false;
    }

    public function loginByEmail() {
        $profile = Profile::model()->find('email = :email', array(
                    ':email' => $this->loginForm->username));
        if($profile && $profile->user)
            return $this->loginForm->authenticate($profile->user);

        return false;
    }

    public function actionLogin()
    {
        // If the user is already logged in send them to the users logged homepage
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->user->returnUrl);

        $this->loginForm = new FLogin('login');

        $success = false;
        $action = 'login';
        $login_type = null;
        if (isset($_POST['FLogin'])) {
            $this->loginForm->attributes = $_POST['FLogin'];
            // validate user input for the rest of login methods
            if ($this->loginForm->validate()) {
                if ($this->module->loginType & UserModule::LOGIN_BY_USERNAME) {
                    $success = $this->loginByUsername();
                    if ($success)
                        $login_type = 'username';
                }
                if ($this->module->loginType & UserModule::LOGIN_BY_EMAIL && !$success) {
                    $success = $this->loginByEmail();
                    if ($success)
                        $login_type = 'email';
                }
            }
        }
        if ($this->module->loginType & UserModule::LOGIN_BY_FACEBOOK && !$success) {
            $success = $this->loginByFacebook();
            if ($success)
                $login_type = 'facebook';
        }
        if ($success instanceof User) {
            //cookie with login type for later flow control in app
            if ($login_type) {
                $cookie = new CHttpCookie('login_type', serialize($login_type));
                $cookie->expire = time() + (3600*24*30);
                Yii::app()->request->cookies['login_type'] = $cookie;
            }
            if ($success->status == User::STATUS_ACTIVATED) {
                $success->status = User::STATUS_ACTIVE_FIRST_VISIT;
                $success->save('status', false);
            } else if ($success->status == User::STATUS_ACTIVE_FIRST_VISIT) {
                $success->status = User::STATUS_ACTIVE;
                $success->save('status', false);
            }
            $this->redirectUser($success);
        }

        $this->render('/user/login', array(
            'model' => $this->loginForm));
    }

    public function redirectUser($user)
    {
        if(isset(Yii::app()->user->returnUrl))
            $this->redirect(Yii::app()->user->returnUrl);

        if ($user->superuser) {
            $this->redirect($this->module->returnAdminUrl);
        } else {
            if ($user->isPasswordExpired())
                $this->redirect(array('passwordexpired'));
            else if($user->lastvisit == 0) {
                $user->lastvisit = time();
                $user->save(true, array('lastvisit'));
                $this->redirect($this->module->firstVisitUrl);
            }
            else if ($this->module->returnUrl !== '')
                $this->redirect($this->module->returnUrl);
            else
                $this->redirect(Yii::app()->user->returnUrl);
        }
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

        if($user = User::model()->findByPk(Yii::app()->user->id)) {
            $username = $user->username;
            $user->logout();

            if (Yii::app()->user->name == 'facebook') {
                if (!$this->module->loginType & UserModule::LOGIN_BY_FACEBOOK)
                    throw new Exception('actionLogout for Facebook was called, but is not activated in main.php');

                Yii::import('application.modules.user.vendors.facebook.*');
                require_once('Facebook.php');
                $facebook = new Facebook($this->module->facebookConfig);
                $fb_cookie = 'fbs_'.$this->module->facebookConfig['appId'];
                $cookie = Yii::app()->request->cookies[$fb_cookie];
                if ($cookie) {
                    $cookie->expire = time() -1*(3600*72);
                    Yii::app()->request->cookies[$cookie->name] = $cookie;
                }
                $session = $facebook->getSession();
                Yii::app()->user->logout();
                $this->redirect($facebook->getLogoutUrl(array('next' => $this->createAbsoluteUrl($this->module->returnLogoutUrl), 'session_key' => $session['session_key'])));
            }
            else {
                Yii::app()->user->logout();
            }
        }
        $this->redirect(Yii::app()->user->returnUrl);
    }
}
