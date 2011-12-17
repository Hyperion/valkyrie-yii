<?php

class AdminController extends CController
{
    public $menu = array();
    public $breadcrumbs=array();
    public $layout = '//layouts/backend';
    public $defaultAction = 'admin';
    
    /*public function filters()
    {
        return array(
            'accessControl',
        );
    }*/

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
        $cs->registerPackage('jquery.ui');

        Yii::import("application.components.AdminMenu");
        
        $this->menu = AdminMenu::getData();
    }
}
