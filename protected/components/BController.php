<?php

class BController extends CController
{

    public $breadcrumbs = array();
    public $menu = array();
    public $ajaxLinks = array();
    public $ajaxOptions = array();
    public $class;
    protected $_model;
    private $_cs;
    private $_isAjax;

    function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function actions()
    {
        return array(
            'view'   => 'application.components.actions.View',
        );
    }

    public function init()
    {
        parent::init();
        $this->class = ($this->class) ? $this->class : ucfirst($this->id);
        Yii::setPathOfAlias('Base', __DIR__ . '/../models/Base');
        date_default_timezone_set('Europe/Moscow');

        $this->_cs = Yii::app()->clientScript;
        $this->_cs->registerPackage('jquery');
        $this->_cs->registerScriptFile('/js/local-common/core.js');
        $this->_cs->registerScriptFile('/js/local-common/tooltip.js');
        $this->_cs->registerScriptFile('/js/wow/wow.js', CClientScript::POS_END);
    }

    public function getCs()
    {
        if($this->_cs === null)
            $this->_cs = Yii::app()->getComponent('clientScript');

        return $this->_cs;
    }

    public function getIsAjax()
    {
        if($this->_isAjax === null)
            $this->_isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';

        return $this->_isAjax;
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
