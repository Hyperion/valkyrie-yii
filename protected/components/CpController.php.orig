<?php

class CpController extends Controller
{
    public $layout='//layouts/cp';

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
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function init()
    {
        $this->_cs = Yii::app()->clientScript;
        $this->_cs->registerPackage('jquery');
        $this->_cs->registerScriptFile('/js/local-common/core.js');
        $this->_cs->registerScriptFile('/js/local-common/tooltip.js');
        $this->_cs->registerScriptFile('/js/account/bam.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/local-common/menu.js', CClientScript::POS_END);
    }
}
