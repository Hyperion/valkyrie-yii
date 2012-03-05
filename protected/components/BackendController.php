<?php

class BackendController extends CController
{

    public $menu = array();
    public $breadcrumbs = array();
    public $layout        = '//layouts/backend';
    public $defaultAction = 'admin';
    public $class         = '';
    private $_model;
    protected $_cs;

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
        $this->_cs = Yii::app()->clientScript;
        $this->_cs->registerPackage('jquery');
        $this->_cs->registerPackage('jquery.ui');
        $this->_cs->registerCssFile(Yii::app()->request->baseUrl . '/css/main.css');
        $this->_cs->registerCssFile(Yii::app()->request->baseUrl . '/css/custom-theme/jquery-ui-1.8.16.custom.css');

        $this->menu = Yii::app()->cache->get('backendmenu');

        if(!$this->menu)
        {
            Yii::import("application.components.BackendMenu");
            BackendMenu::refreshXmlMenu();
            $this->menu = Yii::app()->cache->get('backendmenu');
        }
    }

    public function actionHandleUpload()
    {
        $file = CUploadedFile::getInstanceByName('imageName');
        $name = md5($file->name . time()) . '.' . $file->extensionName;
        $file->saveAs(Yii::getPathOfAlias('application') . '/../uploads/' . $name);
        echo '<div id="image">/uploads/' . $name . '</div>';
    }

    public function loadModel($id)
    {
        if($this->_model === null)
        {
            $this->_model = CActiveRecord::model($this->class)->findByPk($id);
            if($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
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
