<?php

class RegistrationController extends CController
{
    public $defaultAction = 'registration';

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'registration', 'recovery', 'activation', 'resendactivation'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('captcha'),
                'users' => array('*'),
            ),
            array('deny', // deny all other users
                'users' => array('*'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    public function actionRegistration()
    {
        $form = new FRegistration;
        $profile = new Profile;

        if(isset($_POST['FRegistration']))
        {
            $form->attributes = $_POST['FRegistration'];
            $profile->attributes = $_POST['Profile'];

            $form->validate();
            $profile->validate();

            if(!$form->hasErrors() && !$profile->hasErrors())
            {
                $user = new User;
                $user->register($form->username, $form->password, $profile);

                //$this->sendRegistrationEmail($user);
                Core::setFlash('Thank you for your registration. Please check your email.');
                $this->redirect(Yii::app()->user->loginUrl);
            }
        }

        $this->render('registration', array(
            'form' => $form,
            'profile' => $profile,
        ));
    }

    public function sendRegistrationEmail($user)
    {
        if (!isset($user->profile->email)) {
            throw new CException(Yii::t('UserModule.user', 'Email is not set when trying to send Registration Email'));
        }
        $activation_url = $this->createAbsoluteUrl('registration/activation', array(
            'key' => $user->activationKey,
            'email' => $user->profile->email)
        );

        $content = TextSettings::model()->find('language = :lang', array(
            'lang' => Yii::app()->language));
        $sent = null;

        if (is_object($content))
        {
            $body = strtr($content->text_email_registration, array(
                '{username}' => $user->username,
                '{activation_url}' => $activation_url
            ));

            $mail = array(
                'from' => $this->module->registrationEmail,
                'to' => $user->profile->email,
                'subject' => strtr($content->subject_email_registration, array(
                    '{username}' => $user->username)),
                'body' => $body,
            );

            $sent = YumMailer::send($mail);
        }
        else
        {
            throw new CException(Yii::t('UserModule.user', 'The messages for your application language are not defined.'));
        }

        return $sent;
    }

    public function actionActivation($email=null, $key=null)
    {
        // If already logged in, we dont activate anymore
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->user->returnUrl);

        // If everything is set properly, let the model handle the Validation
        // and do the Activation
        if ($email != null && $key != null)
        {
            if (User::activate($email, $key) != false)
                $this->render($this->module->activationSuccessView);
            else
                $this->render($this->module->activationFailureView);
        }
    }

    public function actionRecovery($email = null, $key = null)
    {
        $form = new FRecovery;

        if ($email != null && $key != null)
        {
            if($profile = Profile::model()->find("email = '{$email}'"))
            {
                $user = $profile->user;
                if($user->activationKey == $key)
                {
                    $passwordform = new FChangePassword;
                    if(isset($_POST['FChangePassword']))
                    {
                        $passwordform->attributes = $_POST['FChangePassword'];
                        if($passwordform->validate())
                        {
                            $user->password = User::encrypt($passwordform->password);
                            $user->activationKey = User::encrypt(microtime() . $passwordform->password);
                            $user->save();
                            Core::setFlash('Your new password has been saved.');
                            $this->redirect($this->module->loginUrl);
                        }
                    }
                    $this->render($this->module->recoveryChangePasswordView, array('form' => $passwordform));
                }
            }
        }
        else
        {
            if(isset($_POST['FRecovery']))
            {
                $form->attributes = $_POST['FRecovery'];
                if ($form->validate())
                {
                    $user = User::model()->findbyPk($form->user_id);
                    $activation_url = $this->createAbsoluteUrl(
                        'registration/recovery',
                        array(
                            'key' => $user->activationKey,
                            'email' => $user->profile->email,
                        )
                    );
                    if($this->module->enableLogging == true)
                        Core::log(Yii::t('UserModule.user', '{username} requested a new password in the password recovery form', array('{username}' => $user->username)));

                    $content = TextSettings::model()->find('language = :lang', array('lang' => Yii::app()->language));
                    $sent = null;

                    if(is_object($content))
                    {
                        $mail = array(
                            'from' => Yii::app()->params['adminEmail'],
                            'to' => $user->profile->email,
                            'subject' => $content->subject_email_registration,
                            'body' => strtr($content->text_email_recovery, array('{activation_url}' => $activation_url)),
                        );
                        $sent = YumMailer::send($mail);

                        Core::setFlash('Instructions have been sent to you. Please check your email.');
                        $this->redirect($this->module->loginUrl);
                    }
                    else
                    {
                        throw new CException(Yii::t('UserModule.user', 'The messages for your application language are not defined.'));
                    }
                }
            }
            $this->render($this->module->recoveryView, array('form' => $form));
        }
    }
}
