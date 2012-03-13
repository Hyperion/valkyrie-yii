<?php

class ReportController extends BackendController
{

    public function actions()
    {
        return array(
            'admin'  => 'application.components.actions.Admin',
            'delete' => 'application.components.actions.Delete',
        );
    }

    public function init()
    {
        parent::init();

        $assets  = Yii::getPathOfAlias('application.assets');
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if(is_dir($assets))
            $this->cs->registerScriptFile($baseUrl . '/jquery.jeditable.min.js');
    }

    public function actionUpdate()
    {
        if($this->isAjax)
        {
            $model = $this->loadModel($_POST['id']);
            $model->setStatus($_POST['status']);
            $model->save(array('status'));
            
            echo $model->statusText;
            
            Yii::app()->end();
        }
    }
}

