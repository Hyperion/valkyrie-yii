<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $layout='//layouts/column1';
	public $menu=array();
	public $breadcrumbs=array();
    public $mainmenu=array();

	private $_model;

    public function init()
    {
        $menu = new Menu;
        $this->mainmenu = $menu->getData('mainmenu');
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
