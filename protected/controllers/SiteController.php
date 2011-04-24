<?php

class SiteController extends Controller
{

	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

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

    public function actionLogin()
    {
        $model=new LoginForm;

        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('login',array('model'=>$model));
    }

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
                $model->save();
				$params = array(
					'{activation_url}' => $this->createAbsoluteUrl('/site/activation',
						array(
							'key'   => $model->hashCode,
							'email' => $model->email,
						)
					),
				);
                if($this->sendEmail('email_registration', $model->email, $params))
                    $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        $this->render('register',array('form'=>$form));
    }

    public function actionActivation($email = null, $key = null)
    {
        if(!Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->user->returnUrl);

        if(($email != null) and ($key != null) and (User::activate($email, $key) == true))
            $this->render('index');
        else
            $this->render('error');
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
                $model->password   = User::generatePassword();
                $model->status     = User::STATUS_REGISTER;
                $model->salt       = User::generateSalt();
                $model->password   = User::hashPassword($password, $model->salt);
                $model->save();
                if($this->sendEmail('email_recovery', $model->email, array('{password}' => $password)))
                    $this->redirect(Yii::app()->user->returnUrl);
            }
        }
    }

    private function sendEmail($template, $email, $params = array())
    {
        $content = TextSettings::model()->find('language = :lang AND name = :name',
			array(
				':lang' => Yii::app()->language,
				':name' => $template,
			)
		);
		
        $sent = null;

        if(is_object($content))
        {
            $body = strtr($content->text, $params);

            $mail = array(
                'from' 		=> Yii::app()->params['adminEmail'],
                'to' 		=> $email,
                'subject' 	=> $content->title,
                'body' 		=> $body,
                );
            $sent = Mailer::send($mail);
        }
        else
            throw new CException('The messages for your application language are not defined.');

        return $sent;
    }
}