<?php

class CpController extends Controller
{
    public $layout='//layouts/cp';
    public $usermenu = array();

    public function init()
    {
        parent::init();
        $menu = new Menu;
        $this->usermenu = $menu->getData('usermenu');
    }

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