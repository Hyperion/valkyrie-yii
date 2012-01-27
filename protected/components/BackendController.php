<?php

class BackendController extends CController
{

    public $menu = array();
    public $breadcrumbs = array();
    public $layout = '//layouts/backend';
    public $defaultAction = 'admin';
    public $class = '';

    public function filters()
    {
        return array(
            'accessControl',
            //array('application.components.backend.filters.Breadcrumbs - login, delete'),
            //array('application.components.backend.filters.PageTitle - login, delete'),
        );
    }

    public function actions()
    {
        return array(
            'admin' => 'application.components.backend.actions.Admin',
            'create' => 'application.components.backend.actions.Create',
            'update' => 'application.components.backend.actions.Update',
            'delete' => 'application.components.backend.actions.Delete',
            'view' => 'application.components.backend.actions.View',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'expression' => 'Yii::app()->getModule(\'user\')->isAdmin()',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
    
    public function init()
    {
        parent::init();

        $this->class = ($this->class) ? $this->class : ucfirst($this->id);
        $cs = Yii::app()->clientScript;
        $cs->registerPackage('jquery');
        $cs->registerPackage('jquery.ui');

        Yii::import("application.components.AdminMenu");

        $this->menu = AdminMenu::getData();
    }
    
    public function setFlash($key,$value) {
        Yii::app()->user->setFlash($key,$value);
    }

    public function getFlash($key) {
        return Yii::app()->user->getFlash($key);
    }

    public function hasFlash($key) {
        return Yii::app()->user->hasFlash($key);
    }
    
    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->class)->findByPk($id);
        if($model === null)
        {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->class) . '-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
