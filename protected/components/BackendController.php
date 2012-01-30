<?php

class BackendController extends CController
{

    public $menu = array();
    public $breadcrumbs = array();
    public $layout        = '//layouts/backend';
    public $defaultAction = 'admin';
    public $class         = '';
    private $_model;

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
            'admin'  => 'application.components.backend.actions.Admin',
            'create' => 'application.components.backend.actions.Create',
            'update' => 'application.components.backend.actions.Update',
            'delete' => 'application.components.backend.actions.Delete',
            'view'   => 'application.components.backend.actions.View',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'expression' => 'Yii::app()->user->isSuperuser',
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
        Yii::app()->bootstrap->registerCoreCss();
        $cs = Yii::app()->clientScript;
        $cs->registerPackage('jquery');
        $cs->registerPackage('jquery.ui');
        $cs->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css');

        Yii::import("application.components.AdminMenu");

        $this->menu = AdminMenu::getData();
        $this->menu = array_merge($this->menu, array(
		array(
			'label'=>Rights::t('core', 'Assignments'),
			'url'=>array('/rights/assignment/view'),
			'itemOptions'=>array('class'=>'item-assignments'),
		),
		array(
			'label'=>Rights::t('core', 'Permissions'),
			'url'=>array('/rights/authItem/permissions'),
			'itemOptions'=>array('class'=>'item-permissions'),
		),
		array(
			'label'=>Rights::t('core', 'Roles'),
			'url'=>array('/rights/authItem/roles'),
			'itemOptions'=>array('class'=>'item-roles'),
		),
		array(
			'label'=>Rights::t('core', 'Tasks'),
			'url'=>array('/rights/authItem/tasks'),
			'itemOptions'=>array('class'=>'item-tasks'),
		),
		array(
			'label'=>Rights::t('core', 'Operations'),
			'url'=>array('/rights/authItem/operations'),
			'itemOptions'=>array('class'=>'item-operations'),
		),
	));
    }

    public function loadModel($id)
    {
        if ($this->_model === null)
        {
            $this->_model = CActiveRecord::model($this->class)->findByPk($id);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->class).'-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
