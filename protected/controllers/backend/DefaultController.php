<?php

class DefaultController extends BackendController
{

    public $defaultAction = 'index';

    public function actions()
    {
        return array();
    }

    public function actionIndex()
    {


        $model = new ConfigForm;
        $model->attributes = Yii::app()->config->get('system');

        if(isset($_POST['ConfigForm']))
        {
            $model->attributes = $_POST['ConfigForm'];
            Yii::app()->config->set('system', $model->attributes);
            Yii::app()->user->setFlash('success', 'Настройки успешно обновлены.');
            Yii::app()->saveGlobalState();
            $this->refresh();
        }
        $this->render('index', array('model' => $model));
    }

    public function actionError()
    {
        if($error = Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
