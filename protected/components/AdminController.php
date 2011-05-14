<?php

class AdminController extends CController
{
	public $menu = array();
	public $backendmenu;
	public $breadcrumbs=array();

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'expression'=>'$user->isAdmin()',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function init()
	{
		$menu = new Menu;
        $this->backendmenu = $menu->getData('backendmenu');
		$this->backendmenu['items'][] = array('label'=>'View Site', 'url'=>array('/site'));
        Yii::app()->layout = 'backend2';

		$log = new AdminAccess();
		$log->action = Yii::app()->request->url;
		$log->save();
    }
}
