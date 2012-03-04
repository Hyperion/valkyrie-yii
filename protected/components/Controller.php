<?php

class Controller extends CController
{

    protected $_cs;
    protected $_model;
    public $breadcrumbs = array();
    public $layout = '//layouts/column1';
    public $class;
    public $menu   = array();
    private $_pageDescription = null;
    private $_pageKeywords    = null;
    private $_pageCaption     = null;

    public function init()
    {
        parent::init();

        $this->class = ($this->class) ? $this->class : ucfirst($this->id);
        $this->_cs = Yii::app()->clientScript;
        $this->_cs->registerPackage('jquery');
    }

    protected function performAjaxValidation($model, $form)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] == $form)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function beforeRender($view)
    {
        $this->pageTitle = Yii::app()->config->get('title');
        $this->pageKeywords = Yii::app()->config->get('keywords');
        $this->pageDescription = Yii::app()->config->get('description');

        if(is_object($this->_model))
        {
            if(isset($this->_model->title) && $this->_model->title)
            {
                $this->pageTitle .= ' - ' . $this->_model->title;
                $this->pageCaption = $this->_model->title;
            }
            if(isset($this->_model->meta) && $this->_model->meta)
                $this->pageDescription = $this->_model->meta;
            if(isset($this->_model->keywords) && $this->_model->keywords)
                $this->pageKeywords = $this->_model->keywords;
        }

        return parent::beforeRender($view);
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

    public function getPageDescription()
    {
        if($this->_pageDescription !== null)
            return $this->_pageDescription;
        else
        {
            return '';
        }
    }

    public function setPageDescription($value)
    {
        $this->_pageDescription = $value;
    }

    public function getPageKeywords()
    {
        if($this->_pageKeywords !== null)
            return $this->_pageKeywords;
        else
        {
            return '';
        }
    }

    public function setPageKeywords($value)
    {
        $this->_pageKeywords = $value;
    }

    public function getPageCaption()
    {
        if($this->_pageCaption !== null)
            return $this->_pageCaption;
        else
        {
            return '';
        }
    }

    public function setPageCaption($value)
    {
        $this->_pageCaption = $value;
    }

}
