<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionRegister()
    {
        $form = new RegisterForm();

        if(isset($_POST['RegisterForm']))
        {
            $form->attributes=$_POST['RegisterForm'];
            if($form->validate())
            {
                $model = new User();
                $model->attributes = $form->attributes;
                $model->role       = User::ROLE_USER;
                $model->status     = User::STATUS_REGISTER;
                $model->hashCode   = md5($model->email . uniqid());
                $model->salt       = User::generateSalt();
                $model->password   = User::hashPassword($model->password, $model->salt);
                $model->save();
                if($this->sendRegistrationEmail($model))
                    $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        $this->render('register',array('form'=>$form));
    }

    public function actionActivation($email=null, $key=null)
    {
        if (!Yii::app()->user->isGuest)
          $this->redirect(Yii::app()->user->returnUrl);

        if ($email != null && $key != null)
        {
            if (User::activate($email, $key) != false) 
                $this->render('index');
            else
                $this->render('error');
        }
    }

    public function actionRecovery()
    {
        $form = new RecoveryForm();

        if(isset($_POST['RecoveryForm']))
        {
            $form->attributes=$_POST['RecoveryForm'];
            if($form->validate())
            {
                $model = User::model()->find("email = '{$form->email}'");
                $password = User::generatePassword();
                $model->status     = User::STATUS_REGISTER;
                $model->salt       = User::generateSalt();
                $model->password   = User::hashPassword($password, $model->salt);
                $model->save();
                if($this->sendRecoveryEmail($model, $password))
                    $this->redirect(Yii::app()->user->returnUrl);
            }
        }
    }

    private function sendRegistrationEmail($model)
    {
        if (!isset($model->email)) {
            throw new CException('Email is not set when trying to send Registration Email');
        }
        $activation_url = $this->createAbsoluteUrl('/site/activation', array(
            'key' => $model->hashCode,
            'email' => $model->email)
        );

        $content = TextSettings::model()->find('language = :lang AND name = :name', array(
            'lang' => Yii::app()->language,
            'name' => 'email_registration'));
        $sent = null;

        if (is_object($content))
        {
            $body = strtr($content->text, array(
                '{activation_url}' => $activation_url));

            $mail = array(
                'from' => Yii::app()->params['adminEmail'],
                'to' => $model->email,
                'subject' => 'You have registered for an application',
                'body' => $body,
                );
            $sent = Mailer::send($mail);
        }
        else {
            throw new CException('The messages for your application language are not defined.');
        }

        return $sent;
    }

    private function sendRecoveryEmail($model, $password)
    {
        if (!isset($model->email)) {
            throw new CException('Email is not set when trying to send Recovery Email');
        }

        $content = TextSettings::model()->find('language = :lang AND name = :name', array(
            'lang' => Yii::app()->language,
            'name' => 'email_recovery'));
        $sent = null;

        if (is_object($content))
        {
            $body = strtr($content->text, array(
                '{password}' => $password));

            $mail = array(
                'from' => Yii::app()->params['adminEmail'],
                'to' => $model->email,
                'subject' => 'You have registered for an application',
                'body' => $body,
                );
            $sent = Mailer::send($mail);
        }
        else {
            throw new CException('The messages for your application language are not defined.');
        }

        return $sent;
    }
}