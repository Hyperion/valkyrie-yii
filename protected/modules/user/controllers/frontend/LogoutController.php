<?php

class LogoutController extends Controller
{
    function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    public $defaultAction = 'logout';

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->user->returnUrl);
    }

}