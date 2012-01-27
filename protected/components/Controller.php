<?php

class Controller extends CController
{
    protected $_model;
    protected $_cs;

    public $breadcrumbs;
    public $layout='//layouts/column1';

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
}
