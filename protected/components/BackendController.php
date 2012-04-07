<?php

class BackendController extends BController
{

    public $layout        = '//layouts/backend';
    public $defaultAction = 'admin';
    
    public function actions()
    {
        return array_merge(parent::actions(), array(
            'admin'  => 'application.components.actions.Admin',
        ));
    }

    public function init()
    {
        parent::init();

        //$this->menu = Yii::app()->cache->get('backendmenu');

        if(!$this->menu)
        {
            Yii::import("application.components.BackendMenu");
            BackendMenu::refreshXmlMenu();
            $this->menu = Yii::app()->cache->get('backendmenu');
        }
    }

    protected function beforeRender($view)
    {
        $this->cs->registerCssFile(Yii::app()->request->baseUrl . '/css/main.css');
        $this->cs->registerCssFile(Yii::app()->request->baseUrl . '/css/custom-theme/jquery-ui-1.8.16.custom.css');

        $assets  = Yii::getPathOfAlias('application.assets');
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if(is_dir($assets))
        {
            $this->cs->registerScriptFile($baseUrl . '/jquery.cleditor.min.js');
            $this->cs->registerScriptFile($baseUrl . '/jquery.cleditor.extimage.js');
            $this->cs->registerCssFile($baseUrl . '/jquery.cleditor.css');
        }
        else
        {
            throw new Exception('EClEditor - Error: Couldn\'t find assets to publish.');
        }

        return parent::beforeRender($view);
    }

}
