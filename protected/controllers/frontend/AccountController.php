<?php

class AccountController extends CpController
{
    public $layout='//layouts/cp';
    public $usermenu = array();

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionChangePass()
    {
    }

    public function actionChangeEmail()
    {
    }
}
