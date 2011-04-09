<?php

class AdminController extends CController
{
	public $menu=array();

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
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function init() {
        Yii::app()->layout = "backend2";
    }

}