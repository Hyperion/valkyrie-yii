<?php

class BController extends RController
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
            'rights',
            array('ESetReturnUrlFilter'),
        );
    }

    public function accessRules()
    {
        $ips = Yii::app()->getDb()->createCommand('SELECT mask FROM blocked_ips')->queryColumn();
        if(count($ips))
            return array(
                array('deny',
                    'ips' => $ips,
                ),
            );
        else
            return array();
    }

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'view'   => 'application.components.actions.View',
        );
    }

    public function init()
    {
        parent::init();
        
        $this->class = ($this->class) ? $this->class : ucfirst($this->id);
        
        if(!$this->isAjax)
        {
            $this->getCs()->registerPackage('jquery');
            $this->getCs()->registerPackage('jquery.ui');
        }
    }

    public function actionHandleUpload()
    {
        $file = CUploadedFile::getInstanceByName('imageName');
        $name = md5($file->getName() . time()) . '.' . $file->getExtensionName();
        $file->saveAs(Yii::getPathOfAlias('application') . '/../uploads/' . $name);
        echo '<div id="image">/uploads/' . $name . '</div>';
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
