<?php

class Controller extends CController
{

    protected $_cs;
    public $breadcrumbs = array();
    public $layout = '//layouts/column1';
    public $class;
    public $menu   = array();
    private $_model;
    private $_pageCaption     = null;
    private $_pageDescription = null;

    public function init()
    {
        parent::init();

        $this->class = ($this->class) ? $this->class : ucfirst($this->id);
        Yii::app()->bootstrap->registerCoreCss();
        $this->_cs = Yii::app()->clientScript;
        $this->_cs->registerPackage('jquery');
    }

    protected function performAjaxValidation($model, $form)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == $form)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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

    public function getPageCaption()
    {
        if ($this->_pageCaption !== null)
            return $this->_pageCaption;
        else
        {
            $name = ucfirst(basename($this->getId()));
            if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
                return $this->_pageCaption = $name.' '.ucfirst($this->getAction()->getId());
            else
                return $this->_pageCaption = $name;
        }
    }

    public function setPageCaption($value)
    {
        $this->_pageCaption = $value;
    }

    public function getPageDescription()
    {
        if ($this->_pageDescription !== null)
            return $this->_pageDescription;
        else
        {
            return '' /*Yii::app()->name.' '.$this->getPageCaption().' page'*/;
        }
    }

    public function setPageDescription($value)
    {
        $this->_pageDescription = $value;
    }
}
