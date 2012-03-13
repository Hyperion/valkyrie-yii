<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
    public function filters()
    {
        return array();
    }

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->user->returnUrl);
	}

}