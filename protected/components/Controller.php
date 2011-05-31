<?php

class Controller extends CController
{
    protected $_model;
    protected $_cs;
    protected $body_class;
    
    public $breadcrumbs;

    public function init()
    {
    	$this->_cs = Yii::app()->clientScript;
    	$this->_cs->registerPackage('jquery');
    	$this->_cs->registerScriptFile('/js/local-common/core.js');
    	$this->_cs->registerScriptFile('/js/local-common/tooltip.js');
    	$this->_cs->registerScriptFile('/js/wow/wow.js', CClientScript::POS_END);
    }

    protected function performAjaxValidation($model, $form) {
        if(isset($_POST['ajax']) && $_POST['ajax'] == $form) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function loadModel($model = false)
    {
        if(!$model)
            $model = str_replace('Controller', '', get_class($this));

        if($this->_model === null) {
            if(isset($_GET['id']))
                $this->_model = CActiveRecord::model($model)->findbyPk($_GET['id']);

            if($this->_model===null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }
}
