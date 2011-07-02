<?php

class AdminController extends CController
{
    public $menu = array();
    public $breadcrumbs=array();
    public $layout = '//layouts/backend';

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
        $cs = Yii::app()->clientScript;
        $cs->registerPackage('jquery');

        $menu = new Menu;
        $this->menu = $menu->getData('backendmenu');
    }
}
