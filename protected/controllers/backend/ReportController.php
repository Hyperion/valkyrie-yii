<?php

class ReportController extends BackendController
{

    public function actions()
    {
        return array(
            'admin'  => 'application.components.actions.Admin',
            'update'  => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
        );
    }

    public function init()
    {
        parent::init();

        $assets  = Yii::getPathOfAlias('application.assets');
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if(is_dir($assets))
            $this->cs->registerScriptFile($baseUrl . '/jquery.inplacerowedit.js');
    }
}

