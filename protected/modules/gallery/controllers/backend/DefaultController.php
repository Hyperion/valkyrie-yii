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


        $model = new GalleryConfigForm;
        $model->attributes = Yii::app()->config->get('gallery');

        if(isset($_POST['GalleryConfigForm']))
        {
            $model->attributes = $_POST['GalleryConfigForm'];
            Yii::app()->config->set('gallery', $model->attributes);
            Yii::app()->user->setFlash('success', 'Настройки успешно обновлены.');
            Yii::app()->saveGlobalState();
            $this->refresh();
        }
        $this->render('index', array('model' => $model));
    }

}
