<?php

class BBootGallery extends CWidget
{

    public $showViewLink = false;
    public $images = array();
    
    public function run()
    {
        if(!Yii::app()->getComponent('request')->getIsAjaxRequest())
        {
            $assets  = Yii::getPathOfAlias('application.components.widgets.assets.blueimp');
            $baseUrl = Yii::app()->getComponent('assetManager')->publish($assets);
            if(is_dir($assets))
            {
                $cs = Yii::app()->getClientScript();

                $cs->registerScriptFile($baseUrl . '/tmpl.min.js');
                $cs->registerScriptFile($baseUrl . '/load-image.min.js');
                $cs->registerScriptFile($baseUrl . '/canvas-to-blob.min.js');
                $cs->registerScriptFile($baseUrl . '/bootstrap-image-gallery.min.js', CClientScript::POS_END);
                $cs->registerCssFile($baseUrl . '/bootstrap-image-gallery.min.css');
            }
        }

        $this->render('BBootGallery', array('showViewLink' => $this->showViewLink, 'images' => $this->images));
    }

}