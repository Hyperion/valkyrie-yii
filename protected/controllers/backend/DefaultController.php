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
        $model->name = Yii::app()->config->get('site_name'); //Yii::app()->name;
        $model->email = Yii::app()->config->get('adminEmail'); //Yii::app()->params['adminEmail'];
        $model->description = Yii::app()->config->get('description'); //Yii::app()->params['description'];
        $model->keywords = Yii::app()->config->get('keywords'); //Yii::app()->params['keywords'];
        $model->contact_info = Yii::app()->config->get('contact_info'); //Yii::app()->params['contact_info'];
        $model->title = Yii::app()->config->get('title');
        $model->info_email = Yii::app()->config->get('info_email');
        $model->phone1 = Yii::app()->config->get('phone1');
        $model->phone2 = Yii::app()->config->get('phone2');
        $model->adress = Yii::app()->config->get('adress');
        $model->main_page = Yii::app()->config->get('main_page');

        if(isset($_POST['ConfigForm']))
        {
            //var_dump($_POST['ConfigForm']);return;
            $model->attributes = $_POST['ConfigForm'];
            //var_dump($model);return;
            Yii::app()->config->set('site_name', $model->name);
            Yii::app()->config->set('adminEmail', $model->email);
            Yii::app()->config->set('description', $model->description);
            Yii::app()->config->set('keywords', $model->keywords);
            Yii::app()->config->set('contact_info', $model->contact_info);
            Yii::app()->config->set('title', $model->title);
            Yii::app()->config->set('info_email', $model->info_email);
            Yii::app()->config->set('phone1', $model->phone1);
            Yii::app()->config->set('phone2', $model->phone2);
            Yii::app()->config->set('adress', $model->adress);
            Yii::app()->config->set('main_page', $model->main_page);
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
